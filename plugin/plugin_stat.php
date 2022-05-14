<?php

class plugin_stat {

    private $game;
    private $sets; // nombre de set
    private $jeux; // nombre de jeu par set
    private $data = array(); // contiendra toutes les infos
    private $start = array();
    private $end = array();

//$data["j1"]["all"]["event"],$data["j2"]["all"]["event"]
//$data["j1"]["sets"][0]["event"], $data["j1"]["sets"][1]["event"]
//$data["j1"]["jeux"][numset][0]["event"], $data["j1"]["jeux"][numset[1]["event"]


    public function __construct(my_game $_game) {
        $this->game = $_game;

        $this->sets = array();
        $this->jeux = array();

        $this->init();
    }

    private function init() {
        $tEvents = $this->game->getStory()->getallevent();

        $nGame = new my_game($this->game->joueur1(), $this->game->joueur2());
        $nGame->setConfig($this->game->getConfig());

        $nGame->setCurrentServ($nGame->getConfig()->getFirstServ());



        $currentset = 0;
        $curentjeux = 0;




// preparation temps de match
        if (isset($tEvents[0])) {
            $this->start["all"] = $tEvents[0]["time"];
            $this->end["all"] = $tEvents[0]["time"];
        }

        foreach ($tEvents as $events) {
            $currentSet = $nGame->getCurrentnumberSet();
            $currentJeu = $nGame->getCurrentSet()->getCurrentnumberJeu();
            $serveur = $nGame->getCurrentServ();

            if (!isset($this->start[$currentSet])) {
                $this->start[$currentSet] = $events["time"];
            } elseif ( $this->start[$currentSet] >  $events["time"] ) {
                 $this->start[$currentSet] = $events["time"];
            }





            $this->customevent($events, $currentSet, $currentJeu);

            if ($nGame->joueur1()->id() == $events["idPlayer"]) {
                $player = $nGame->joueur1();
                $playeraversaire = $nGame->joueur2();
            } elseif ($nGame->joueur2()->id() == $events["idPlayer"]) {
                $player = $nGame->joueur2();
                $playeraversaire = $nGame->joueur1();
            }



// on rejoue tous les evenements 
            if ($events["constevent"] != my_story::POINTSCORE) { // l'evenement POINTSCORE est toujours appelé par un autre event
                $curServeur = $serveur->id();
                $curBalle = $nGame->getCurrentSet()->getCurrentJeu()->getstateservball();
                $curPoint = $nGame->getCurrentScore();
                //  plugin_debug::addSpy("getCurrentScoreJoueur1()-j2", $nGame->getCurrentSet()->getCurrentJeu()->getCurrentScoreJoueur1() . "-" . $nGame->getCurrentSet()->getCurrentJeu()->getCurrentScoreJoueur2());
                $nGame->getStory()->addevent($events["constevent"], $player, $events["time"]);

                if ($nGame->getCurrentScore() != $curPoint) { // il y a eu point ajout de d event 
                    // Cas simple point direct
                    if (($events["constevent"] != my_story::FAULTNET ) && ($events["constevent"] != my_story::FAULTOUT )) {
                        if ($serveur == $player) {
                            $events['idPlayer'] = $player->id();
                            $events['constevent'] = $curBalle == 1 ? my_story::POINTONFIRSTSERV : my_story::POINTONSECONDSERV;
                            $this->customevent($events, $currentSet, $currentJeu);
                        } else { // c'est le nom serveur qui marque
                            $events['idPlayer'] = $playeraversaire->id();
                            $events['constevent'] = $curBalle == 1 ? my_story::POINTLOOSEONFIRSTSERV : my_story::POINTLOOSEONSECONDSERV;
                            $this->customevent($events, $currentSet, $currentJeu);
                        }
                    } elseif (($events["constevent"] == my_story::FAULTNET ) || ($events["constevent"] == my_story::FAULTOUT )) {
                        /// dans ce cas la c compliqué
                        if ($serveur == $player) {
                            $events['idPlayer'] = $player->id();
                            $events['constevent'] = $curBalle == 1 ? my_story::POINTLOOSEONFIRSTSERV : my_story::POINTLOOSEONSECONDSERV;
                            $this->customevent($events, $currentSet, $currentJeu);
                        } else {
                            $events['idPlayer'] = $playeraversaire->id();
                            $events['constevent'] = $curBalle == 1 ? my_story::POINTONFIRSTSERV : my_story::POINTONSECONDSERV;
                            $this->customevent($events, $currentSet, $currentJeu);
                        }
                    }
                }
            }





// ajout curtom event => stat suplementaire 
//  if ($events["constevent"] == my_story::POINTSCORE) {
//  $marqueur = $player;
// $countserv = $this->stateserv;
// if ($serveur == $marqueur) { // ajout du pt marqué sur le serveur
//if ($countserv == 1) {
//  $events['constevent'] = my_story::POINTONFIRSTSERV;
//  $events['idPlayer'] = $marqueur->id();
//  $this->customevent($events, $currentSet, $currentJeu);
// $nGame->getStory()->addevent(my_story::POINTONFIRSTSERV, $serveur);
// } elseif ($countserv == 2) {
// $events['constevent'] = my_story::POINTONSECONDSERV;
// $events['idPlayer'] = $marqueur->id();
// $this->customevent($events, $currentSet, $currentJeu);
//$nGame->getStory()->addevent(my_story::POINTONSECONDSERV, $serveur);
//   }
// } else {
//   if ($countserv == 1) {
//   $events['constevent'] = my_story::POINTLOOSEONFIRSTSERV;
// $events['idPlayer'] = $playeraversaire->id();
// $this->customevent($events, $currentSet, $currentJeu);
// $nGame->getStory()->addevent(my_story::POINTONFIRSTSERV, $serveur);
//    } elseif ($countserv == 2) {
// $events['constevent'] = my_story::POINTLOOSEONSECONDSERV;
//  $events['idPlayer'] = $playeraversaire->id();
//$this->customevent($events, $currentSet, $currentJeu);
//$nGame->getStory()->addevent(my_story::POINTONSECONDSERV, $serveur);
// }
//}
// plugin_debug::addSpy("custum event", $events);
// plugin_debug::addSpy("playeraversaire id", $playeraversaire->id());
//  plugin_debug::addSpy("marqueurid", $marqueur->id());
//}
// dernier evenement // modification fin 
            $this->end["all"] = $events["time"];
            $this->end[$currentSet] = $events["time"];

//var_dump($events);
//echo "<br>";
        }


        plugin_debug::addSpy("stat", $this);
// plugin_debug::addSpy("nGame", $nGame);
    }

