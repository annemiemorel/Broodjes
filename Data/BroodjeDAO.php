<?php
namespace Data;
require_once 'DBConfig.php';
require_once 'Entities/Cursist.php';
//require_once 'Entities/Login.php';
require_once 'Exceptions/GebruikerBestaatException.php';
use Data\DBConfig;
//use Entities\Login;
use Entities\Cursist;
use Exceptions\GebruikerBestaatException;
use PDO;
//session_start();


class BroodjeDAO {
    
 public function getAll() {  
      $sql = "select * from cursisten";
    $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
     
    $resultSet = $dbh->query($sql);
    $lijst = array();
    foreach ($resultSet as $rij) {
     $cursist = Cursist::create($rij["email"], $rij["paswoord"]);
     array_push($lijst, $cursist);
    }
    $dbh = null;
    $_SESSION["velden"]=sizeof($lijst); //aantal gebruikers
    return $lijst;
}

    public function bepaalprijs($type_broodje,$beleg){  //$hesp,$kaas,$tomaat,$sla,$boter,$mayonaise) {  //nieuwe functie om boek te kunnen toevoegen
        //**foutafhandeling**//
        
//        $bestaandeGebruiker = $this->getByEmail($email); //null indien nog niet bestaat, anders ?
//        if (!is_null($bestaandeGebruiker)){
//            throw new GebruikerBestaatException();
//        }
        //**foutafhandeling**//
        $sql = "select prijs from brood_type where id_type= :brood_type";
        //echo $sql;
        //echo "type broodje = ".$type_broodje;
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql); 
        
        $stmt->execute(array(':brood_type' => $type_broodje));
        $dbh = null; 
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
     $prijsbroodje = $rij["prijs"];
     //echo "prijs broodje=".$prijsbroodje;
     //$broodbeleg= array($hesp,$kaas,$tomaat,$sla,$boter,$mayonaise);
     $arrlength= count($beleg);  //$broodbeleg);
     $prijsbeleg=0;
     for ($x = 0; $x < $arrlength; $x++){
         if ($beleg[$x]<>''){
            $prijsbeleg+=$this->bepaalprijsbeleg($beleg[$x]);
         }
     }
     
     $dbh = null;
     $totaalprijs=$prijsbroodje+$prijsbeleg;
     return $totaalprijs;
   } 
    
   public function bepaalprijsbeleg($beleg){
       $sql = "select prijs from brood_beleg where id_beleg= :brood_beleg";
       $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql); 
        
        $stmt->execute(array(':brood_beleg' => $beleg));
        $dbh = null; 
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
     $prijsbeleg = $rij["prijs"];
     $dbh = null;
     return $prijsbeleg;
   }
   public function delete($id) {   //nieuwe functie om boek te verwijderen
    $sql = "delete from gasten where id = :id" ; 
    $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
//    $dbh = new PDO("mysql:host=localhost;dbname=cursusphp;charset=utf8;port=3307","cursusgebruiker","cursuspwd");//;DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
    $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':id' => $id)); 
//    $dbh = null;
    $sql = "delete from login where id = :id" ; 
    $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
//    $dbh = new PDO("mysql:host=localhost;dbname=cursusphp;charset=utf8;port=3307","cursusgebruiker","cursuspwd");//;DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
    $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':id' => $id)); 
    $dbh = null;
   }  
   
   public function checklogin($voornaam,$paswoord){ //functie die controleert of paswoord past bij voornaam gast
       
        $sql="SELECT gasten.id FROM gasten, login WHERE gasten.id=login.id and voornaam= :voornaam and paswoord= :paswoord";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
        $stmt = $dbh->prepare($sql);
       $stmt->execute(array(':voornaam' => $voornaam, ':paswoord'=> $paswoord));
       $rij = $stmt->fetch(PDO::FETCH_ASSOC);

       if (!$rij) {  //niets gevonden
        return false;
       } else {
//        $genre = Genre::create($rij["genre_id"], $rij["genre"]);
//        $boek = Boek::create($rij["boek_id"], $rij["titel"], $genre);
       
        $_SESSION["gast"]=$rij["id"];
        //echo $_SESSION["gast"]; 
        $dbh = null;
        return true; //wel boek gevonden met titel $titel
       }
   }
   public function createBericht($auteur, $boodschap) { 
        //echo "createBericht";
        $sql = "insert into bestellingen (datum, cursist, bestelling, prijs) values (:datum, :cursist, :bestelling, :prijs)"; 
         $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt= $dbh->prepare($sql); 
        $datum = date("Y-m-d H:i:s");
        $stmt->execute(array(':datum' => $datum, ':cursist' =>$cursist, ':bestelling' => $bestelling, ':prijs' =>$prijs)); 
        //$laatsteId = $dbh->lastInsertId(); //ID van laatste record bekomen, indien er autonummering gebruikt wordt in de tabel
        //print($laatsteId);
        $dbh = null; 
        
    } 
    
    public function getByEmail($email){  //functie om na te gaan of er reeds een boek met deze titel bestaat (foutafhandeling)
        $sql = "select * from cursisten where email = :email" ;
     $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
     $stmt = $dbh->prepare($sql);
       $stmt->execute(array(':email' => $email));
       $rij = $stmt->fetch(PDO::FETCH_ASSOC);

       if (!$rij) {  //niets gevonden
        return null;
       } else {
        $cursist = "bestaat"; //Cursist::create($rij["id"], $rij["email"], $paswoord);
        $dbh = null;
        
        return $cursist; //wel boek gevonden met titel $titel
       }

    }  
