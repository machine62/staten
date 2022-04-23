<?php

class my_game extends my_abstractstaten {

    private $idGame;
    private $microtime;
    private $date;
    private $config;
    private $joueur1;
    private $joueur2;
    private $sets = array(); //Coneneur de set;
    //   private $currentSet;
    private $currentSetNumero = 0;
    private $story;
    private $currentServ;

    public function __construct(my_joueur $j1 = null, my_joueur $j2 = null) {
        $this->microtime = microtime(true);
        $this->date = time();


        $this->idGame = date('Ymd-') . md5($this->microtime);

        $id = 1;
        $id2 = 2;
        $this->joueur1 = (is_null($j1)) ? new my_joueur($id, "Joueur", "1", "NC") : $j1;
        $this->joueur2 = (is_null($j2)) ? new my_joueur($id2, "Joueur", "2", "NC") : $j2;

        $this->setConfig(new my_gameConfig()); // s'initialise avec conf par defaut
        //
        //
        //
        //
        //
        //$this->nouveauSet();
        $this->resetGame();
    }

    private function nouveauSet($supertiebreack = false) {

        $this->currentSetNumero++;
        $this->sets[$this->currentSetNumero] = new my_set($this, $this->currentSetNumero, $supertiebreack);
    }

    private function resetGame() {
        /// remie a 0 des elements du score / story /gagnant
        $this->currentSetNumero = 0;

        $this->sets = array();

        $this->setWinner(null);
        $this->setIsEnd(false);

        $this->story = new my_story($this);

        $this->nouveauSet();
    }

    public function replayGame($tmpevent, $retour = 0) {
        // on revient en arriere
        ///pour se faire on va dérouler la story moins 1


        $last = count($tmpevent) - $retour;

        // on va réinitialiser tous les elements non stable (score ...)
        $this->resetGame();
        $this->currentServ = $this->getConfig()->getFirstServ();
//var_dump($tmpevent[$i]);
        // on veut rejouer la partie, on repasse tous les event juste pour les points
        for ($i = 0; $i < $last; $i++) {
            $tmpevent[$i] = json_decode(json_encode($tmpevent[$i]), TRUE);

            //suelement point 
            if ($tmpevent[$i]["constevent"] == my_story::POINT) {
                // seulement si point  mais on ne rajoute pas le evenment lié
                if ($tmpevent[$i]["idPlayer"] == $this->joueur1()->id()) {
                    $this->pointj1();
                } else {
                    $this->pointj2();
                }
            }

            //suelement switch serv 
            if ($tmpevent[$i]["constevent"] == my_story::SWITCHSERV) {
                // seulement si point  mais on ne rajoute pas le evenment lié
               
                if ($tmpevent[$i]["idPlayer"] == $this->joueur1()->id()) {
                     $this->setCurrentServ($this->joueur1());
                } else {
                     $this->setCurrentServ($this->joueur2());
                }
            }
        }

        $this->getStory()->resetevent();

        // on veut rejouer la partie, on repasse tous les event juste recuperer l ensemble des evenement sans les points
        for ($i = 0; $i < $last; $i++) {
            //   json_decode(json_encode($tmpevent[$i]), TRUE);
            // on ajoute l evenement dans tous les cas
            $p = ($tmpevent[$i]["idPlayer"] == $this->joueur1()->id()) ? $this->joueur1() : $this->joueur2()->id();
            $this->getStory()->addevent($tmpevent[$i]['constevent'], $p, $tmpevent[$i]['time']);
        }
    }

    public function redo() {

        $this->replayGame($this->getStory()->jsonSerialize()["event"], 1);
    }

    public function pointj1() {
        $this->point($this->joueur1(), $this->joueur2());
    }

    public function pointj2() {
        $this->point($this->joueur2(), $this->joueur1());
    }

    private function point($gagnant, $perdant) {


        if ($this->isEnd()) {
            //var_dump("the end");
            //return null;
        }

        $this->story->addevent(my_story::POINT, $gagnant);



        //$this->story->point($gagnant);
        //ajout du point dan s le set courant
        $this->getCurrentSet()->point($gagnant, $perdant);
        if ($this->getCurrentSet()->isEnd()) {

            $jeuxGagnant = $this->getSetWin($gagnant);
            $jeuxPerdant = $this->getSetWin($perdant);
            $diff = $jeuxGagnant - $jeuxPerdant;

            if ($jeuxGagnant != $this->config->getSetForWinGame()) {
                if ($this->getConfig()->isSuperTiebreackEnable()) {
                    if ($this->getCurrentnumberSet() == (($this->getConfig()->getSetForWinGame() - 1) * 2)) {
                        /// dans ce cas super tie breack 
                        $supertiebreack = true;
                        $this->nouveauSet($supertiebreack);
                    } else {
                        // la partie continue
                        $this->nouveauSet();
                    }
                } else {
                    // la partie continue
                    $this->nouveauSet();
                }
            } else {
                $this->setWinner($gagnant->id());
                $this->setIsEnd(true);
            }
        }
    }

    public function joueur1(): my_joueur {
        return $this->joueur1;
    }

