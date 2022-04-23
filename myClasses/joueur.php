<?php

class my_joueur {

    private $nom;
    private $prenom;
    private $classement;
    private $id;

    public function __construct(int $id, string $nom = "Joueur ", string $prenom = " 1 ", string $classement = "NC") {

        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->classement = $classement;
    }

    public function id(): string {
        return $this->id;
    }

    public function nom(): string {
        return $this->nom;
    }

    public function prenom(): string {
        return $this->prenom;
    }

    public function setNom($sNom) {
        $this->nom = $sNom;
    }

    public function setPrenom($sPrenom) {
        $this->prenom = $sPrenom;
    }

    public function classement(): string {
        return $this->classement;
    }

    public function nomComplet(): string {
        return $this->prenom . ' ' . $this->nom;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function Unserialize($oContent) {
        $this->setNom($oContent->nom);
        $this->setPrenom($oContent->prenom);
        // privé
        $this->id=$oContent->id;
        $this->classement=$oContent->classement;
      
    }

}
