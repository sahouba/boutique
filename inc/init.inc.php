<?php
 //connexion à la BDD (PDO)

 $pdo=new PDO('mysql:host=localhost;dbname=boutique','root','',array(
   PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING,PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
 // ouverture de session
 session_start();
 //définition de constantes
 define("RACINE_SITE",$_SERVER['DOCUMENT_ROOT'].'/PHP/boutique/');
 define("URL","http://localhost/PHP/boutique/");
 //Déclaration de variable
 $content='';
// Inclusion des fonctions
 require_once('fonction.php');
 ?>
