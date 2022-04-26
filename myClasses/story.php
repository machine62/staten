<?php

class my_story {

    private $game;
    private $currentStoryPointNumero;
    private $story;
    private $currentStoryEventNumero;
    private $event;

    ///evenement
    const POINT = 0;
    const POINTSCORE = 1; //  incremente le score
    // event service
    const SWITCHSERV = 2;
    const SERVOK1 = 3;
    const SERVOK2 = 4;
    const SERVFAULEB1 = 5;
    const SERVFAULEB2 = 6;
    const SERVACE = 7;
    const FAULTNET = 10;
    const FAULTOUT = 11;
    const RETURNWIN = 15;
    const RETURNFAULT = 16;

    public function __construct($game) {

        $this->game = $game;
        $this->currentStoryPointNumero = 0;
        $this->currentStoryEventNumero = 0;
        $this->story = array();
        $this->StoryServ = array(); // non utilisé
        $this->resetevent(); // non utilisé
    }

    public function addevent($constevent, $player, $time = null) {
        $withpoint = $time == null ? true : false;
        $time = $time == null ? time() : $time;
        $idPlayer = is_object($player) ? $player->id() : $player;



        $idpoint = $this->getTotalPoint();
        $idevent = $this->getTotalEvent();
        $constevent = (int) $constevent;



        $tmpevent = array();
        $tmpevent['time'] = $time;
        $tmpevent['idpoint'] = $idpoint;
        $tmpevent['idevent'] = $idevent;
        $tmpevent['constevent'] = $constevent;
        $tmpevent['idPlayer'] = $idPlayer;

        $this->event[$idevent] = $tmpevent;


        if ($this->game->joueur1()->id() == $idPlayer) {
            $player = $this->game->joueur1();
            $playeraversaire = $this->game->joueur2();
        } elseif ($this->game->joueur2()->id() == $idPlayer) {
            $player = $this->game->joueur2();
            $playeraversaire = $this->game->joueur1();
        }

        $this->currentStoryEventNumero++;

        // evenement declenché supplementaire ( en plus de l ajout de l event 
        switch ($tmpevent['constevent']) {
            case self::POINTSCORE: // declencheur de l'ajout d un point
                $this->game->pointcallbyevent($player, $playeraversaire);
                break;
            case self::POINT: /// evenement je marque un point direct (pt gaganat ...)
                $this->addevent(my_story::POINTSCORE, $player);
                break;
            case self::FAULTNET: /// evenement je marque un point pour l'adversaire
                $this->addevent(my_story::POINTSCORE, $playeraversaire);
                break;
            case self::FAULTOUT: /// evenement je marque un point  pour l'adversaire
                $this->addevent(my_story::POINTSCORE, $playeraversaire);
                break;
            case self::RETURNFAULT: /// evenement je marque un point  pour l'adversaire
                $this->addevent(my_story::POINTSCORE, $playeraversaire);
                break;
            case self::RETURNWIN: /// evenement je marque un point  pour l'adversaire
                $this->addevent(my_story::POINTSCORE, $player);
                break;
            case self::SERVOK1:
                // on change l 'etat du service
                $this->game->getCurrentSet()->getCurrentJeu()->setstateservend();
                break;
            case self::SERVOK2:
                // on change l 'etat du service
                $this->game->getCurrentSet()->getCurrentJeu()->setstateservend();
                break;
            case self::SERVFAULEB1:

                // faute de premier service il faut l'indiquer
                $this->game->getCurrentSet()->getCurrentJeu()->setstateservsecondball();
                break;

            case self::SERVFAULEB2:

                // faute de second service donc double faute
                // on doit generer un point
                if ($this->game->joueur1() == $this->game->getCurrentServ()) {
                    $this->addevent(my_story::POINTSCORE, $this->game->joueur2());
                } elseif ($this->game->joueur2() == $this->game->getCurrentServ()) {
                    $this->addevent(my_story::POINTSCORE, $this->game->joueur1());
                }

                break;
            case self::SERVACE:
                // on doit generer un point en plus de cet evebnement

                $this->addevent(my_story::POINTSCORE, $this->game->getCurrentServ());

                break;
            case self::SWITCHSERV:
                // il faut modifier le serveur courant 
                // aucun impact autre dans le jeu

                if ($this->game->getCurrentServ() == $this->game->joueur1()) {
                    $this->game->setCurrentServ($this->game->joueur2());
                } else {
                    $this->game->setCurrentServ($this->game->joueur1());
                }

                break;

            case "xx":
                //echo "i égal 1";
                break;
        }



//                if ($numserv == 1) { // premier service
//            if ($numball == 1) { //premiere balle
//                $this->game->getStory()->addevent(my_story::SERVFAULES1B1, $this->game->getCurrentServ());
//            } elseif ($numball == 2) {// duxieme balle
//                $this->game->getStory()->addevent(my_story::SERVFAULES1B2, $this->game->getCurrentServ());
//            }
//        } elseif ($numserv == 2) { //deuxieme service
//            if ($numball == 1) { //premiere balle
//                $this->game->getStory()->addevent(my_story::SERVFAULES2B1, $this->game->getCurrentServ());
//            } elseif ($numball == 2) {//deuxieme ball
//                $this->game->getStory()->addevent(my_story::SERVFAULES2B2, $this->game->getCurrentServ());
//            }
//        }
    }

