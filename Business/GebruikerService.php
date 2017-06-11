<?php
//business/BoekService.php
//**maakt gebruik van class loader Doctrine**//
namespace Business;
require_once 'Data/GebruikerDAO.php';
require_once 'Data/BroodjeDAO.php';
use Data\GebruikerDAO;
use Data\BroodjeDAO;

class GebruikerService {

 public function getGebruikersOverzicht() {
  $bDAO = new GebruikerDAO();
  $lijst = $bDAO->getAll();
  return $lijst;
 }
 public function voegNieuweGebruikerToe($email) { //functie nodig om boek toe te voegen
    $gDAO = new GebruikerDAO();
    $gDAO->create($email);
} 
public function veranderPaswoord($email) { //functie nodig om boek toe te voegen
    $gDAO = new GebruikerDAO();
    $gDAO->veranderpaswoord($email);
} 
public function verwijderGebruiker($id) {  //functie om boek te verwijderen
 $gDAO = new GebruikerDAO();
 $gDAO->delete($id);
}  
public function checkGebruiker($email,$paswoord){
    $gDAO = new GebruikerDAO();
    $gDAO->checklogin($email, $paswoord);
}
public function prijsBroodje($type_broodje,$beleg){ //$hesp,$kaas,$tomaat,$sla,$boter,$mayonaise){
    $bDAO = new BroodjeDAO();
    $totaalprijs=$bDAO->bepaalprijs($type_broodje,$beleg);  //$hesp,$kaas,$tomaat,$sla,$boter,$mayonaise);
    return $totaalprijs;
}
//public function haalBoekOp($id) {  //functie om boekgegevens aan te passen
// $boekDAO = new BoekDAO();
// $boek = $boekDAO->getById($id);
// return $boek;
//}
//
//public function updateBoek($id, $titel, $genreId) {//functie om boekgegevens aan te passen
// $genreDAO = new GenreDAO();
// $boekDAO = new BoekDAO();
// $genre = $genreDAO->getById($genreId);
// $boek = $boekDAO->getById($id);
// $boek->setTitel($titel);
// $boek->setGenre($genre);
// $boekDAO->update($boek);
//} 
}
