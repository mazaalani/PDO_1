<?php

abstract class CRUD extends PDO{

  protected $table;
  protected $field;

  public function __construct(){
    //connection PDO
    parent::__construct('mysql:host=localhost;dbname=TP01-librairie', 'root', '');
    //https://www.php.net/manual/en/pdostatement.fetch.php
    $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }

  public function insert($table, $data){
    $fieldName = implode(", ",array_keys($data));
    $fieldValues = ':'.implode(", :", array_keys($data));
    $sql ="INSERT INTO $table ($fieldName) VALUES ($fieldValues)";
    $stmt = $this->prepare($sql);

    foreach($data as $key => $value){
      $stmt->bindValue(":".$key, $value);
    }

    if(!$stmt->execute()){
      $stmt->erroInfo();
    }else{
      return "Ajouté avec succés";
    }
  }

  public function select($orderField = null, $order = null){
    if($orderField == null){
      $sql = "SELECT * FROM $this->table";
    }else{
      $sql = "SELECT * FROM $this->table ORDER BY $orderField $order";
    }
    $stmt=$this->query($sql);

    return $stmt->fetchAll();
  }

  public function selectId($value){
    $sql = "SELECT * FROM $this->table WHERE $this->field = $value";
    $stmt=$this->query($sql);
    return $stmt->fetch();
  }

  public function selectAll($value){
    $sql = "SELECT * FROM $this->table WHERE $this->field = $value";
    $stmt=$this->query($sql);
    return $stmt->fetchAll();
  }

  public function selectJoin($value, $join = null, $table2 = null, $join2 = null, $table3 = null,  $field2= null, $value2= null){
    if ($join) {
      if($join2) {
        $sql = "SELECT * FROM $this->table 
                JOIN $table2 ON $this->field = $value
                JOIN $table3 ON $this->field2 = $value2";
        $stmt=$this->query($sql);
      }else {
        $sql = "SELECT * FROM $this->table JOIN $table2 ON $this->field = $value";
        $stmt=$this->query($sql);
      }
    } else {
      $sql = "SELECT * FROM $this->table WHERE $this->field = $value";
      $stmt=$this->query($sql);        
    }
    return $stmt->fetchAll();
  }

  public function update($table, $data, $fieldId, $valueId){
    $fieldDetails = null;
    foreach($data as $key=>$value){
        $fieldDetails .= "$key=:$key,";
    }

    $fieldDetails = rtrim($fieldDetails, ',');

    $sql= "UPDATE $table SET $fieldDetails  WHERE $fieldId = $valueId";

    $stmt = $this->prepare($sql);

    foreach($data as $key=>$value){
      $stmt->bindValue(":$key", $value);
    }

    if(!$stmt->execute()){
      print_r($stmt->errorInfo());
    }else{
        return "Mise à jour effectuée avec succés";
    }

  }

  public function delete($table, $fieldId, $valueId, $fieldId2 = null, $valueId2 = null){
    if($fieldId2 && $valueId2) {
      $sql = "DELETE FROM $table WHERE 
              $fieldId =:$fieldId AND
              $fieldId2 =:$fieldId2";
      $stmt = $this->prepare($sql);
      $stmt->bindValue(":$fieldId", $valueId);
      $stmt->bindValue(":$fieldId2", $valueId2);
    } else {
      $sql = "DELETE FROM $table WHERE $fieldId =:$fieldId";
      $stmt = $this->prepare($sql);
      $stmt->bindValue(":$fieldId", $valueId);
    }
      if(!$stmt->execute()){
        print_r($stmt->errorInfo());
      }else{
          return "Supprimé avec succés";
      }

  }
}
 ?>
