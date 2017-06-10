<?php session_start();
//       $_SESSION['teller']=1;
//       $_SESSION['figletter']='A';
//       $_SESSION['recordnr']=1;
//       $_SESSION['doetekst']='Wat doe jij graag in je vrije tijd?';
//       $_SESSION['uitleg']=" Als je de activiteit graag doet, kleur ze dan groen. <br> Als je het niet graag doet, kleur ze dan rood.<br> Doe je het graag in de groep of alleen? <br> Kan je dat dan doen op je kamer?<br>Weet je een rustig plaatsje?<br>";
    ?>
<html>
    <head><title>Login</title>
      <meta charset="UTF-8">
    </head>
    
<link href="../styles/main.css" rel="stylesheet" type="text/css"> 
        <h2>::: Login</h2> 
        <p> Plaats bestelling: geef e-mail en paswoord</p>
       
 <?php
if (isset($_GET["error"]) && $_GET["error"] == "foutpaswoord") {
 ?>
 <p style="color: red">Combinatie e-mail en paswoord is fout!</p>
 <?php
}
?> <?php
if (isset($_GET["error"]) && $_GET["error"] == "foutenaam") {
 ?>
 <p style="color: red">Naam is fout!</p>
 <?php
}
?> 
<body>
        <form method="post" action="../doeactie.php?action=verzendbestelling">
            <table >
                <tbody class="login">
                <tr><td>Geef e-mail:</td><td> <input type ="text" name="email"></td></tr>
                <tr><td>Geef paswoord: </td><td><input type="password" name="paswoord" ></td></tr>
                </tbody>
            </table><br>
            <input type="submit" value="Bestel" class="knop but1">
        </form>
      
       </body>
    <a href="../hoofdmenu.php" class="kaderknop">Terug naar Hoofdmenu</a>
</html>