<?php
class Client extends CRUD{
    public $table = 'client';
    public $field = 'client_id';


    function __construct() {    
        //https://www.php.net/manual/en/language.oop5.decon.php
        parent::__construct('mysql:host=localhost;dbname=TP01-librairie', 'root', '');
    }
 
    public function getCommandes($clientId)
    {
        $sql = "SELECT * FROM client
                JOIN commande ON commande_client_id = client_id
                WHERE client_id = $clientId";
        $stmt = $this->query($sql);
  
        $result = $stmt->fetchAll();
  
        return $result;
    }
}