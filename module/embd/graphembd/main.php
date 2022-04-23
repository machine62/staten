<?php

class module_embd_graphembd extends abstract_moduleembedded {

    public static $sModuleName = 'graphembd';
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

    //info par defaut
    var $title = "test";
    var $graphType = "column"; // possible  column  line   area   spline    pie
    var $datagraphcolor = array(); // couleur e exa sous forme de tableau 
    var $datagraphhead = array(); // elements  qui apparaissent dans thead, premir non signifiant pour le graph
    var $datagraphheadstack = array(); // uniquement si on stack des colonne entre elle pour e graph (additionne les celluel dans l'affichage;..
    var $series = array(); // series le premier element servira a la legende 
    var $tablevisible = false; // voir tableau ... debug principalement 

    public function _list() {

        $oView = new _view('embd/graphembd::list');
        $oView->title = $this->title;
        $oView->graphType = $this->graphType;
        $oView->datagraphcolor = $this->datagraphcolor;
        $oView->datagraphhead = $this->datagraphhead;
        $oView->datagraphheadstack = $this->datagraphheadstack;
        $oView->series = $this->series;
        $oView->tablevisible = $this->tablevisible;


        return $oView;
    }

}
