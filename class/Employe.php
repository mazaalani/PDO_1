<?php
class Employe  extends CRUD{
    public $table = 'employe';
    public $field = 'employe_id';


    function __construct() {    
        //https://www.php.net/manual/en/language.oop5.decon.php
        parent::__construct('mysql:host=localhost;dbname=TP01-librairie', 'root', '');
    }
}