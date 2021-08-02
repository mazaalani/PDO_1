<?php
class CHL extends CRUD{
    public $table = 'commande_has_livre';
    public $field = 'commande_commande_id';

    function __construct() {    
        parent::__construct('mysql:host=localhost;dbname=TP01-librairie', 'root', '');
        
    }

}