//   public function veranderbutton($keuze,$nr){  //functie die wijzigingen bij drukken op knop doorgeeft aan database
////       $keuze=($_GET['keuze']);
////    $nr=($_GET['foto']);
//    $foto=$_SESSION['figletter'].$nr;
//     $recnr=$_SESSION['recordnr'];
//    //echo "recnr=".$recnr;
////     $connectie = mysqli_connect("localhost", "root", "", "rozemarijn");
//     $sql="SELECT `".$foto."` FROM `onderwerp".$recnr."-".$keuze."` inner join gasten on gasten.id=`onderwerp".$recnr."-".$keuze."`.user_id WHERE voornaam='". $_SESSION['voornaam']."'";
////echo $query;   
//     $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
//        $stmt = $dbh->prepare($sql);
//        $stmt->execute();
//       $rij = $stmt->fetch(PDO::FETCH_ASSOC);
//         if ($rij[$foto] == 1){
//            $sql="UPDATE `onderwerp".$recnr."-".$keuze."` inner join gasten on gasten.id=`onderwerp".$recnr."-".$keuze."`.user_id SET ".$foto." = 0 where voornaam='". $_SESSION['voornaam']."'";
//          $stmt = $dbh->prepare($sql); $stmt->execute();
//            echo $sql;    
//            }else{
//            $sql="UPDATE `onderwerp".$recnr."-".$keuze."` inner join gasten on gasten.id=`onderwerp".$recnr."-".$keuze."`.user_id SET ".$foto." = 1 where voornaam='". $_SESSION['voornaam']."'";
//           $stmt = $dbh->prepare($sql); $stmt->execute();
//           echo $query;
//           $dbh=null;
//   }}
//   
//   public function setbutton(){
//       $gastId=$_SESSION['gast'];
//        //echo "gastid = ".$gastId; 
//        $teller=$_SESSION['teller'];
//         $letter=$_SESSION['figletter'];
//         $recnr=$_SESSION['recordnr'];
//       for($gast=1;$gast<=2;$gast++){
//            $sql="SELECT * FROM `onderwerp".$recnr."-".$gast."` WHERE `user_id` = " . $gastId ;
//            echo $sql;
//           $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
//            $stmt = $dbh->prepare($sql); $stmt->execute();
//             $rij = $stmt->fetch(PDO::FETCH_ASSOC);
//                if($gast==1){
////                    $_SESSION['data1']=$rij;  //geeft alle onderwerpx-y info voor gekozen user
//                    if((($_SESSION['teller']-1)*3+1)<=($_SESSION['velden'])){$_SESSION['Button1']=$rij[$_SESSION['figletter'].(($teller-1)*3+1)];}else{header("Location: activiteiten2.php");exit(0);}
//                    if((($_SESSION['teller']-1)*3+2)<=($_SESSION['velden'])){$_SESSION['Button3']=$rij[$_SESSION['figletter'].(($teller-1)*3+2)];}
//                    if((($_SESSION['teller']-1)*3+3)<=($_SESSION['velden'])){$_SESSION['Button5']=$rij[$_SESSION['figletter'].(($teller-1)*3+3)];}
//                   
//                }
//                else if($gast==2){
////                    $_SESSION['data2']=$rij;   //geeft alle onderwerp1-2 info voor gekozen user
//                    if((($_SESSION['teller']-1)*3+1)<=($_SESSION['velden'])){$_SESSION['Button2']=$rij[$_SESSION['figletter'].(($teller-1)*3+1)];}
//                    if((($_SESSION['teller']-1)*3+2)<=($_SESSION['velden'])){$_SESSION['Button4']=$rij[$_SESSION['figletter'].(($teller-1)*3+2)];}
//                    if((($_SESSION['teller']-1)*3+3)<=($_SESSION['velden'])){$_SESSION['Button6']=$rij[$_SESSION['figletter'].(($teller-1)*3+3)];}
//                } 
//            }  $dbh=null;
//         }
//   
 //    public function getById($id) {  //functie die 1 entiteit gaat ophalen
//     $sql = "select mvc_boeken.id as boek_id, titel, genre_id, genre from mvc_boeken, mvc_genres where genre_id = mvc_genres.id and mvc_boeken.id = :id" ;
//     $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
////    $dbh = new PDO("mysql:host=localhost;dbname=cursusphp;charset=utf8;port=3307","cursusgebruiker","cursuspwd");//;DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
//     $stmt = $dbh->prepare($sql);
//       $stmt->execute(array(':id' => $id));
//       $rij = $stmt->fetch(PDO::FETCH_ASSOC);
//
//     $genre = Genre::create($rij["genre_id"],  $rij["genre"]);
//     $boek = Boek::create($rij["boek_id"], $rij["titel"], $genre);
//     $dbh = null;
//     return $boek;
//    } 
   
//   public function update($boek) {  //nieuwe functie om boekgegevens aan te passen
//    //***foutafhandeling***//
//     $bestaandBoek = $this->getByTitel($boek->getTitel());
//    if (!is_null($bestaandBoek) && ($bestaandBoek->getId() != $boek->getId() )) {
//     throw new TitelBestaatException();
//    }   
//    //**einde foutafhandeling***//
//    $sql = "update mvc_boeken set titel = :titel, genre_id = :genreId  
//    where id = :id";
//    $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
////     $dbh = new PDO("mysql:host=localhost;dbname=cursusphp;charset=utf8;port=3307","cursusgebruiker","cursuspwd");//;DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD); 
//      $stmt = $dbh->prepare($sql); 
//      $stmt->execute(array(':titel' => $boek->getTitel(), 
//     ':genreId' => $boek->getGenre()->getId(), ':id' => $boek->getId()));
//    $dbh = null;
//   }  
}