    private function addall($events) {
//$data["j1"]["all"]["event"],$data["j2"]["all"]["event"]
        $this->data[$events["idPlayer"]] = isset($this->data[$events["idPlayer"]]) ? $this->data[$events["idPlayer"]] : array();
        $this->data[$events["idPlayer"]]["all"] = isset($this->data[$events["idPlayer"]]["all"]) ? $this->data[$events["idPlayer"]]["all"] : array();
        $this->data[$events["idPlayer"]]["all"][$events["constevent"]] = isset($this->data[$events["idPlayer"]]["all"][$events["constevent"]]) ? $this->data[$events["idPlayer"]]["all"][$events["constevent"]] : 0;


        $this->data[$events["idPlayer"]]["all"][$events["constevent"]]++;
    }

    private function addset($events, $currentSet) {
        $this->sets = $currentSet;



//$data["j1"]["sets"][0]["event"], $data["j1"]["sets"][1]["event"]
        $this->data[$events["idPlayer"]] = isset($this->data[$events["idPlayer"]]) ? $this->data[$events["idPlayer"]] : array();
        $this->data[$events["idPlayer"]]["sets"] = isset($this->data[$events["idPlayer"]]["sets"]) ? $this->data[$events["idPlayer"]]["sets"] : array();
        $this->data[$events["idPlayer"]]["sets"][$currentSet] = isset($this->data[$events["idPlayer"]]["sets"][$currentSet]) ? $this->data[$events["idPlayer"]]["sets"][$currentSet] : array();
        $this->data[$events["idPlayer"]]["sets"][$currentSet][$events["constevent"]] = isset($this->data[$events["idPlayer"]]["sets"][$currentSet][$events["constevent"]]) ? $this->data[$events["idPlayer"]]["sets"][$currentSet][$events["constevent"]] : 0;


        $this->data[$events["idPlayer"]]["sets"][$currentSet][$events["constevent"]]++;
    }

