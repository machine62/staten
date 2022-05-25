<?php

class module_externalview extends abstract_module {

    private $game = null;

    public function before() {

        // peut on se trouver ici
        if (isset($_SESSION['externalgame'])) {
            $this->game = $_SESSION['externalgame'];
        }

        // si variable poste, on récupere la partie
        if (!is_null(_root::getParam("link"))) {
            $ticket = _root::getParam("link");
            $oGame = model_game::getInstance()->findByGameTicket($ticket);
            $gameid = $oGame->gameid;

            //chargement de la partie en session
            $oFile = new _file('../data/game/' . $gameid . '.json');
            // chargement si existe
            if ($oFile->exist()) {
                $tmpgma = new my_game();
                $json = $oFile->getContent();
                $tmpgma->fulljsonUNSerialize($json);

                $_SESSION['externalgame'] = $tmpgma;
                $this->game = $tmpgma;
            }
        }

        //todo cas ou le ticket est revoqué et toujours en cache
         $this->oLayout = new _layout('staten');
        //$this->oLayout->addModule('menu','menu::index');
    }

    public function _index() {
        $this->_game();
    }

    public function _game() {
        //instancier le module
        // $oModulegamegraphembd = new module_embd_gamegraphembd();
        //recupere la vue du module
        //  $oView = $oModulegamegraphembd->_test($this->game);
        //plugin_debug::addSpy("oview",$oView );
        //$this->oLayout->add('main', $oView);
        //  die("test");
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
        $oModuleGraph = new module_embd_gamegraphembd();
        //recupere la vue du module
        $oView = $oModuleGraph->_graph($this->game);
        

        $this->oLayout->add('main', $oView);
    }

    public function _conf() {

        $oModuleGameconfembd = new module_embd_gameconfembd();
        //recupere la vue du module
        $oView = $oModuleGameconfembd->_list($this->game->getConfig());



        $this->oLayout->add('main', $oView);
    }

    public function after() {
        $oView = new _view('game::currentgamemenu');
        $this->oLayout->add('main', $oView);
        $oView->pagelink = "externalview";
        $this->oLayout->show();
    }

}
