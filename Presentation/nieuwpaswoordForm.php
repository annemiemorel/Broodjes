<?php
  session_start();
  ?>
<html>
<head><title>Broodjes - Nieuwe paswoord</title></head>
<link href="../styles/main.css" rel="stylesheet" type="text/css"> 
<body>
<h2>::: Nieuw paswoord aanvragen </h2>
<?php

if (isset($_GET["error"]) && $_GET["error"] == "emailbestaatniet") {
 ?>
 <p style="color: red">Er bestaat nog geen gebruiker met dit emailadres! Maak nieuwe gebruiker aan.</p>
 <?php
}

 if(isset($_GET["pasw"]) && $_GET["pasw"] == "nieuw"){
            ?>
        <font color="#ff0000">Je nieuwe paswoord is <?php print($_SESSION['paswoord']);?> </font>
            <?php }           ?>
        
<table  >
<form method="post" action="../voeggebruikertoe.php?action=nieuw">

    <tbody >
        <tr> <td>e-mail: </td><td><input type ="email" name="email" required></td></tr>
        <tr><td></td><td><input type="submit" value="Verzend" class="knop but1"></td></tr>
    </tbody>        

</form>
</table>    <br>
<a href="../hoofdmenu.php" class="kaderknop">Terug naar Hoofdmenu</a>
<a href="../voeggebruikertoe.php" class="kaderknop">Nieuwe gebruiker aanmaken</a>

<?php

if (isset($_GET['error'])) {
        if ($_GET['error'] == "geennummer") { ?>
        <font color="#ff0000">U hebt geen naam ingegeven!</font>
        <?php  }
       else if ($_GET['error'] == "nummerbestaatal") { ?>
        <font color="#ff0000">Deze gast bestaat reeds!</font>
        <?php  }
       }
     exit(0);

 ?>
</body>
</html>