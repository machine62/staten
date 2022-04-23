<?php

class my_story {

    private $game;
    private $currentStoryPointNumero;
    private $story;
    private $currentStoryEventNumero;
    private $event;

    ///evenement
    const POINT = 0;
    
    
    // event service
    const SWITCHSERV = 1;
    
    const SERVOK1 = 2;
    const SERVOK2 = 3;
    
    const SERVFAULES1B1 = 4;
    const SERVFAULES1B2 = 5;
    const SERVFAULES2B1 = 6;
    const SERVFAULES2B2 = 7;
    
    
    

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

        
        // evenement declenché supplementaire ( en plus de l ajout de l event 
        switch ($tmpevent['constevent']) 
        {
            case self::SERVOK1:
                // on change l 'etat du service
                $this->game->getCurrentSet()->getCurrentJeu()->setstateservend();
                break;
           case self::SERVOK2:
                // on change l 'etat du service
                $this->game->getCurrentSet()->getCurrentJeu()->setstateservend();
                break;
            case "xx":
               //echo "i égal 1";
                break;
           
        }



        



        $this->currentStoryEventNumero++;
        if ($withpoint) {
            if ($constevent == self::POINT) {
                $this->point($player);
// $this->currentStoryEventNumero = 0; // remise a 0 des evenement pour prochainpoint   
            }
        }
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
            if ($elem["constevent"] == self::POINT) {
                if ($elem["idPlayer"] == $nGame->joueur1()->id()) {
                    $nGame->pointj1();
                    $gameCurentScore["winpt"] = "j1";
                } else {
                    $nGame->pointj2();
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
