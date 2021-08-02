<?php
class Commande extends CRUD{
    public $table = 'commande';
    public $field = 'commande_id';


    function __construct() {    
        //https://www.php.net/manual/en/language.oop5.decon.php
        parent::__construct('mysql:host=localhost;dbname=TP01-librairie', 'root', '');
    }

    public function getLivres($commandeId)
    {
        $sql = "SELECT * FROM commande
                JOIN commande_has_livre ON commande_commande_id = commande_id
                JOIN livre ON livre_id = commande_livre_id
                WHERE commande_id = $commandeId";
        $stmt=$this->query($sql);

        $result = $stmt->fetchAll();
        return $result;
    }

    public function setStatus($commandeId)
    {
        $sql = "SELECT nom_status FROM commande
                JOIN status ON commande_status_id = status_id
                WHERE commande_id = $commandeId";
        $stmt=$this->query($sql);

        $result = $stmt->fetch();

        return $result['nom_status'];
    }
}