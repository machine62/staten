<?php

class my_set extends my_abstractstaten {

    private $game;  // reference parente
    private $numberSetInGame; // numero du set d'appartenance
    private $jeux = []; //conteneur de jeu
    private $currentJeuNumero = 0;
    private $supertiebreack = false;

    public function __construct($game, $num, $supertiebreack) {
        $this->game = $game; // identifiant du set
        $this->numberSetInGame = $num; // identifiant du set
        $this->supertiebreack = $supertiebreack;

        $this->startNouveauJeu();
    }

    private function startNouveauJeu() {
        // ici vérification tie breack
        // tie breack si set j1 = set j2 = numbersetingame
        // ou si current set = nb set pour gagner *2 + 1
        //   plugin_debug::addSpy("current set", $this->game->getCurrentSet()->getCurrentnumberJeu());
        $this->currentJeuNumero++;
        $tmpnewgame = false;


        // si petit tie break est autotisé
        if ($this->game->getConfig()->isTiebreackEnable()) {
            // si le nombre de jeu suppose le tie brack 
            if ((int) ($this->currentJeuNumero ) == (int) ((int) $this->game->getConfig()->getjeuForWinSet() * 2) + 1) {
                // alors tie break
                $tmpnewgame = true;
                $this->jeux[$this->currentJeuNumero] = new my_jeu($this, $this->currentJeuNumero, $this->game->getConfig()->TiebreackNumber()); //stockage de l'ancien jeu
            }
        }


        // gros  tie breack
        if ($this->supertiebreack) {
            // alors tie break
            $tmpnewgame = true;
            $this->jeux[$this->currentJeuNumero] = new my_jeu($this, $this->currentJeuNumero, $this->game->getConfig()->superTiebreackNumber()); //stockage de l'ancien jeu
        }



        // tout autre cas, jeu normal
        if (!$tmpnewgame) {
            $this->jeux[$this->currentJeuNumero] = new my_jeu($this, $this->currentJeuNumero); //stockage de l'ancien jeu 
        }
    }

    public function getGame(): my_game {
        return $this->game;
    }

    public function getCurrentJeu(): my_jeu {

        return $this->jeux[$this->currentJeuNumero];
    }

    public function getCurrentnumberJeu(): int {
        return $this->currentJeuNumero;
        //  return $this->currentSet;
    }

    private function issetCurrentJeu(): bool {
        return isset($this->jeux[$this->currentJeuNumero]);
    }

    private function playerWin($id_gagnant) {
        $this->setWinner($id_gagnant);
        $this->setIsEnd(true);
    }

    public function point($gagnant, $perdant) {
        // on transfert la demande au jeu
        $this->getCurrentJeu()->point($gagnant, $perdant);

        // si le jeu est fini, on archive de suite
        // on recuper les score de chacun 
        $jeuxGagnant = $this->getJeuxWin($gagnant);
        $jeuxPerdant = $this->getJeuxWin($perdant);
        $diff = $jeuxGagnant - $jeuxPerdant;

        if ($jeuxGagnant == $this->game->getConfig()->getjeuForWinSet()) { /// dans ce cas, on check si tie break autrement gain
            if ($diff >= 2) {
                $this->playerWin($gagnant->id());
            } else {
                if ($this->getCurrentJeu()->isEnd()) {
                    $this->startNouveauJeu();
                }
            }
        } elseif ($jeuxGagnant > $this->game->getConfig()->getjeuForWinSet()) { // nous etions au tie breack => gain puisqu'on depasse le nb de set
            $this->playerWin($gagnant->id());
        } else { ///dans tous les autres cas, nous n'atteignons pas le nb de jeu pour gagner le set
            if ($this->getCurrentJeu()->isEnd()) {
                if ($this->supertiebreack) {
                    $this->playerWin($gagnant->id());
                } else {
                    $this->startNouveauJeu();
                }
            }
        }


        //if ($jeuxGagnant < $this->game->getConfig()->getjeuForWinSet()) { // si plus petit  que le nb de jeu a atteindre par set
        // on poursuit, pas d'action niveau set
        //    if ($this->getCurrentJeu()->isEnd()) {
        //        $this->startNouveauJeu();
        //    }
        // } elseif ($diff >= 2) { // difference de 2 fin
        //   $this->setWinner($gagnant->id());
        //  $this->setIsEnd(true);
        //} else {
        /// dans ce cas la pas finio 
        //voir pour tie breack
        //    $this->startNouveauJeu();
        //}
        //  if ($jeuxGagnant < $this->game->getConfig()->getjeuForWinSet()) { // si plus petit  que le nb de jeu a atteindre par set
        // on poursuit, pas d'action niveau set
        //     if ($this->getCurrentJeu()->isEnd()) {
        //        $this->startNouveauJeu();
        //}
        // } elseif ($diff >= 2) { // difference de 2 fin
        //    $this->setWinner($gagnant->id());
        //   $this->setIsEnd(true);
        // } else {
        /// dans ce cas la pas finio 
        //voir pour tie breack
        //   $this->startNouveauJeu();
        //}
        ///var_dump($this->getCurrentJeu());
        return $this->isEnd();
    }

    public function getJeuxWin($joueur) {
        $nb = 0;
        $tabJeux = $this->jeux;
        foreach ($tabJeux as $jeuNumber => $jeu) {
            if ($jeu->getWinner() == $joueur->id()) {

                $nb++;
            }
        }
        return $nb;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
