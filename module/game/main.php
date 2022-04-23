<?php

class module_game extends abstract_module {

    private $game = null;

    public function before() {

//recueraton de la partie en cours
        if (isset($_SESSION['game'])) {
            $this->game = $_SESSION['game'];
        }
        $this->oLayout = new _layout('staten');
        $this->oLayout->addModule('menu', 'menu::index');

        if (isset($_SESSION['game'])) {
            plugin_debug::addSpy("jeu", $this->game->getCurrentSet()->getCurrentJeu());
            plugin_debug::addSpy("getallevent", $this->game->getStory()->getallevent());
            plugin_debug::addSpy("story", $this->game->getStory()->getallsory());
        }
    }

    public function _index() {
        if (is_null($this->game)) {

            $oView = new _view('game::index');
            $this->oLayout->add('main', $oView);
        } else {

            $this->_currentgame();
        }
    }

    public function _currentgame() {
        // menu
        //instancier le module du score
        $oModuleGamescoreembd = new module_embd_gamescoreembd();
        $oViewmodule = $oModuleGamescoreembd->_voir($this->game);

        //assigner la vue retournee a votre layout
        $this->oLayout->add('main', $oViewmodule);




        $oView = new _view('game::currentgame');
        $disabled = ""; // désactive les boutons si fin
        if ($this->game->isEnd()) {
            $disabled = "disabled";
        }
        $oView->disabled = $disabled;

        $oView->game = $this->game;
        $this->oLayout->add('main', $oView);
    }

    public function _story() {
        // menu
        // $oView = new _view('game::currentgamemenu');
        //  $this->oLayout->add('main', $oView);
        //story 
        //instancier le module
        $oModuleGamestoryembd = new module_embd_gamestoryembd();
        //recupere la vue du module
        $oView = $oModuleGamestoryembd->_list($this->game);



        $this->oLayout->add('main', $oView);
    }

    public function _graph() {
        $getReadableStoryScore = $this->game->getStory()->getReadableStoryScore();

        plugin_debug::addSpy("getReadableStoryScore", $getReadableStoryScore);


        // menu
        // $oViewmenu = new _view('game::currentgamemenu');
        //  $this->oLayout->add('main', $oViewmenu);
        // ______________ par SETS ____________________
        // todo => eventuellement faire une fonction de generation abstraite 
        //module intégrapble 
        $oModuleGamestoryembd = new module_embd_graphembd();
        // parametrage d 'affichage 
        $oModuleGamestoryembd->title = "Point par set";
        $oModuleGamestoryembd->graphType = "column";
        //$oModuleGamestoryembd->datagraphcolor = array("#00ffff", "#78BC61");
        $oModuleGamestoryembd->datagraphhead = array("", $this->game->joueur1()->nomComplet(), $this->game->joueur2()->nomComplet());
        $oModuleGamestoryembd->datagraphheadstack = array("", "1", "1");
        $oModuleGamestoryembd->tablevisible = false;

        $oModuleGamestoryembd->series = $this->getGraphsetsSeries($getReadableStoryScore);

        //recupere la vue du module
        $oViewgraphembd = $oModuleGamestoryembd->_list();
        $this->oLayout->add('main', $oViewgraphembd);

        // ______________ par SETS ____________________
        // ______________ par SET ____________________
        for ($curNumSet = 1; $curNumSet < $this->game->getCurrentnumberSet() + 1; $curNumSet++) {
            $oModuleGamestoryembd = new module_embd_graphembd();
            // parametrage d 'affichage 
            $oModuleGamestoryembd->title = "Point par jeu - Set " . $curNumSet;
            $oModuleGamestoryembd->graphType = "column";
            //$oModuleGamestoryembd->datagraphcolor = array("#00ffff", "#78BC61");
            $oModuleGamestoryembd->datagraphhead = array("", $this->game->joueur1()->nomComplet(), $this->game->joueur2()->nomComplet());
            $oModuleGamestoryembd->datagraphheadstack = array("", "1", "1");
            $oModuleGamestoryembd->tablevisible = false;

            $oModuleGamestoryembd->series = $this->getGraphbysetSeries($getReadableStoryScore, $curNumSet);

            //recupere la vue du module
            $oViewgraphembd = $oModuleGamestoryembd->_list();
            $this->oLayout->add('main', $oViewgraphembd);
        }

        // ______________ par SET ____________________
        // ______________ par set tendance ____________________
        // ______________ tendance  ____________________



        $oView = new _view('game::graph');
        $oView->getReadableStoryScore = $this->game->getStory()->getReadableStoryScore();
        ///plugin_debug::addSpy("getReadableStoryScore", $oView->getReadableStoryScore);

        $this->oLayout->add('main', $oView);
    }

