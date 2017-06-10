
<html>
<head><title>Broodjes - Nieuwe gebruiker</title></head>
<link href="../styles/main.css" rel="stylesheet" type="text/css"> 
<body>
<h2>::: Nieuwe gebruiker aanmaken </h2>
<?php

if (isset($_GET["error"]) && $_GET["error"] == "gebruikerbestaat") {
 ?>
 <p style="color: red">Gebruiker met dit emailadres bestaat al!</p>
 <?php
}
?>
        <form method="post" action="../voeggebruikertoe.php?action=process">
            <table  width="150" border="0">
            <tbody class="login">
                <tr> <td>e-mail: </td><td><input type ="email" name="email" required></td></tr><p>
            </tbody>
            </table>    <br>
            
            <input type="submit" value="Maak" class="knop but1">
        </form>
<tr>
    <td><a href="../hoofdmenu.php" class="kaderknop">Terug naar Hoofdmenu</a></td>
    
</tr>
<?php
if (isset($_GET['error'])) {
        if ($_GET['error'] == "geennummer") { ?>
        <font color="#ff0000">U hebt geen naam ingegeven!</font>
        <?php  }
       else if ($_GET['error'] == "nummerbestaatal") { ?>
        <font color="#ff0000">Deze gast bestaat reeds!</font>
        <?php  }
       }
     exit(0);?>
</body>
</html>