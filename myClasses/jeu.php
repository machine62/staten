<?php

class my_jeu extends my_abstractstaten {

    private $set; //reference au parent Set '
    private $numberJeuInSet; // numero du jeu dans le set parent
    private $currentScore = [];
    private $currentptsNumero = 1; //jeu courant
    private $isTieBreack = false;
    private $nbPointforWinTie = 0;
    //uniquementtie break 
    //nb la gestion du service a deplacer dans le jeu (plus logique ..?)
    private $firstserv;
    private $nbserv;
    // ajouter etat du point en cours
    private $stateserv; // premiere ou deuxieme service
    private $stateservball; // premier ou deuxieme balle
    private $stateservend; // si true, le service (premier ou deuxieme est passé le jeu est en cours ...) si false le service est en cours

    public function __construct($set, $num, $tieBreack = null) {

        $this->set = $set; // reference du set
        $this->numberJeuInSet = $num; // numero du jeu dans le set parent
        // si on appel tie breack
        if (is_numeric($tieBreack)) {
            $this->isTieBreack = true;
            $this->nbPointforWinTie = (int) $tieBreack;
            $this->firstserv = $this->set->getGame()->getCurrentServ();
            $this->nbserv = 1;
        }


        $this->currentScore = [
            $set->getGame()->joueur1()->id() => "00",
            $set->getGame()->joueur2()->id() => "00"
        ];
        $this->set->getGame()->currentServSwitch();


        $this->initstate();
    }

    private function initstate() {
        $this->stateserv = 1; // premiere ou deuxieme service
        $this->stateservball = 1; // premiere ou deuxieme balle
        $this->stateservend = false; // premiere ou deuxieme balle
    }

    public function getstateserv() {
        return $this->stateserv;
    }

    public function setstatesecondserv() {
         $this->stateserv = 2;
    }

    public function getstateservball() {
        return $this->stateservball;
    }

    public function setstateservsecondball() {
         $this->stateservball = 2;
    }

    public function getstateservend() {
        return $this->stateservend;
    }

    public function setstateservend() {
        $this->stateservend = true;
    }

    private function getCurrentScore($playerId) {
        return $this->currentScore[$playerId];
    }

    public function getCurrentScoreJoueur1() {
        return $this->getCurrentScore($this->set->getGame()->joueur1()->id());
    }

    public function getCurrentScoreJoueur2() {
        return $this->getCurrentScore($this->set->getGame()->joueur2()->id());
    }

    public function getCurrentnumberPt(): int {
        return $this->currentptsNumero;
        //  return $this->currentSet;
    }

    public function getIsTieBreack() {
        return $this->isTieBreack;
    }

    public function getNbPointforWinTie() {
        return $this->nbPointforWinTie;
    }

    private function playerWin($id_gagnant) {
        $this->currentScore[$id_gagnant] = "Win"; //a voir plus tard ( gaganant = bool

        $this->setWinner($id_gagnant);
        $this->setIsEnd(true);
        //$this->winner = $id_gagnant;
        //$this->isEnd = true;
    }

    public function point($gagnant, $perdant) {
        // ajout d un point pour suivi numero du pt dans le jeu
        $this->currentptsNumero++;

        // si point on reinitialise 
        $this->initstate();

        if ($this->getIsTieBreack()) {
            return $this->pointwithTie($gagnant, $perdant);
        }

        return $this->pointNoTie($gagnant, $perdant);
    }

    private function pointwithTie($gagnant, $perdant) {
        $id_gagnant = $gagnant->id();
        $id_perdant = $perdant->id();

        $isNoAd = $this->set->getGame()->getConfig()->getIsNoAd();
        $this->currentScore[$id_gagnant] = (int) $this->currentScore[$id_gagnant] + 1;


        // on recupere le score du gaganant du point
        $ptgaganant = $this->currentScore[$id_gagnant];
        $ptperdant = $this->currentScore[$id_perdant];

        // préparation prochain service :
        $this->nbserv++;
        if ($this->nbserv == 2) {
            $this->nbserv = 0;
            $this->set->getGame()->currentServSwitch();
        }



        // fin de tie break
        if ($ptgaganant >= $this->getNbPointforWinTie()) {
            if (($ptgaganant - $ptperdant) > 1) {
                //fin 

                $this->playerWin($id_gagnant);
                // on rend la main a game pour gestion du service
                $this->set->getGame()->setCurrentServ($this->firstserv);
                $this->set->getGame()->currentServSwitch();
                return $this->isEnd();
            }
        }


        //tout autre cas


        return $this->isEnd();
    }

    private function pointNoTie($gagnant, $perdant) {

        $id_gagnant = $gagnant->id();
        $id_perdant = $perdant->id();

        $isNoAd = $this->set->getGame()->getConfig()->getIsNoAd();

        // on recupere le score du gaganant du point
        $ptgaganant = $this->currentScore[$id_gagnant];

        switch ($ptgaganant) {
            case "0":

                $this->currentScore[$id_gagnant] = "15";
                break;
            case "15" :

                $this->currentScore[$id_gagnant] = "30";
                break;
            case "30" :

                // si adversaire est a 40
                if ($this->currentScore[$id_perdant] == "40") {
                    // var_dump( $this->currentscore[$id_perdant]);
                    $this->currentScore[$id_gagnant] = "40A";
                    $this->currentScore[$id_perdant] = "40A";
                } else {
                    $this->currentScore[$id_gagnant] = "40";
                }

                break;
            case "40":

                // si pas d'avaantage le premier  qui marque en ayant 40 gagane
                if ($isNoAd) { // sans avantage 
                    $this->playerWin($id_gagnant);
                } else { // avec avantage 
                    if ($this->currentScore[$id_perdant] == "AD") {
                        $this->currentScore[$id_perdant] = "40A";
                        $this->currentScore[$id_gagnant] = "40A";
                    } else { // tout autre cas, c'est le gain'
                        $this->playerWin($id_gagnant);
                    }
                }


                break;
            case "40A": // si egalité

                if ($isNoAd) { // sans avantage 
                    $this->playerWin($id_gagnant);
                } else { // avec avantage 
                    $this->currentScore[$id_gagnant] = "AD";
                    $this->currentScore[$id_perdant] = "40";
                }
                break;
            case "AD": //si avantage gain

                $this->playerWin($id_gagnant);
                break;
            default: //n existe pas
                $this->currentScore[$id_gagnant] = "???";  // pour debug
                break;
        }

        return $this->isEnd();
    }

}