    private function getGraphsetsSeries($getReadableStoryScore) {
        $stats = array();

        foreach ($getReadableStoryScore as $StoryScore) {
            //prepa series
            $stats[$StoryScore["numberset"]] = isset($stats[$StoryScore["numberset"]]) ? $stats[$StoryScore["numberset"]] : array("set " . $StoryScore["numberset"], 0, 0);

            if ($StoryScore["winpt"] == "j1") {
                $stats[$StoryScore["numberset"]][1] = $stats[$StoryScore["numberset"]][1] + 1;
            } else {
                $stats[$StoryScore["numberset"]][2] = $stats[$StoryScore["numberset"]][2] + 1;
            }
        }
        return $stats;
    }

    private function getGraphbysetSeries($getReadableStoryScore, $setnumber) {
        $stats = array();

        foreach ($getReadableStoryScore as $StoryScore) {
            if ($StoryScore["numberset"] == $setnumber) { // uniquement pour le set demandé 
                //prepa series
                $stats[$StoryScore["numberjeu"]] = isset($stats[$StoryScore["numberjeu"]]) ? $stats[$StoryScore["numberjeu"]] : array($StoryScore["numberjeu"], 0, 0);

                if ($StoryScore["winpt"] == "j1") {
                    $stats[$StoryScore["numberjeu"]][1] = $stats[$StoryScore["numberjeu"]][1] + 1;
                } else {
                    $stats[$StoryScore["numberjeu"]][2] = $stats[$StoryScore["numberjeu"]][2] + 1;
                }
            }
        }
        return $stats;
    }

    private function getGraphbysettendance($getReadableStoryScore, $setnumber) {
        $stats = array();

        foreach ($getReadableStoryScore as $StoryScore) {
            if ($StoryScore["numberset"] == $setnumber) { // uniquement pour le set demandé 
                //prepa series
                $stats[$StoryScore["numberjeu"]] = isset($stats[$StoryScore["numberjeu"]]) ? $stats[$StoryScore["numberjeu"]] : array($StoryScore["numberjeu"], 0, 0);

                if ($StoryScore["winpt"] == "j1") {
                    $stats[$StoryScore["numberjeu"]][1] = $stats[$StoryScore["numberjeu"]][1] + 1;
                } else {
                    $stats[$StoryScore["numberjeu"]][2] = $stats[$StoryScore["numberjeu"]][2] + 1;
                }
            }
        }
        return $stats;
    }

    public function _conf() {
        // menu
        //   $oView = new _view('game::currentgamemenu');
        //  $this->oLayout->add('main', $oView);
        //story 
        //instancier le module
        $oModuleGameconfembd = new module_embd_gameconfembd();
        //recupere la vue du module
        $oView = $oModuleGameconfembd->_list($this->game->getConfig());



        $this->oLayout->add('main', $oView);
    }

    public function _newgame() {
        $this->game = new my_game();



/// on passe les paramettres


        if (!_root::getRequest()->isPost()) {
            $oView = new _view('game::newgame');

            $oView->game = $this->game;
            $this->oLayout->add('main', $oView);
        } else {
            $j1nickname = _root::getParam('j1nickname');
            $j1name = _root::getParam('j1name');
            $j2nickname = _root::getParam('j2nickname');
            $j2name = _root::getParam('j2name');
            $format = (int) _root::getParam('format');
            $firstserv = (int) _root::getParam('firstserv');

            $this->game->joueur1()->setNom($j1name);
            $this->game->joueur1()->setPrenom($j1nickname);
            $this->game->joueur2()->setNom($j2name);
            $this->game->joueur2()->setPrenom($j2nickname);

            $oView = new _view('game::newgame');

// pas de formulaire donc premier affichage
//$oView->j1nickname = $this->game->joueur1()->prenom();
//$oView->j1name = $this->game->joueur1()->nom();
//$oView->j2nickname = $this->game->joueur2()->prenom();
//$oView->j2name = $this->game->joueur2()->nom();


            switch ($firstserv) {
                case 0: // pas de reposne
//pas de choix de format, on reste sur la page
                    $oView->game = $this->game;
                    $this->oLayout->add('main', $oView);
                    return; //breakpoint

                case 1: //joueur 1
                    $this->game->getConfig()->setFirstServ($this->game->joueur1());
                    $this->game->getCurrentServ($firstserv);

                    break;
                case 2: //joueur 2
                    $this->game->getConfig()->setFirstServ($this->game->joueur2());
                    $this->game->getCurrentServ($firstserv);

                    break;
            }

            $this->game->currentServSwitch();





            switch ($format) {
                case 0: // pas de reposne
//pas de choix de format, on reste sur la page

                    $oView->game = $this->game;
                    $this->oLayout->add('main', $oView);
                    break;
                case 1:
//format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(6);
                    $this->game->getConfig()->setisSuperTiebreackEnable(false);
                    $this->game->getConfig()->setIsNoAd(false);

                    $this->saveGameFile($this->game);

                    _root::redirect('game::index');
                    break;
                case 2:
//format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(6);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(false);

                    $this->saveGameFile($this->game);

                    _root::redirect('game::index');
                    break;
                case 3:
//format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(4);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);

                    $this->saveGameFile($this->game);

                    _root::redirect('default::index');
                    break;
                case 4:
//format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(6);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);

                    $this->saveGameFile($this->game);

                    _root::redirect('game::index');
                    break;
                case 5:
//format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(3);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);

                    $this->saveGameFile($this->game);

                    _root::redirect('game::index');
                    break;
                case 6:
//format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(4);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);

                    $this->saveGameFile($this->game);

                    _root::redirect('game::index');
                    break;
                case 7:
//format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(5);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);


                    $this->saveGameFile($this->game);

                    _root::redirect('game::index');
                    break;
            }
        }
    }

