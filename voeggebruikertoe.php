<?php

require_once 'Business/GebruikerService.php';
require_once 'Exceptions/GebruikerBestaatException.php';
require_once 'Exceptions/EmailBestaatNietException.php';
require_once 'Exceptions/FoutEmailAdresException.php';
use Business\GebruikerService;
use Exceptions\GebruikerBestaatException;
use Exceptions\EmailBestaatNietException;
use Exceptions\FoutEmailAdresException;
//require_once('bootstrap.php');


if (isset($_GET["action"]) && $_GET["action"] == "process") {
    try {
       
        $gSvc = new GebruikerService();
        $gSvc->voegNieuweGebruikerToe($_POST['email']);
        header("location: doeactie.php?action=stuurmail"); //hoofdmenu.php");  //
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
if (isset($_GET["action"]) && $_GET["action"] == "nieuw") {
    try {
       
        $gSvc = new GebruikerService();
        $gSvc->veranderPaswoord($_POST['email']);
        header("location: Presentation/nieuwpaswoordForm.php?pasw=nieuw"); //hoofdmenu.php");  //
        exit(0);
    } 
    catch (FoutEmailAdresException $ex) {
        header("location: Presentation/nieuwpaswoordForm.php?error=emailbestaatniet");
        exit(0);
    }
    
}


if ($_GET["action"] == "init"){
    header("location: createuserForm.php?");
        exit(0);
}
