<?php

class module_embd_gamestoryembd extends abstract_moduleembedded {

    public static $sModuleName = 'gamestoryembd';
    public static $sRootModule;
    public static $tRootParams;

    public function __construct() {
        self::setRootLink(_root::getParamNav(), null);
    }

    public static function setRootLink($sRootModule, $tRootParams = null) {
        self::$sRootModule = $sRootModule;
        self::$tRootParams = $tRootParams;
    }

    public static function getLink($sAction, $tParam = null) {
        return parent::_getLink(self::$sRootModule, self::$tRootParams, self::$sModuleName, $sAction, $tParam);
    }

    public static function getParam($sVar, $uDefault = null) {
        return parent::_getParam(self::$sModuleName, $sVar, $uDefault);
    }

    public static function redirect($sModuleAction, $tModuleParam = null) {
        return parent::_redirect(self::$sRootModule, self::$tRootParams, self::$sModuleName, $sModuleAction, $tModuleParam);
    }

    public function _index() {
        $sAction = '_' . self::getParam('Action', 'list');
        return $this->$sAction();
    }

    /*
      Pour integrer au sein d'un autre module:

      //instancier le module
      $oModuleExamplemodule=new module_examplemodule();

      //si vous souhaitez indiquer au module integrable des informations sur le module parent
      //$oModuleExamplemodule->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));

      //recupere la vue du module
      $oViewModule=$oModuleExamplemodule->_index();

      //assigner la vue retournee a votre layout
      $this->oLayout->add('main',$oViewModule);
     */

    public function _list($game) {
        $oView = new _view('embd/gamestoryembd::voir');
        $oView->tgameCurentScore = $game->getStory()->getReadableStoryScore();
        $oView->j1 = $game->joueur1();
        $oView->j2 = $game->joueur2();

        return $oView;
    }

}
