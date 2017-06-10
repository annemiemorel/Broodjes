<?php

require_once 'Business/GebruikerService.php';
require_once 'Exceptions/GebruikerBestaatException.php';
use Business\GebruikerService;
use Exceptions\GebruikerBestaatException;
//require_once('bootstrap.php');


if (isset($_GET["action"]) && $_GET["action"] == "process") {
    try {
       
        $gSvc = new GebruikerService();
        $gSvc->voegNieuweGebruikerToe($_POST['email']);
        header("location: hoofdmenu.php");  //doeactie.php?action=stuurmail");
        exit(0);
    } 
    catch (GebruikerBestaatException $ex) {
        header("location: Presentation/createuserForm.php?error=gebruikerbestaat");
        exit(0);
    }
} 
else {
  if (isset($_GET["error"])){
      $error = $_GET["error"];echo "erreur=".$error;
  }
}
 
if ($_GET["action"] == "init"){
    header("location: createuserForm.php?");
        exit(0);
}
