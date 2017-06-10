<?php session_start(); 

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">

<title>Broodjes</title>
</head>
<link href="../styles/main.css" rel="stylesheet" type="text/css">
<body>
    <div id="wrapper">
     
    <h1>Broodjes</h1>
    <h2>Stel zelf je broodje samen</h2>
    <article id="main">
     <form method="post" action="../bestelbroodje.php?action=process" style="font-size:1.2em ">
         <p>Soort broodje:</p>
        <select style="font-size:1em " name="brood_type">
            <option value="1"> Klein grof</option>
            <option value="2"> Groot grof</option>
            <option value="3"> Klein wit </option>
            <option value="4"> Groot wit </option>
            <option value="5"> Ciabatta </option>
        </select>
         <br>
         <p>Kies beleg:</p>
        <input type="checkbox" name="hesp" value="1" /> hesp
        <br>
        <input type="checkbox" name="kaas" value="2" /> kaas
        <br>
        <input type="checkbox" name="tomaat" value="3" /> tomaat
        <br>
        <input type="checkbox" name="sla" value="4" /> sla
        <br>
        <input type="checkbox" name="boter" value="5" /> boter
        <br>
        <input type="checkbox" name="mayonaise" value="6" /> mayonaise
        <br><br>
        <input type="submit" style="font-size:1em" value="Broodje toevoegen" class="kaderknop">
     </form>
        <br><br>
 
     <a href="../hoofdmenu.php" class="kaderknop">Hoofdmenu </a> 
</article>
    <aside style="color:red" id="sidebar">
        
        <?php
    if (isset($_GET["boodschap"]) && $_GET["boodschap"] == "prijs"){
        //echo "Broodje : ".$_SESSION['bestelling']; ?><br> <?php
        //echo $_SESSION['boodschap']; ?><br> <?php
        //echo "aantal broodjes = " . ($_SESSION['aantalbroodjes']+1); ?><br> <?php
        //echo 'bestelling='.$_SESSION["bestellingcursist"][0][1];
        
       for($x=0;$x<$_SESSION["aantalbroodjes"];$x++){
                echo "Broodje ".($x+1)." : ";
                echo $_SESSION["bestellingcursist"][$x][0]." - ";
                echo $_SESSION["bestellingcursist"][$x][1];
                ?><br> <?php
                
            }
            
       // echo $_SESSION["bestellingcursist"]
           // session_unset();
    }
    if (isset($_GET["boodschap"]) && $_GET["boodschap"] == "verzonden"){
        echo "Je bestelling werd verzonden";
        session_unset();
        $_SESSION['aantalbroodjes']=0;
    }
    if (isset($_GET["boodschap"]) && $_GET["boodschap"] == "opnieuw"){
        echo "Begin opnieuw met bestellen";
        session_unset();
        $_SESSION['aantalbroodjes']=0;
        
    }?>            
                <br><br><br>
     <a href="bestelForm.php?boodschap=opnieuw" class="kaderknop">Opnieuw beginnen </a>   
        <br><br>
     <a href="loginForm.php" class="knop but1">Bestelling plaatsen </a>    
    </aside>
    </div>
</body>
</html>
