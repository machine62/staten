<?php

class module_gamelist extends abstract_module {

    public function before() {
        $this->oLayout = new _layout('staten');
        $this->oLayout->addModule('menu', 'menu::index');
        
        
     
    }

    public function _index() {
        //on considere que la page par defaut est la page de listage
        $this->_list();
    }

    public function _list() {

        $tGame = model_game::getInstance()->findAll();
        $oGamefile = array();
        // on recupere chaque $tgame sous forme d 'objet
        $tgames = array();
        foreach ($tGame as $oGame) {
            $tmpgma = new my_game();
            //get content file
            $oFile = new _file('../data/game/' . $oGame->gameid . '.json');
            if ($oFile->exist()) {
                $json = $oFile->getContent();
                $tmpgma->fulljsonUNSerialize($json);

                $oGamefile[$oGame->gameid] = $tmpgma;

                $tgames[] = $oGame;
            }
        }




        $oView = new _view('gamelist::list');

        $oView->oGamefile = $oGamefile;
        $oView->tGame = $tgames;
        $oView->tJoinaccount = model_account::getInstance()->getSelect();





        $this->oLayout->add('main', $oView);
    }

    public function _changecurrentgame() {
        ///érification de la presence du fichier :
        $idgame = _root::getParam('gameid');


        $oFile = new _file('../data/game/' . $idgame . '.json');
        // chargement si existe
        if ($oFile->exist()) {
            $tmpgma = new my_game();
            $json = $oFile->getContent();
            $tmpgma->fulljsonUNSerialize($json);

            $_SESSION['game'] = $tmpgma;


            $this->game = $_SESSION['game'];
        }
        _root::redirect('gamelist::list');
    }

    public function _delete() {

        $oPluginXsrf = new plugin_xsrf();
        if (!_root::getRequest()->isPost()) {
            $oView = new _view('gamelist::delete');
            $oView->token = $oPluginXsrf->getToken();
            $this->oLayout->add('main', $oView);
            return;
        }


        if (!$oPluginXsrf->checkToken(_root::getParam('token'))) { //on verifie que le token est valide
            $oView = new _view('gamelist::delete');
            $oView->token = $oPluginXsrf->getToken();
            $oView->tMessage = array('token' => $oPluginXsrf->getMessage());
            $this->oLayout->add('main', $oView);
            return;
        }

        // token ok, post ok
        //suppression 
        //en BDD
        $idgame = trim(_root::getParam('gameid'));
        $oGame = model_game::getInstance()->findByGameId($idgame);
        $oGame->delete();
        /// en fichier 
         $oFile = new _file('../data/game/' . $idgame . '.json');
        $oFile->delete();
        
        // si on sureveille cette partie on la retire de la session (evite d'afficher une partie qui nexiste plus
        if (isset($_SESSION['game']))
        {
                    if ($idgame == $_SESSION['game']->id()) {
                unset($_SESSION['game']);
            }
        }

        
        
        // on retourne sur la liste des parties
        _root::redirect('gamelist::list');
        
        
        
        
    }

    public function _show() {
        $oGame = model_game::getInstance()->findById(_root::getParam('id'));

        $oView = new _view('gamelist::show');
        $oView->oGame = $oGame;



        $this->oLayout->add('main', $oView);
    }

    public function after() {
        $this->oLayout->show();
    }

}