    private function point($gagnant) {
        $idPlayer = is_object($gagnant) ? $gagnant->id() : $gagnant;

        $this->story[$this->currentStoryPointNumero] = $idPlayer;
// $this->story[$this->currentStoryPointNumero] = $this->game->getCurrentServ();
        $this->currentStoryPointNumero++;
    }

    public function getReadableStoryScore() {
// on va creer une "game"
//parcourir la story en recuperant les score courants
// on recherche les informations en live ca permettra de faire  les stats
        $readablestory = array();
        $readablestory[] = "start";
        $nGame = new my_game();
        $nGame->setjoueur1($this->game->joueur1());
        $nGame->setjoueur2($this->game->joueur2());
        $nGame->setConfig($this->game->getConfig());

        $tgameCurentScore = array();

        foreach ($this->event as $value => $elem) {
            $gameCurentScore = $nGame->getCurrentScore();

            if ($nGame->getCurrentServ() == $nGame->joueur1()) {
                $gameCurentScore["serveur"] = "j1";
            } else {
                $gameCurentScore["serveur"] = "j2";
            }

// on ne regarde que les evenement point pour le score 
            if ($elem["constevent"] == self::POINTSCORE) {
                if ($elem["idPlayer"] == $nGame->joueur1()->id()) {
                    $nGame->getStory()->addevent($elem["constevent"], $nGame->joueur1(), $elem["time"]);
                    $gameCurentScore["winpt"] = "j1";
                } else {
                    $nGame->getStory()->addevent($elem["constevent"], $nGame->joueur2(), $elem["time"]);
                    $gameCurentScore["winpt"] = "j2";
                            
                }
                $tgameCurentScore[] = $gameCurentScore;
            }










//          if ($nGame->getCurrentServ() == $nGame->joueur1()) {
//              $gameCurentScore["serveur"] = "j1";
//          } else {
//              $gameCurentScore["serveur"] = "j2";
//          }
//            if ($elem == $nGame->joueur1()->id()) {
//               $nGame->pointj1();
//              $gameCurentScore["winpt"] = "j1";
//           } else {
////                $nGame->pointj2();
//                $gameCurentScore["winpt"] = "j2";
//            }
//            $tgameCurentScore[] = $gameCurentScore;
        }



        return $tgameCurentScore;
    }

    public function getTotalPoint() {
        return $this->currentStoryPointNumero;
    }

    public function getTotalEvent() {
        return $this->currentStoryEventNumero;
// ou count ..?
    }

    public function getallevent() {
        return $this->event;
    }

    public function getallsory() {
        return $this->story;
    }

    public function resetevent() {
        $this->event = array();
        $this->currentStoryEventNumero = 0;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