    public function _eventchangecurrentserv() {
        if ($this->game->getCurrentServ() == $this->game->joueur1()) {
            $this->game->setCurrentServ($this->game->joueur2());
        } else {
            $this->game->setCurrentServ($this->game->joueur1());
        }
        // on enregistre evenement pour reconstitution du match 
        $this->game->getStory()->addevent(my_story::SWITCHSERV, $this->game->getCurrentServ());

        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventservok() {
        $constevent = my_story::SERVOK1;

        // on enregistre evenement pour reconstitution du match 
        $this->game->getStory()->addevent($constevent, $this->game->getCurrentServ());

        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventservfault() {
        //: plusieurs cas de figure
        //1 service faute premier service 1ere balle
        //2 service faute premier service deuxieme balle => second service
        //3 service faute deuxieme service premiere balle
        //4 service faute deuxieme service deuxieme balle => double faute

        $numserv = $this->game->getCurrentSet()->getCurrentJeu()->getstateserv();
        $numball = $this->game->getCurrentSet()->getCurrentJeu()->getstateservball();

        if ($numserv == 1) { // premier service
            if ($numball == 1) { //premiere balle
                $this->game->getStory()->addevent(my_story::SERVFAULES1B1, $this->game->getCurrentServ());
            } elseif ($numball == 2) {// duxieme balle
                $this->game->getStory()->addevent(my_story::SERVFAULES1B2, $this->game->getCurrentServ());
            }
        } elseif ($numserv == 2) { //deuxieme service
            if ($numball == 1) { //premiere balle
                $this->game->getStory()->addevent(my_story::SERVFAULES2B1, $this->game->getCurrentServ());
            } elseif ($numball == 2) {//deuxieme ball
                $this->game->getStory()->addevent(my_story::SERVFAULES2B2, $this->game->getCurrentServ());
            }
        }



        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _addpointj1() {
        $this->game->pointj1();
        $this->saveGameFile($this->game);

        _root::redirect('game::index');
    }

    public function _addpointj2() {
        $this->game->pointj2();
        $this->saveGameFile($this->game);

        _root::redirect('game::index');
    }

    public function _redo() {
        $this->game->redo();
        $this->saveGameFile($this->game);

        _root::redirect('game::index');
    }

    private function saveGameFile($game) {
        //sauvegarde session
        $_SESSION['game'] = $game;
        // sauvegarde en fichier
        $oFile = new _file('../data/game/' . $game->id() . '.json');
        $jsonData = $this->game->fulljsonSerialize();
        $oFile->setContent($jsonData);
        $oFile->save();

        // sauvegarde en base si non existante
        if (!model_game::getInstance()->findByGameId($game->id())) {
            $oGame = new row_game();

            $oGame->gameid = $game->id();
            $oGame->date = $game->getDate();
            $oGame->accountid = _root::getAuth()->getAccount()->id;

            $oGame->save();
        }
    }

    public function after() {
        $oView = new _view('game::currentgamemenu');
        $this->oLayout->add('main', $oView);
        $this->oLayout->show();
    }

}
