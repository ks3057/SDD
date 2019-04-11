<?php
// By default, json_encode() won't include private instance variables
// when serializing an object, so implement the JsonSerializable interface
// and define jsonSerialize so that private members can be serialized.

class Product implements JsonSerializable {
  private $name;
  private $id;
  
  public function __construct( $name="tbd", $id="tbd" ) {
    $this->name = $name;
    $this->id = $id; 
  }
  
  public function getName() {
    return $this->name; 
  }
  public function getId() {
    return $this->id;
  }
  
  public function setName( $name ) {
    $this->name = $name;
  }
  public function setId( $id ) {
    $this->id = $id;
  }
  
  public function jsonSerialize() {
    return [
      'id'   => $this->getId(),
      'name' => $this->getName()
    ];
  }
}
?>