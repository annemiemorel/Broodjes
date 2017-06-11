<?php
namespace Entities;
use Entities\Cursist;

class Cursist {

 private static $idMap = array();  //bevat alle reeds aangemaakte objecten van klasse Voornaam; static: slechts 1 lijst voor alle Voornaam-objecten   
 private $id;
 private $email;
 private $paswoord;

 private function __construct($id, $email, $paswoord) {
 $this->id = $id;
 $this->email = $email;
 $this->paswoord = $paswoord;
 
}

 public static function create($id, $email, $paswoord){
     if (!isset(self::$idMap[$id])) {  //geindexeerd met id van Boek-object: snel controleren of Boek-object met bepaalde id werd aangemaakt zonder hele array te overlopen
   self::$idMap[$id] = new Cursist($id, $email, $paswoord);  //indien er nog geen Boek-object met dit id bestaat, dan nieuw Boek-object aanmaken via constructor en aan lijst toevoegen
  } 
  return self::$idMap[$id];  //indien er wel Boek-object met dit id bestaat, dan wordt het bestaande object teruggegeven
 }
 
 public function getId() {
  return $this->id;
 }
 
 public function getEmail() {
  return $this->email;
 }
 
 public function getPaswoord(){
     return $this->paswoord;
 }
 

 public function setEmail($email) {
  $this->email = $email;
 }
 
 public function setPaswoord($paswoord){
     $this->paswoord=$paswoord;
}
 
}