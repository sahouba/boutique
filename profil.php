<?php
require_once('inc/init.inc.php');

if(!internauteEstConnecte()){
  header('location:connexion.php');
  exit();
}

if(internauteEstConnecteEtEstAdmin()){
  $content .= "<h1> Vous êtes Administrateur du Site </h1>";
}
$content .='<nav><ul>';
if(internauteEstConnecte())
{
  $content .='<li> <a href="';
  URL;
  $content .='membres.php?action=modification&id_membre='.$_SESSION['membre']['id_membre'].'"> Mettre à jour mes Informations </a> </li>';
}
$content .='</nav></ul>';

require_once('inc/haut.inc.php'); ?>
<?= $content; ?>                                          <?php /*echo $content;*/ ?>
  <h2>Bonjour <?=$_SESSION['membre']['pseudo'] ?> vous êtes bien connecté ! </h2><br>
    <fieldset>
  <legend><h2> Voici Vos Information : <br></h2></legend>
    <h2 class="hh2">Votre Nom : <?= $_SESSION['membre']['nom'] ?></h2>
    <h2 class="hh2">Votre Prénom : <?= $_SESSION['membre']['prenom'] ?></h2>
    <h2 class="hh2">Votre Email : <?= $_SESSION['membre']['email'] ?></h2>
  </fieldset>
<?php require_once('inc/bas.inc.php'); ?>
