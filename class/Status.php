<?php
class Status extends CRUD{
    public $table = 'status';
    public $field = 'status_id';


    function __construct() {    
        //https://www.php.net/manual/en/language.oop5.decon.php
        parent::__construct('mysql:host=localhost;dbname=TP01-librairie', 'root', '');
    }
 
}