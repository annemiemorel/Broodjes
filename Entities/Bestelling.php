<?php
namespace Entities;
use Entities\Bestelling;

class Bestelling {

 private static $idMap = array();  //bevat alle reeds aangemaakte objecten van klasse Voornaam; static: slechts 1 lijst voor alle Voornaam-objecten   
 private $id;
 private $datum;
 private $cursist;
 private $bestelling;
 private $prijs;

 private function __construct($id, $datum, $prijs) {
 $this->id = $id;
 $this->datum = $datum;
 $this->cursist= $cursist;
 $this->bestelling=$bestelling;
 $this->prijs = $prijs;
 
}

 public static function create($id, $datum, $prijs){
     if (!isset(self::$idMap[$id])) {  //geindexeerd met id van Boek-object: snel controleren of Boek-object met bepaalde id werd aangemaakt zonder hele array te overlopen
   self::$idMap[$id] = new Cursist($id, $datum, $prijs);  //indien er nog geen Boek-object met dit id bestaat, dan nieuw Boek-object aanmaken via constructor en aan lijst toevoegen
  } 
  return self::$idMap[$id];  //indien er wel Boek-object met dit id bestaat, dan wordt het bestaande object teruggegeven
 }
 
 public function getId() {
  return $this->id;
 }
 
 public function getBeleg() {
  return $this->datum;
 }
 
 public function getCursist() {
  return $this->cursist;
 }
 
 public function getBestelling() {
  return $this->bestelling;
 }
 
 public function getPrijs(){
     return $this->prijs;
 }
 

 public function setBeleg($datum) {
  $this->datum = $datum;
 }
 
 public function setCursist($cursist){
     $this->cursist=$cursist;
}
public function setBestelling($bestelling){
     $this->bestelling=$bestelling;
}
public function setPrijs($prijs){
     $this->prijs=$prijs;
}
 
}