    private function addjeu($events, $currentSet, $currentJeu) {

//$data["j1"]["jeux"][numset][0]["event"], $data["j1"]["jeux"][numset[1]["event"]
        $this->data[$events["idPlayer"]] = isset($this->data[$events["idPlayer"]]) ? $this->data[$events["idPlayer"]] : array();
        $this->data[$events["idPlayer"]]["jeux"] = isset($this->data[$events["idPlayer"]]["jeux"]) ? $this->data[$events["idPlayer"]]["jeux"] : array();
        $this->data[$events["idPlayer"]]["jeux"][$currentSet] = isset($this->data[$events["idPlayer"]]["jeux"][$currentSet]) ? $this->data[$events["idPlayer"]]["jeux"][$currentSet] : array();
        $this->data[$events["idPlayer"]]["jeux"][$currentSet][$currentJeu] = isset($this->data[$events["idPlayer"]]["jeux"][$currentSet][$currentJeu]) ? $this->data[$events["idPlayer"]]["jeux"][$currentSet][$currentJeu] : array();
        $this->data[$events["idPlayer"]]["jeux"][$currentSet][$currentJeu][$events["constevent"]] = isset($this->data[$events["idPlayer"]]["jeux"][$currentSet][$currentJeu][$events["constevent"]]) ? $this->data[$events["idPlayer"]]["jeux"][$currentSet][$currentJeu][$events["constevent"]] : 0;


        $this->data[$events["idPlayer"]]["jeux"][$currentSet][$currentJeu][$events["constevent"]]++;
    }

    private function customevent($events, $currentSet, $currentJeu) {
        $this->addall($events);
        $this->addset($events, $currentSet);
        $this->addjeu($events, $currentSet, $currentJeu);
    }

    private function _getTime($elem) {
        if (isset($this->end[$elem]) && isset($this->start[$elem])) {
            return $this->end[$elem] - $this->start[$elem];
        }
        return 0;
    }

    public function getTimeAll() {
        return $this->_getTime("all");
    }

    public function getNumberSet() {
        return $this->sets;
    }

    public function getTimebyset($numset) {
        $numset = (int) $numset;
        return $this->_getTime($numset);
    }

    private function _getAll($idevents, $idPlayer) {
        $tmpnb = 0;

        foreach ($idevents as $event) {
            //   $idP = $this->game->joueur1()->id();
            $tmpnb = isset($this->data[$idPlayer]["all"][$event]) ? $tmpnb + $this->data[$idPlayer]["all"][$event] : $tmpnb;
        }
        return $tmpnb;
    }

    public function getall($idevents) {
        return ($this->getallj1($idevents) + $this->getallj2($idevents));
    }

    public function getallj1($idevents) {
        return $this->_getAll($idevents, $this->game->joueur1()->id());
    }

    public function getallj2($idevents) {
        return $this->_getAll($idevents, $this->game->joueur2()->id());
    }

    private function _getSetAll($numset, $idevents, $idPlayer) {
        $tmpnb = 0;
        foreach ($idevents as $event) {
            //plugin_debug::addSpy("set id player", $this->data[$idPlayer]["sets"][$numset]);
            //plugin_debug::addSpy("evebnt", $event);
            // plugin_debug::addSpy("value", $value);
            $tmpnb = isset($this->data[$idPlayer]["sets"][$numset][$event]) ? $tmpnb + $this->data[$idPlayer]["sets"][$numset][$event] : $tmpnb;
        }
        return $tmpnb;
    }

    public function getSetall($numset, $idevents) {
        return ($this->getSetallj1($numset, $idevents) + $this->getSetallj2($numset, $idevents));
    }

    public function getSetallj1($numset, $idevents) {
        return $this->_getSetAll($numset, $idevents, $this->game->joueur1()->id());
    }

    public function getSetallj2($numset, $idevents) {
        return $this->_getSetAll($numset, $idevents, $this->game->joueur2()->id());
    }

    /// fonction magique 

    public function __call($method, $args) {
        // time
        switch (true) {
            case (strpos($method, 'getTimeSet') !== false):
                $numset = (int) str_replace("getTimeSet", "", $method);
                return $this->getTimebyset($numset);
                break;

            case (strpos($method, 'getj1set') !== false):
                $numset = (int) str_replace("getj1set", "", $method);
                //plugin_debug::addSpy("args", $args[0]);
                //plugin_debug::addSpy("numset", $numset);
                return $this->getSetallj1($numset, $args[0]);
                break;

            case (strpos($method, 'getj2set') !== false):
                $numset = (int) str_replace("getj2set", "", $method);
                //plugin_debug::addSpy("args", $args[0]);
                //plugin_debug::addSpy("numset", $numset);
                return $this->getSetallj2($numset, $args[0]);
                break;



            default:
                break;
        }




        //$this->_getAll($args[0]);
        //   plugin_debug::addSpy("method", $method);
        if (isset($args[0])) {
            //     plugin_debug::addSpy("args", $args[0]);
        }
        //   return "none";
    }

}
