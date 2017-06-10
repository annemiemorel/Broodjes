<?php
namespace Data;
require_once("Data/GebruikerDAO.php");
require_once 'Exceptions/GebruikerBestaatException.php';
require_once 'Exceptions/FoutPaswoordException.php';
require_once 'phpmailer/class.phpmailer.php';
use Exceptions\GebruikerBestaatException;
use Exceptions\FoutPaswoordException;
function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {$error = 'Message sent!';
		return true;
	}
}
session_start();

if (isset($_GET["action"]) && $_GET["action"] == "stuurmail"){
//    ini_set("SMTP","ssl://smtp.gmail.com");
//    ini_set("smtp_port","465");
//    ini_set('sendmail_from', 'annemie.morel@gmail.com');
//    $msg="Je bestelde broodjes liggen klaar. Je kan ze komen afhalen.";
//    $headers = "From: Broodjeszaak <broodjeszaak@gmail.com>";
//    mail("annemie.morel@gmail.com","Bestelde broodjes",$msg,$headers);
    
}
if (isset($_GET["action"]) && $_GET["action"] == "verzendbestelling"){
    $_SESSION["email"]=$_POST["email"];
    $_SESSION["paswoord"]=$_POST["paswoord"];
    $gDAO= new GebruikerDAO();
    $gDAO->plaatsbestelling($_SESSION["email"],$_SESSION["paswoord"]);
    header("location: Presentation/bestelForm.php?boodschap=verzonden");
    exit(0);
}
if (isset($_GET["action"]) && $_GET["action"] == "login"){
    
        try {
    // echo $_POST["voornaam"]. "," . $_POST["paswoord"];
    $_SESSION["email"]=$_POST["email"];
    $_SESSION["paswoord"]=$_POST["paswoord"];
    echo $_SESSION["email"]. "," . $_SESSION["paswoord"];
        $gDAO= new GebruikerDAO();
        $gDAO->checklogin($_POST["email"],$_POST["paswoord"]);
        
//            $_SESSION['setbutton']=0;
            $_SESSION['teller']=1;
          //header("location: Presentation/bestelForm.php?boodschap=verzonden");
            header("location: doeactie.php?action=verzendbestelling");
            exit(0);
    }catch (FoutPaswoordException $ex) {
        header("location: Presentation/loginForm.php?error=foutpaswoord");
        exit(0);
}}else {
 
 if (isset($_GET["error"])){
     
 $error = $_GET["error"];echo "erreur=".$error;
 }
}  
     
            
//        }
//        else{
//        header("location: Presentation/loginForm.php");
//        exit(0);}
    

//if (isset($_GET["action"]) && $_GET["action"] == "buttonset"){
//    $gDAO= new GastDAO();
//    $gDAO->setbutton();
////    $_SESSION['setbutton']=1;
//    header("location: Presentation/activiteiten.php");
//    exit(0);
//   
//}
//if (isset($_GET["action"]) && $_GET["action"] == "veranderbutton"){
//    echo("veranderbutton");
//    $gDAO= new GastDAO();
//    $gDAO->veranderbutton($_GET["keuze"],$_GET["foto"]);
////    header("location: Presentation/activiteiten.php");
////    exit(0);
//}