<?php
namespace Entities;
use Entities\BroodBeleg;

class BroodBeleg {

 private static $idMap = array();  //bevat alle reeds aangemaakte objecten van klasse Voornaam; static: slechts 1 lijst voor alle Voornaam-objecten   
 private $id;
 private $beleg;
 private $prijs;

 private function __construct($id, $beleg, $prijs) {
 $this->id = $id;
 $this->beleg = $beleg;
 $this->prijs = $prijs;
 
}

 public static function create($id, $beleg, $prijs){
     if (!isset(self::$idMap[$id])) {  //geindexeerd met id van Boek-object: snel controleren of Boek-object met bepaalde id werd aangemaakt zonder hele array te overlopen
   self::$idMap[$id] = new Cursist($id, $beleg, $prijs);  //indien er nog geen Boek-object met dit id bestaat, dan nieuw Boek-object aanmaken via constructor en aan lijst toevoegen
  } 
  return self::$idMap[$id];  //indien er wel Boek-object met dit id bestaat, dan wordt het bestaande object teruggegeven
 }
 
 public function getId() {
  return $this->id;
 }
 
 public function getBeleg() {
  return $this->beleg;
 }
 
 public function getPrijs(){
     return $this->prijs;
 }
 

 public function setBeleg($beleg) {
  $this->beleg = $beleg;
 }
 
 public function setPrijs($prijs){
     $this->prijs=$prijs;
}
 
}