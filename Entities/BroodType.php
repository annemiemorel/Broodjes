<?php
namespace Entities;
use Entities\BroodType;

class BroodType {

 private static $idMap = array();  //bevat alle reeds aangemaakte objecten van klasse Voornaam; static: slechts 1 lijst voor alle Voornaam-objecten   
 private $id;
 private $type;
 private $prijs;

 private function __construct($id, $type, $prijs) {
 $this->id = $id;
 $this->type = $type;
 $this->prijs = $prijs;
 
}

 public static function create($id, $type, $prijs){
     if (!isset(self::$idMap[$id])) {  //geindexeerd met id van Boek-object: snel controleren of Boek-object met bepaalde id werd aangemaakt zonder hele array te overlopen
   self::$idMap[$id] = new Cursist($id, $type, $prijs);  //indien er nog geen Boek-object met dit id bestaat, dan nieuw Boek-object aanmaken via constructor en aan lijst toevoegen
  } 
  return self::$idMap[$id];  //indien er wel Boek-object met dit id bestaat, dan wordt het bestaande object teruggegeven
 }
 
 public function getId() {
  return $this->id;
 }
 
 public function getType() {
  return $this->type;
 }
 
 public function getPrijs(){
     return $this->prijs;
 }
 

 public function setType($type) {
  $this->type = $type;
 }
 
 public function setPrijs($prijs){
     $this->prijs=$prijs;
}
 
}