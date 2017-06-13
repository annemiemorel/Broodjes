<?php 

session_start();
?>

<!DOCTYPE HTML> 
<html> 
    <head> 
        <meta charset=utf-8> 
        <title>Broodjes</title> 
       <link href="../styles/main.css" rel="stylesheet" type="text/css"> 
    </head> 
    
    <body> 
        <h1>Bestellingen</h1>
        <?php if (isset($_GET["error"]) && $_GET["error"] == "foutedatum") {
        ?>
        <p style="color:red">Er werden geen broodjes besteld of formaat ingegeven datum is verkeerd: formaat = jjjj-mm-dd </p>
        <?php } ?>
    
         
         <form method="post" action="../doeactie.php?action=haalbestellingen">
             <tr><td> Geef datum:</td><td> <input type="date" name="datum" /> </td></tr>
             <tr><td></td><td><input type="submit" style="font-size:1em" value="Selecteer" class="kaderknop"></td></tr>
        </form>
        <br>
        <table> 
        <?php 
        //print_r($lijst); // $naam[titel];
        if (isset($_GET["lijst"]) && $_GET["lijst"]=="laatzien"){
           // echo "lijst";
            $lijst=$_SESSION['lijst'];
            //echo print_r($lijst);
            //echo "Aantal broodjes = ".count($lijst);
            $aantalbroodjes=count($lijst);
            $totaalinkomsten=0;
        for($x=0;$x<$aantalbroodjes;$x++) { 
           
            ?>
                 
            <tbody class="overzicht">
                <tr style="font-style:italic;"><td><?php print($lijst[$x]['bestelling']); ?> </td>
                        <td><?php print($lijst[$x]['prijs']); ?>  euro</td></tr>
            
                <?php
                $totaalinkomsten+=$lijst[$x]['prijs'];
        }?>
                <tr><td>Inkomsten van <?php print($_SESSION['datumbestelling']); ?></td><td> <?php print($totaalinkomsten); ?> euro.</td></tr>
            
            </tbody>
        </table> 
        
        <?php } ?>
        <br><br>
       <a href="../hoofdmenu.php" class="kaderknop">Terug naar Hoofdmenu</a>
      </body> 
</html>


