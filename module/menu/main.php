<?php

Class module_menu extends abstract_moduleembedded {

    public function _index() {

        $tLink = array();
        $tLink['accueil'] = 'welcome::index';
        $tLink['Nouvelle partie'] = 'game::newgame';
        $tLink['Parie en cours'] = 'game::index';
        $tLink['Live'] = 'live::list';
        $tLink['Parties'] = 'gamelist::list';
        //$tLink['debug'] = 'default::index';
        


        $tLinkright = array();
        if (_root::getACL()->can('access', 'rightsManagerMulti')) {
            $tLinkright['Gestion Droit'] = 'rightsManagerMulti::index';
        }
        $tLinkright['D&eacute;connexion'] = 'login::logout';


        $oView = new _view('menu::index');
        $oView->tLink = $tLink;
        $oView->tLinkright = $tLinkright;

        return $oView;
    }

}
