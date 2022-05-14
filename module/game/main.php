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
            //    plugin_debug::addSpy("jeu", $this->game->getCurrentSet()->getCurrentJeu());
            //    plugin_debug::addSpy("getallevent", $this->game->getStory()->getallevent());
            //    plugin_debug::addSpy("story", $this->game->getStory()->getallsory());
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

    public function _detail() {


        //$plug  = new plugin_stat($this->game);

        $oView = new _view("game::detail");
        $oView->plug = new plugin_stat($this->game);
        //plugin_debug::addSpy("plug",  $oView->plug);
        $this->oLayout->add('main', $oView);
    }

    public function _graph() {
        $oView = new _view('game::graph');

        $oView->getReadableStoryScore = $this->game->getStory()->getReadableStoryScore(); /// en attendant nettoyage 


        $oView->graphptss = $this->graph_graphptss();
        $oView->graphdetails = $this->graph_graphdetail();
        $oView->graphJoueur1 = $this->graph_graphjoueur1();
        $oView->graphJoueur2 = $this->graph_graphjoueur2();
        $this->oLayout->add('main', $oView);
    }

    private function graph_graphjoueur1() {
        return $this->graph_graphjoueur("j1");
    }

    private function graph_graphjoueur2() {
        return $this->graph_graphjoueur("j2");
    }

    private function graph_graphjoueur($j) {
        $graphjoueur = array();

        $plug = new plugin_stat($this->game);

        $oModuleGamestoryembd = new module_embd_graphembd();
        // parametrage d 'affichage 
        if ($j == "j1") {
            $oModuleGamestoryembd->title = "Points sur service - " . $this->game->joueur1()->nomComplet();
        } else {
            $oModuleGamestoryembd->title = "Points sur service - " . $this->game->joueur2()->nomComplet();
        }
        $oModuleGamestoryembd->graphType = "column";
        $oModuleGamestoryembd->datagraphcolor = array("#4572A7", "#AA4643", "#4572A7", "#AA4643");
        $oModuleGamestoryembd->datagraphhead = array("", "Service 1 : Gagné", "Service 1 : perdu", "Service 2 : Gagné", "Service 2 : perdu");
        $oModuleGamestoryembd->datagraphheadstack = array("", "1", "1", "2", "2");
        $oModuleGamestoryembd->tablevisible = false;

        // pour chaque set 
        for ($set = 1; $set <= $plug->getNumberSet(); $set++) {
            $getsetj = "get" . $j . "set" . $set;


            $series[] = array("Set " . $set,
                $plug->$getsetj(array(my_story::POINTONFIRSTSERV)),
                $plug->$getsetj(array(my_story::POINTLOOSEONFIRSTSERV)),
                $plug->$getsetj(array(my_story::POINTONSECONDSERV)),
                $plug->$getsetj(array(my_story::POINTLOOSEONSECONDSERV)),
            );
        }

        $getallj = "getall" . $j;
        $series[] = array("Total",
            $plug->$getallj(array(my_story::POINTONFIRSTSERV)),
            $plug->$getallj(array(my_story::POINTLOOSEONFIRSTSERV)),
            $plug->$getallj(array(my_story::POINTONSECONDSERV)),
            $plug->$getallj(array(my_story::POINTLOOSEONSECONDSERV)),
        );


        $oModuleGamestoryembd->series = $series;

        //recupere la vue du module
        $oViewgraphembd = $oModuleGamestoryembd->_list();
        //$this->oLayout->add('main', $oViewgraphembd);
        $graphjoueur[] = $oViewgraphembd;





/// passage de service
        // pour chaque set 
        for ($set = 1; $set <= $plug->getNumberSet(); $set++) {
            $oModuleGamestoryembd = new module_embd_graphembd();
            // parametrage d 'affichage 
            if ($j == "j1") {
                $oModuleGamestoryembd->title = "Set " . $set . " - Service " . $this->game->joueur1()->nomComplet();
            } else {
                $oModuleGamestoryembd->title = "Set " . $set . " - Service " . $this->game->joueur2()->nomComplet();
            }
            $oModuleGamestoryembd->graphType = "pie";
            $oModuleGamestoryembd->datagraphcolor = array("#4572A7", "#506493", "#AA4643");
            $oModuleGamestoryembd->datagraphhead = array("", "set " . $set);
            //    $oModuleGamestoryembd->datagraphheadstack = array("", "1", "1", "2", "2");
            $oModuleGamestoryembd->tablevisible = false;


            $series = array();
            $getallj = "getall" . $j;
            $series[] = array("Premier service",
                $plug->$getallj(array(my_story::SERVOK1, my_story::SERVACE1)),
            );

            $series[] = array("Second service",
                $plug->$getallj(array(my_story::SERVOK2, my_story::SERVACE2)),
            );

            $series[] = array("Double",
                $plug->$getallj(array(my_story::SERVFAULEB2)),
            );




            $oModuleGamestoryembd->series = $series;

            //recupere la vue du module
            $oViewgraphembd = $oModuleGamestoryembd->_list();
            //$this->oLayout->add('main', $oViewgraphembd);
            $graphjoueur[] = $oViewgraphembd;
        }





        return $graphjoueur;
    }

    private function graph_graphdetail() {
        $graphdetail = array();
        $plug = new plugin_stat($this->game);
        //$getReadableStoryScore = $this->game->getStory()->getReadableStoryScore();
        //module intégrapble 
        $oModuleGamestoryembd = new module_embd_graphembd();
        // parametrage d 'affichage 
        $oModuleGamestoryembd->title = "Répartition des points";
        $oModuleGamestoryembd->graphType = "column";
        $oModuleGamestoryembd->datagraphcolor = array("#506493", "#2E4172", "#AA3939", "#FF6363", "#FF1717", "#AA3939", "#FF6363", "#FF1717", "#2E4172",);
        $oModuleGamestoryembd->datagraphhead = array("", "J1 Coups Gagnants", "J1 ACE", "J2 Fautes", "J2 Retour Fautes", "J2 Doubles", "J2 Coups Gagnants", "J2 ACE", "J1 Fautes", "J1 Retour Fautes", "J1 Doubles");
        $oModuleGamestoryembd->datagraphheadstack = array("", "1", "1", "1", "1", "1", "2", "2", "2", "2", "2");
        $oModuleGamestoryembd->tablevisible = false;

        $series = array();




        $series[] = array("Total",
            $plug->getallj1(array(my_story::POINT)),
            $plug->getallj1(array(my_story::SERVACE1, my_story::SERVACE2)),
            $plug->getallj2(array(my_story::FAULTNET, my_story::FAULTOUT)),
            $plug->getallj2(array(my_story::RETURNFAULT)),
            $plug->getallj2(array(my_story::SERVFAULEB2)),
            $plug->getallj2(array(my_story::POINT)),
            $plug->getallj2(array(my_story::SERVACE1, my_story::SERVACE2)),
            $plug->getallj1(array(my_story::FAULTNET, my_story::FAULTOUT)),
            $plug->getallj1(array(my_story::RETURNFAULT)),
            $plug->getallj1(array(my_story::SERVFAULEB2)),
        );


        for ($numSet = 1; $numSet <= $plug->getNumberSet(); $numSet++) {
            $series[] = array("Set " . $numSet,
                $plug->getSetallj1($numSet, array(my_story::POINT)),
                $plug->getSetallj1($numSet, array(my_story::SERVACE1, my_story::SERVACE2)),
                $plug->getSetallj2($numSet, array(my_story::FAULTNET, my_story::FAULTOUT)),
                $plug->getSetallj2($numSet, array(my_story::RETURNFAULT)),
                $plug->getSetallj2($numSet, array(my_story::SERVFAULEB2)),
                $plug->getSetallj2($numSet, array(my_story::POINT)),
                $plug->getSetallj2($numSet, array(my_story::SERVACE1, my_story::SERVACE2)),
                $plug->getSetallj1($numSet, array(my_story::FAULTNET, my_story::FAULTOUT)),
                $plug->getSetallj1($numSet, array(my_story::RETURNFAULT)),
                $plug->getSetallj1($numSet, array(my_story::SERVFAULEB2)),
            );
        }



        $oModuleGamestoryembd->series = $series;

        //recupere la vue du module
        $oViewgraphembd = $oModuleGamestoryembd->_list();
        //$this->oLayout->add('main', $oViewgraphembd);
        $graphdetail[] = $oViewgraphembd;



        return $graphdetail;
    }

    private function graph_graphptss() {
        $graphptss = array();


        $getReadableStoryScore = $this->game->getStory()->getReadableStoryScore();

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
        //$this->oLayout->add('main', $oViewgraphembd);
        $graphptss[] = $oViewgraphembd;


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
            //$this->oLayout->add('main', $oViewgraphembd);
            $graphptss[] = $oViewgraphembd;
        }

        // ______________ par SET ____________________
        // ______________ par set tendance ____________________
        // ______________ tendance  ____________________

        return $graphptss;
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

        // on enregistre evenement pour reconstitution du match 
        $this->game->getStory()->addevent(my_story::SWITCHSERV, $this->game->getCurrentServ());

        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventservok() {
        $numball = $this->game->getCurrentSet()->getCurrentJeu()->getstateservball();

        if ($numball == 1) { //premiere balle
            $constevent = my_story::SERVOK1;
        } elseif ($numball == 2) {// duxieme balle
            $constevent = my_story::SERVOK2;
        }


        // on enregistre evenement pour reconstitution du match 
        $this->game->getStory()->addevent($constevent, $this->game->getCurrentServ());

        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventservfault() {

        $numball = $this->game->getCurrentSet()->getCurrentJeu()->getstateservball();

        if ($numball == 1) { //premiere balle
            $this->game->getStory()->addevent(my_story::SERVFAULEB1, $this->game->getCurrentServ());
        } elseif ($numball == 2) {// duxieme balle
            $this->game->getStory()->addevent(my_story::SERVFAULEB2, $this->game->getCurrentServ());
        }

        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventfaultreturn() {
        $playeradverse = null;
        if ($this->game->getCurrentServ() == $this->game->joueur1()) {
            $playeradverse = $this->game->joueur2();
        } else {
            $playeradverse = $this->game->joueur1();
        }

        $this->game->getStory()->addevent(my_story::RETURNFAULT, $playeradverse);


        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventwinreturn() {
        $playeradverse = null;
        if ($this->game->getCurrentServ() == $this->game->joueur1()) {
            $playeradverse = $this->game->joueur2();
        } else {
            $playeradverse = $this->game->joueur1();
        }

        $this->game->getStory()->addevent(my_story::RETURNWIN, $playeradverse);


        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventfaultoutj1() {

        $this->game->getStory()->addevent(my_story::FAULTOUT, $this->game->joueur1());
        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventfaultoutj2() {

        $this->game->getStory()->addevent(my_story::FAULTOUT, $this->game->joueur2());
        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventfaultnetj1() {

        $this->game->getStory()->addevent(my_story::FAULTNET, $this->game->joueur1());
        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventfaultnetj2() {

        $this->game->getStory()->addevent(my_story::FAULTNET, $this->game->joueur2());
        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _eventservace() {
        $numball = $this->game->getCurrentSet()->getCurrentJeu()->getstateservball();

        if ($numball == 1) { //premiere balle
            $constevent = my_story::SERVACE1;
        } elseif ($numball == 2) {// duxieme balle
            $constevent = my_story::SERVACE2;
        }


        // on enregistre evenement pour reconstitution du match 
        $this->game->getStory()->addevent($constevent, $this->game->getCurrentServ());
        $this->saveGameFile($this->game);
        _root::redirect('game::index');
    }

    public function _addpointj1() {
        $this->game->getStory()->addevent(my_story::POINT, $this->game->joueur1());
        $this->saveGameFile($this->game);

        _root::redirect('game::index');
    }

    public function _addpointj2() {
        $this->game->getStory()->addevent(my_story::POINT, $this->game->joueur2());
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
