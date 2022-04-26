<?php

class module_default extends abstract_module {

    private $game;

    public function before() {

        /// cette page n'est plus accesible

        _root::redirect('welcome::index');


        //recueraton de la partie en cours
        if (!isset($_SESSION['oldgame'])) {
            $this->game = new my_game();
        } else {
            $this->game = $_SESSION['oldgame'];
        }


        $this->oLayout = new _layout('staten');
        $this->oLayout->addModule('menu', 'menu::index');
    }

    public function _index() {

        $oView = new _view('default::index');
        $oView->game = $this->game;

        //instancier le module
        $oModuleGamescoreembd = new module_embd_gamescoreembd();
        //recupere la vue du module
        $oViewmodule = $oModuleGamescoreembd->_voir($this->game);

        //assigner la vue retournee a votre layout






        $this->oLayout->add('main', $oViewmodule);
        $this->oLayout->add('main', $oView);
    }

    public function _addpointj1() {
        $this->game->pointj1();
        $this->_index();
    }

    public function _addpointj2() {
        $this->game->pointj2();
        $this->_index();
    }

    public function _redo() {
        $this->game->redo();
        // $this->_index();
        _root::redirect('default::index');
    }

    public function _story() {





        $oView = new _view('default::story');
        $oView->game = $this->game;
        $this->oLayout->add('main', $oView);

        //instancier le module
        $oModuleGamestoryembd = new module_embd_gamestoryembd();
        //recupere la vue du module
        $oView = $oModuleGamestoryembd->_list($this->game);



        $this->oLayout->add('main', $oView);
    }

    public function _reset() {

        $this->game = new my_game();
        $_SESSION['game'] = $this->game;


        /// on passe les paramettres


        if (!_root::getRequest()->isPost()) {
            $oView = new _view('default::ng1');


            // pas de formulaire donc premier affichage
            $oView->j1nickname = $this->game->joueur1()->prenom();
            $oView->j1name = $this->game->joueur1()->nom();
            $oView->j2nickname = $this->game->joueur2()->prenom();
            $oView->j2name = $this->game->joueur2()->nom();

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

            $oView = new _view('default::ng1');

            // pas de formulaire donc premier affichage
            $oView->j1nickname = $this->game->joueur1()->prenom();
            $oView->j1name = $this->game->joueur1()->nom();
            $oView->j2nickname = $this->game->joueur2()->prenom();
            $oView->j2name = $this->game->joueur2()->nom();


            switch ($firstserv) {
                case 0: // pas de reposne
                    //pas de choix de format, on reste sur la page
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
                    $this->oLayout->add('main', $oView);
                    break;
                case 1:
                    //format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(6);
                    $this->game->getConfig()->setisSuperTiebreackEnable(false);
                    $this->game->getConfig()->setIsNoAd(false);
                    $_SESSION['game'] = $this->game;
                    _root::redirect('default::index');
                    break;
                case 2:
                    //format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(6);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(false);
                    $_SESSION['game'] = $this->game;
                    _root::redirect('default::index');
                    break;
                case 3:
                    //format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(4);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);
                    $_SESSION['game'] = $this->game;
                    _root::redirect('default::index');
                    break;
                case 4:
                    //format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(6);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);
                    $_SESSION['game'] = $this->game;
                    _root::redirect('default::index');
                    break;
                case 5:
                    //format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(3);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);
                    $_SESSION['game'] = $this->game;
                    _root::redirect('default::index');
                    break;
                case 6:
                    //format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(4);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);
                    $_SESSION['game'] = $this->game;
                    _root::redirect('default::index');
                    break;
                case 7:
                    //format 1
                    $this->game->getConfig()->SetSetForWinGame(2);
                    $this->game->getConfig()->setJeuForWinSet(5);
                    $this->game->getConfig()->setisSuperTiebreackEnable(true);
                    $this->game->getConfig()->setsuperTiebreackNumber(10);
                    $this->game->getConfig()->setIsNoAd(true);


                    $_SESSION['game'] = $this->game;
                    _root::redirect('default::index');
                    break;
            }
        }
    }

    public function after() {
        $_SESSION['oldgame'] = $this->game; // sauvegarde de la partie en session
        $oFile = new _file('../data/game/old_' . $this->game->id() . '.json');
        $jsonData = $this->game->fulljsonSerialize();
        $oFile->setContent($jsonData);
        $oFile->save();
        $this->oLayout->show();
    }

}
