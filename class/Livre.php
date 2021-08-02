<?php
class Livre extends CRUD {
    public $table = 'livre';
    public $field = 'livre_id';


    function __construct() {    
        //https://www.php.net/manual/en/language.oop5.decon.php
        parent::__construct('mysql:host=localhost;dbname=TP01-librairie', 'root', '');
    }

    public function getCategories($livreId)
    {
        $sql = "SELECT * FROM categorie
                JOIN categorie_livre_cl ON categorie_id = cl_categorie_id
                  JOIN livre ON livre_id = cl_livre_id
                  WHERE livre_id = $livreId";
        $stmt=$this->query($sql);

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $tab[] = $row['nom_categorie'];            
        }
        $tab = implode(" | ", $tab);
        return $tab;
    }
}