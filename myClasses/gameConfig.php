<?php

class my_gameConfig {

    private $setForWinGame = 2;
    private $jeuForWinSet = 2;
    private $noAd = False; // avec avantage ou non 
    private $isTiebreack = True;
    private $TiebreackNumber = 7;
    private $isSuperTiebreack = True;
    private $superTiebreackNumber = 10;
    private $firstserv = 'none';
    public $firstservID = 0;

    public function __construct() {
        
    }

    public function getSetForWinGame() {
        return $this->setForWinGame;
    }

    public function getjeuForWinSet() {
        return $this->jeuForWinSet;
    }

    public function getIsNoAd() {
        return $this->noAd;
    }

    public function isTiebreackEnable() {
        return $this->isTiebreack;
    }

    public function TiebreackNumber() {
        return $this->TiebreackNumber;
    }

    public function isSuperTiebreackEnable() {
        return $this->isSuperTiebreack;
    }

    public function superTiebreackNumber() {
        return $this->superTiebreackNumber;
    }

    public function SetSetForWinGame($number) {
        $this->setForWinGame = (int) $number;
    }

    public function setJeuForWinSet($number) {
        $this->jeuForWinSet = $number;
    }

    public function setIsNoAd($noad) {
        //var_dump("dans conf avant");
        //var_dump($noad);
        $this->noAd = (bool) $noad;
        //var_dump("dans conf apres");
        //var_dump($this->noAd);
    }

    public function setIsTiebreackEnable($istiebreack) {
        $this->isTiebreack = (bool) $istiebreack;
    }

    public function setTiebreackNumber($number) {
        $this->TiebreackNumber = (int) $number;
    }

    public function setisSuperTiebreackEnable($issupertiebreack) {
        $this->isSuperTiebreack = (bool) $issupertiebreack;
    }

    public function setsuperTiebreackNumber($number) {
        $this->superTiebreackNumber = (int) $number;
    }

    public function setFirstServ($j) {
        $this->firstserv = $j;
        $this->firstservID = $j->id();
    }

    public function getFirstServ() {
        return $this->firstserv;
    }

    public function getFirstServID() {
        return $this->firstservID;
    }

    public function jsonSerialize() {
        $retour = get_object_vars($this);
        //  echo "<pre>";
        //  var_dump($retour['firstserv']);
        //   var_dump($this->firstserv);
        //   var_dump($this);
        //   echo "</pre>";
        //   die();
        //  $retour['firstserv'] = $this->firstserv; // jute l'id du joueur




        return $retour;
    }

    public function Unserialize($oContent) {
        $this->SetSetForWinGame($oContent->setForWinGame);
        $this->setJeuForWinSet($oContent->jeuForWinSet);
        $this->setIsNoAd($oContent->noAd);
        $this->setisSuperTiebreackEnable($oContent->isSuperTiebreack);
        $this->setsuperTiebreackNumber($oContent->superTiebreackNumber);
        $this->setIsTiebreackEnable($oContent->isTiebreack);
        $this->setTiebreackNumber($oContent->TiebreackNumber);

        // il ne faut sauvegarder que l'ID du joueur
    }

}
