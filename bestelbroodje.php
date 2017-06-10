<?php

require_once 'Business/GebruikerService.php';
require_once 'Exceptions/FoutBroodjeException.php';
require_once 'phpmailer/class.phpmailer.php';
use Business\GebruikerService;
use Exceptions\FoutBroodjeException;
//use PHPMailer;
//require_once('bootstrap.php');
session_start();

if (isset($_GET["action"]) && $_GET["action"] == "process") {
    try {
        
        $gSvc = new GebruikerService();
        $soortbroodje=array("klein grof","groot grof","klein wit","groot wit","ciabatta");
        $_SESSION['bestelbeleg']='';
        //$_SESSION['bestellingcursist']=array();
        if(!isset($_POST['hesp'])){$_POST['hesp']='';}else{$_SESSION['bestelbeleg'].="hesp, ";}
        if(!isset($_POST['kaas'])){$_POST['kaas']='';}else{$_SESSION['bestelbeleg'].="kaas, ";}
        if(!isset($_POST['tomaat'])){$_POST['tomaat']='';}else{$_SESSION['bestelbeleg'].="tomaat, ";}
        if(!isset($_POST['sla'])){$_POST['sla']='';}else{$_SESSION['bestelbeleg'].="sla, ";}
        if(!isset($_POST['boter'])){$_POST['boter']='';}else{$_SESSION['bestelbeleg'].="boter, ";}
        if(!isset($_POST['mayonaise'])){$_POST['mayonaise']='';}else{$_SESSION['bestelbeleg'].="mayonaise, ";}
        $beleg= array($_POST['hesp'],$_POST['kaas'],$_POST['tomaat'],$_POST['sla'],$_POST['boter'],$_POST['mayonaise']);
        $totaalprijs=$gSvc->prijsBroodje($_POST['brood_type'],$beleg); //$_POST['hesp'],$_POST['kaas'],$_POST['tomaat'],$_POST['sla'],$_POST['boter'],$_POST['mayonaise']);
        $_SESSION['totaalprijs']=$totaalprijs;
        $_SESSION['bestelling']=$soortbroodje[$_POST['brood_type']-1] . " met " .$_SESSION['bestelbeleg'];
        $_SESSION['boodschap']= "Totaalprijs van het broodje is " . $totaalprijs . " euro";
        
         $_SESSION["bestellingcursist"][$_SESSION['aantalbroodjes']][0]=$_SESSION['bestelling'];
         $_SESSION["bestellingcursist"][$_SESSION['aantalbroodjes']][1]=$_SESSION['totaalprijs'];
        //echo $_SESSION['bestellingcursist'];
        $_SESSION['aantalbroodjes']+=1;
        header("location: Presentation/bestelForm.php?boodschap=prijs");  //doeactie.php?action=stuurmail");
        exit(0);
    } 
    catch (FoutBroodjeException $ex) {
        header("location: Presentation/bestelForm.php?error=foutbroodje");
        exit(0);
    }
} 
else {
  if (isset($_GET["error"])){
      $error = $_GET["error"];echo "erreur=".$error;
  }
}