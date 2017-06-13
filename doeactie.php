<?php
namespace Data;
require_once("Data/GebruikerDAO.php");
require_once 'Exceptions/GebruikerBestaatException.php';
require_once 'Exceptions/FoutPaswoordException.php';
require_once 'Exceptions/EmailBestaatNietException.php';
require_once 'Exceptions/DatumBestaatNietException.php';

//require_once("../includes/phpMailer/class.phpMailer.php");
//require_once("phpmailer/class.smtp.php");
//<!--class.phpmailer.php';-->
date_default_timezone_set('Etc/UTC');
require_once 'phpmailer/PHPMailerAutoload.php'; 
use Exceptions\GebruikerBestaatException;
use Exceptions\FoutPaswoordException;
use Exceptions\EmailBestaatNietException;
use Exceptions\DatumBestaatNietException;

use PHPMailer;
//define('GUSER', 'you@gmail.com'); // GMail username
//define('GPWD', 'password'); // GMail password

function smtpmailer($to, $from, $from_name, $subject, $body) { 
    	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 4;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'tls';  //'ssl of tls'; // secure transfer enabled REQUIRED for GMail
        $mail->SMTPKeepAlive=true;  //annemie toegevoegd
        $mail->Mailer = "smtp";
	$mail->Host ='smtp.gmail.com'; //'smtp.gmail.com';
	$mail->Port = 587;  //465 of 587; 
        $mail->isHTML(true); //annemie toegevoegd
	$mail->Username = 'annemie.morel@gmail.com'; //GUSER;  
	$mail->Password = 'Sl3utelbloem'; //GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
                echo $error;
		return $error; //false;
	} else {$error = 'Message sent!';
               echo $error;
		return $error; //true;
	}
}

session_start();

if (isset($_GET["action"]) && $_GET["action"] == "stuurmail"){
   if(smtpmailer('annemie.morel@gmail.com', 'annemie.morel@gmail.com', 'Annemie', 'test mail message', 'Hello World!')){
        $errorMessage= smtpmailer('annemie.morel@gmail.com', 'annemie.morel@gmail.com', 'Annemie', 'test mail message', 'Hello World!'); //"Message sent"; 
    }else{
        $errorMessage= "Mail error";
    }
    
//    ini_set("SMTP","smtp.gmail.com");
//     ini_set("smtp_port","587");
//    ini_set('sendmail_from', 'annemie.morel@gmail.com');
// 
//    $msg="Je bestelde broodjes liggen klaar. Je kan ze komen afhalen.";
//    $headers = "From: annemie.morel@gmail.com";
//    $success = mail("annemie.morel@gmail.com","Bestelde broodjes",$msg,$headers);
//    $errorMessage="geen probleem gevonden";
//    if(!$success){
//        $errorMessage= error_get_last()['message'];
//        //echo $errorMessage;
//    }
    header("location: Presentation/createuserForm.php?pasw=gemaakt&errorMessage=$errorMessage");
        exit(0);
    //header("location: hoofdmenu.php");
    //exit(0);
   
}

if (isset($_GET["action"]) && $_GET["action"] == "nieuwpasw"){
    header("location: Presentation/nieuwpaswoordForm.php");
    exit(0);
}
if (isset($_GET["action"]) && $_GET["action"] == "verzendbestelling"){
    try{
    $_SESSION["email"]=$_POST["email"];
    $_SESSION["paswoord"]=$_POST["paswoord"];
    $gDAO= new GebruikerDAO();
    $gDAO->plaatsbestelling($_SESSION["email"],$_SESSION["paswoord"]);
    header("location: Presentation/bestelForm.php?boodschap=verzonden");
    exit(0);
    }
    catch (EmailBestaatNietException $ex){
        header("location: Presentation/loginForm.php?error=emailbestaatniet");
        exit(0);
    }
    catch (FoutPaswoordException $ex){
        header("location: Presentation/loginForm.php?error=foutpaswoord");
        exit(0);
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "haalbestellingen"){
    try{
//    $_SESSION["email"]=$_POST["email"];
//    $_SESSION["paswoord"]=$_POST["paswoord"];
    $gDAO= new GebruikerDAO();
    $lijst=$gDAO->haalbestelling($_POST["datum"]);
    //echo print_r($lijst);
    $_SESSION['lijst']=$lijst;
    $_SESSION['datumbestelling']=$_POST["datum"];
    header("location: Presentation/overzichtForm.php?lijst=laatzien");
    exit(0);
    }
    catch (DatumBestaatNietException $ex){
        header("location: Presentation/overzichtForm.php?error=foutedatum");
        exit(0);
    }
}
if (isset($_GET["action"]) && $_GET["action"] == "login"){
    
        try {
        $gDAO= new GebruikerDAO();
        $lijst=array();
        $lijst=$gDAO->haalbestelling($_POST["datum"]);
        header("location: doeactie.php?action=verzendbestelling");
        exit(0);
    }catch (\Exceptions\DatumBestaatNietException $ex) {
        header("location: Presentation/overzichtForm.php?error=foutedatum");
        exit(0);
}}else {
 
 if (isset($_GET["error"])){
     
 $error = $_GET["error"];echo "erreur=".$error;
 }
}  
     
