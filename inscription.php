<?php
require_once('inc/init.inc.php');
require_once('inc/haut.inc.php');
if ($_POST) {
   //echo $_POST['pseudo'];

  // debug ($_Post);
  $erreur='';
  if(strlen($_POST['pseudo'])<3 ||
  strlen ($_POST['pseudo'])>20)
  {
    $erreur .='<div class="alert alert-danger" role="alert">
    Erreur sur la taille du pseudo </div>';
  }
  if (!preg_match('#^[a-zA-z0-9.-_]+$#',$_POST['pseudo'])) {
    $erreur .='<div class="alert alert-danger" role="alert">
    Erreur sur le format du  pseudo </div>';
  }
  $r=$pdo->prepare("SELECT * FROM membre WHERE pseudo =:pseudo");
  $r->execute(array(':pseudo'=>$_POST['pseudo']));
  if ($r->rowCount()>=1) {
    // rowCount Retourne le nombre de lignes affectées par le dernier appel à la fonction
    $erreur .='<div class="alert alert-danger" role="alert">
    '.$_POST['pseudo'].' existe déja !  </div>';
  }
  foreach ($_POST as $indice=>$valeur)
  {
    $_POST[$indice]=addslashes($valeur);
  }
  $_POST['mdp']=password_hash($_POST['mdp'],PASSWORD_DEFAULT);
  if (empty($erreur)) {
     $r=$pdo->prepare('INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse)
         VALUES(:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse)');
         $r->execute(array(
           ':pseudo'   =>$_POST['pseudo'],
           ':mdp'     =>$_POST['mdp'],
           ':nom'     =>$_POST['nom'],
           ':prenom'     =>$_POST['prenom'],
           ':email'    =>$_POST['email'],
           ':civilite' =>$_POST['civilite'],
           ':ville'  =>$_POST['ville'],
           ':code_postal' =>$_POST['code_postal'],
           ':adresse'   =>$_POST['adresse']
         ));
         $content.='<div class="alert alert-success" role="alert"> Inscription Validée !  </div>';

  }
  $content .=$erreur;
}
echo $content; /* <? $content; ?>*/
/* Formulaire html
 - pseudo -input type ="text"
 - mdp -input type ="password"
 - nom -input type ="text"
 - prénom -input type ="text"
 - email -input type ="email"
 - civilité -input type ="radio"
 - ville -input type ="text"
 - code postale -input type ="text"
 - adresse  textarea
 -bouton submit -input type="submit"
 */
 ?>



 <h1>Inscription</h1>

<form action="" method="post">
  <p><i> <h3> Complétez le formulaire. Les champs marqué par  </i><em>*</em> sont <em>obligatoires !</h3></em></p>

  <fieldset>
    <legend> <h2>Connexion </h2></legend>
      <label for="pseudo"><h3>Pseudo <em>*</em></h3></label>
      <input name="pseudo" type="text" id="pseudo" placeholder="Pseudo" maxlenght="20" pattern="[a-z0-9._%+-]{3,20}$"><br>
      <label for="mdp"><h3>Password</h3></label>
      <input name="mdp" type="password" id="password" placeholder="mot de passe"><br>
  </fieldset>
  <fieldset>
    <legend><h2>Information personnelles</h2></legend>
    <label for="nom"><h3>Nom<em>*</em></h3></label>
    <input name="nom" type="text"id="nom" placeholder="Votre Nom"><br>
    <label for="prenom"><h3>prénom <em>*</em></h3></label>
    <input name="prenom" type="text"id="prenom" placeholder="Votre Prénom" ><br>
    <label for="email"><h3>Email </h3></label>
    <input name="email" id="email" type="email" placeholder="nom@exemple.com"
        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"  ><br>


            <legend><h3>Civilité</legend>
           <div>
              <input name="civilite" type="radio" id="masculin" value="masculin" name="masculin" checked />
              <label for="m"><h3>Masculin</h3></label>
          </div>
          <div>

              <input name="civilite" type="radio" id="feminin" value="feminin" name="feminin" />
              <label for="feminin"><h3>Féminin</h3></label>
          </div>


    <label for="ville"><h3>Ville <em>*</em></h3></label>
    <input name="ville" type="text" id="ville" placeholder="Ville"><br>
    <label for="code_postal"><h3>Code Postal <em>*</em></h3></label>
    <input name="code_postal" type="text" id="code_postal" placeholder="Code Postal" a><br>
      <label for="pseudo"><h3>adresse<em>*</em></h3> </label>
      <textarea name="adresse" id="adresse"></textarea>
  </fieldset>

  <input class="btn btn-primary btn-lg" type="submit" name="submit" value="Inscription">

</form>
 <?php
require_once('inc/bas.inc.php');
 ?>
