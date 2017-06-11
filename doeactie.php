<?php
namespace Data;
require_once("Data/GebruikerDAO.php");
require_once 'Exceptions/GebruikerBestaatException.php';
require_once 'Exceptions/FoutPaswoordException.php';
require_once 'Exceptions/EmailBestaatNietException.php';
require_once 'phpmailer/PHPMailerAutoload.php'; 
//require_once("../includes/phpMailer/class.phpMailer.php");
//require_once("phpmailer/class.smtp.php");
//<!--class.phpmailer.php';-->
use Exceptions\GebruikerBestaatException;
use Exceptions\FoutPaswoordException;
use Exceptions\EmailBestaatNietException;

use PHPMailer;
define('GUSER', 'you@gmail.com'); // GMail username
define('GPWD', 'password'); // GMail password
function smtpmailer($to, $from, $from_name, $subject, $body) { 
    	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl';  //'ssl of tls'; // secure transfer enabled REQUIRED for GMail
        //$mail->SMTPKeepAlive=true;  //annemie toegevoegd
        //$mail->Mailer = "smtp";
	$mail->Host =gethostbyname('smtp.scarlet.be') ; //'smtp.gmail.com';
	$mail->Port = 465;  //465 of 587; 
       // $mail->isHTML(true); //annemie toegevoegd
	$mail->Username = 'haenewim'; //GUSER;  
	$mail->Password = 'tonem8n'; //GPWD;           
	$mail->SetFrom("annemie.morel@gmail.com"); //$from, $from_name);
	$mail->Subject = "Test"; //$subject;
	$mail->Body = "Hello"; //$body;
	$mail->AddAddress($to);
//	if(!$mail->Send()) {
//		$error = 'Mail error: '.$mail->ErrorInfo; 
//                echo $error;
//		return false;
//	} else {$error = 'Message sent!';
//               echo $error;
//		return true;
//	}
}

session_start();

if (isset($_GET["action"]) && $_GET["action"] == "stuurmail"){
//    if(smtpmailer('annemie.morel@gmail.com', 'annemie.morel@gmail.com', 'Annemie', 'test mail message', 'Hello World!')){
//        echo "Message sent";
//    }else{
//        echo "Mail error";
//    }
    ini_set("SMTP","ssl://smtp.scarlet.be");
    ini_set("smtp_port","465");
    ini_set('sendmail_from', 'annemie.morel@gmail.com');
    $msg="Je bestelde broodjes liggen klaar. Je kan ze komen afhalen.";
    $headers = "From: Broodjeszaak <broodjeszaak@gmail.com>";
    mail("annemie.morel@gmail.com","Bestelde broodjes",$msg,$headers);
    
    //header("location: hoofdmenu.php");
    //exit(0);
    header("location: Presentation/createuserForm.php?pasw=gemaakt");
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