<?php

class module_embd_gamegraphembd extends abstract_moduleembedded {

    public static $sModuleName = 'gamegraphembd';
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
        $sAction = '_' . self::getParam('Action', 'graph');
        return $this->$sAction();
    }

    public function _list() {
        return $this->_graph();
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

//
//  public function _test($game ) {
//       $oView=new _view('embd/gamegraphembd::test');
//         return $oView;
//       
//  }
    public function _graph($game) {
        $this->game = $game;

        $oView = new _view('embd/gamegraphembd::list');

        $oView->getReadableStoryScore = $this->game->getStory()->getReadableStoryScore(); /// en attendant nettoyage 


        $oView->graphptss = $this->graph_graphptss();
        $oView->graphdetails = $this->graph_graphdetail();
        $oView->graphJoueur1 = $this->graph_graphjoueur1();
        $oView->graphJoueur2 = $this->graph_graphjoueur2();


        return $oView;
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

}