    public function joueur2(): my_joueur {
        return $this->joueur2;
    }

    public function setjoueur1($j1) {
        $this->joueur1 = $j1;
    }

    public function setjoueur2($j2) {
        $this->joueur2 = $j2;
    }

    public function getCurrentSet(): my_set {
        return $this->sets[$this->currentSetNumero];
        //  return $this->currentSet;
    }

    public function getCurrentnumberSet(): int {
        return $this->currentSetNumero;
        //  return $this->currentSet;
    }

    public function getSetByNumber($numero) {
        if (isset($this->sets[(int) $numero])) {
            return $this->sets[(int) $numero];
        }
        return null;
    }

    public function getSetWin($joueur) {
        $nb = 0;
        $tabJeux = $this->sets;
        foreach ($tabJeux as $setNumber => $set) {
            if ($set->getWinner() == $joueur->id()) {

                $nb++;
            }
        }
        return $nb;
    }

    public function getConfig(): my_gameConfig {
        return $this->config;
    }

    public function setConfig($conf) {
        $this->config = $conf;
    }

    public function getStory(): my_story {
        return $this->story;
    }

    public function getCurrentScore() {
        $retour = array();

        $retour["j1"]["sets"] = array();
        $retour["j2"]["sets"] = array();
        for ($index = 1; $index < 6; $index++) {
            if (!is_null($this->getSetByNumber($index))) {
                $retour["j1"]["sets"][$index] = $this->getSetByNumber($index)->getJeuxWin($this->joueur1());
            }
        }
        for ($index = 1; $index < 6; $index++) {
            if (!is_null($this->getSetByNumber($index))) {
                $retour["j2"]["sets"][$index] = $this->getSetByNumber($index)->getJeuxWin($this->joueur2());
            }
        }


        $retour["j1"]["jeu"] = $this->getCurrentSet()->getJeuxWin($this->joueur1());
        $retour["j2"]["jeu"] = $this->getCurrentSet()->getJeuxWin($this->joueur2());
        $retour["j1"]["pt"] = $this->getCurrentSet()->getCurrentJeu()->getCurrentScoreJoueur1();
        $retour["j2"]["pt"] = $this->getCurrentSet()->getCurrentJeu()->getCurrentScoreJoueur2();

        $retour["numberset"] = $this->getCurrentnumberSet();
        $retour["numberjeu"] = $this->getCurrentSet()->getCurrentnumberJeu();
        $retour["numberpt"] = $this->getCurrentSet()->getCurrentJeu()->getCurrentnumberPt();


        return $retour;
    }

    public function currentServSwitch() {


        if (is_object($this->currentServ)) {
            // pas de reposne
            if ($this->currentServ->id() == $this->joueur1->id()) {
                $this->currentServ = $this->joueur2;
            } elseif ($this->currentServ->id() == $this->joueur2->id()) {
                $this->currentServ = $this->joueur1;
            }
        } else {
            $this->currentServ = $this->getConfig()->getFirstServ();
        }
    }

    public function getCurrentServ() {
        return $this->currentServ;
    }

    public function setCurrentServ($j) {
        $this->currentServ = $j;
    }

    public function id() {
        return $this->idGame;
    }

    public function getDate() {
        return $this->date;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function fulljsonSerialize() {
        $game = $this->jsonSerialize();
        $config = $this->getConfig()->jsonSerialize();
        $joueur1 = $this->joueur1()->jsonSerialize();
        $joueur2 = $this->joueur2()->jsonSerialize();
        $story = $this->getStory()->jsonSerialize();

        $retour = array();
        $retour["game"] = $game;
        $retour["config"] = $config;
        $retour["joueur1"] = $joueur1;
        $retour["joueur2"] = $joueur2;
        $retour["story"] = $story;

        return json_encode($retour);
    }

    public function fulljsonUNSerialize($json) {
        //recuperer
        // info game
        // info conf
        //info p1
        //info p2
        //
        // story
        // relire le match => avoir object sert / jeu
        $oContent = json_decode($json);

        // info game /privé
        $this->microtime = $oContent->game->microtime;
        $this->date = $oContent->game->date;
        $this->idGame = $oContent->game->idGame;


        // joueur
        $this->joueur1()->Unserialize($oContent->joueur1);
        $this->joueur2()->Unserialize($oContent->joueur2);

//echo "<pre>";
//var_dump("avant");
//print_r($oContent->config);
        // configuration
        $this->getConfig()->Unserialize($oContent->config);
        // ajout du serveur / Game non dispo dans config:
        if ($oContent->config->firstservID == $this->joueur1->id()) {
            $this->getConfig()->setFirstServ($this->joueur1);
        } else {
            $this->getConfig()->setFirstServ($this->joueur2);
        }
//var_dump("apres");
//print_r($this->getConfig());
//echo "</pre>";
//die();
        // story
        // il faut parcourir la partie
        $this->replayGame($oContent->story->event, 0);

        // echo "<pre>";
        //  print_r($oContent->story->event);
        //echo "</pre>";
        // die();
    }

}
