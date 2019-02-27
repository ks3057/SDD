<?php
class Person {
  private $PersonID, $LastName, $FirstName, $NickName;
  
  public function __set($prop, $val) {
    echo "__set() called for $prop:$val<br/>";
    $this->$prop = $val;
  }
  
  public function __get($prop) {
    if ( $prop != "props" ) {
      echo "__get() called for $prop: {$this->props[$prop]}<br/>";
      return $this->$prop;
    }
  }
  
  public function who_am_i() {
    return "I am {$this->FirstName} {$this->LastName} and my
            nicname is {$this->NickName}.";
  }

}

?>