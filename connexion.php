<?php
require_once('inc/init.inc.php');

  if(isset($_GET['action']) && $_GET['action']=='deconnexion')
  {
        unset($_SESSION['membre']);
  }
  if(internauteEstConnecte()) {
       header('location:profil.php');
       exit();
  }
  if($_POST) {
      $resultat= $pdo->prepare("SELECT * FROM membre WHERE pseudo =:pseudo");
         $resultat->execute(array(':pseudo'=> $_POST['pseudo']));
       if($resultat->rowCount() >= 1){
         $membre = $resultat->fetch(PDO::FETCH_ASSOC);
         if(password_verify($_POST['mdp'],$membre['mdp']))
         {
               $_SESSION['membre']['id_membre']   = $membre['id_membre'];
               $_SESSION['membre']['pseudo']      = $membre['pseudo'];
               $_SESSION['membre']['nom']         = $membre['nom'];
               $_SESSION['membre']['prenom']      = $membre['prenom'];
               $_SESSION['membre']['email']       = $membre['email'];
               $_SESSION['membre']['civilite']    = $membre['civilite'];
               $_SESSION['membre']['email']       = $membre['email'];
               $_SESSION['membre']['code_postal'] = $membre['code_postal'];
               $_SESSION['membre']['adresse']     = $membre['adresse'];
               $_SESSION['membre']['statut']      = $membre['statut'];
               header("location:profil.php");
         } else {
           $content .='<div class="alert alert-danger" role="alert"> Erreur de mot de passe  </div>';
         }
       }else {
        $content .='<div class="alert alert-danger" role="alert"> Pseudo Inconnu ! </div>';
       }
  }
require_once('inc/haut.inc.php');
echo $content;
?>
<!-- Formulaire HTML de connexion
-pseudo -input type="text"
-mdp -input type="password"-->

   <form class="" action="" method="post">
     <fieldset>
       <legend> <h2>Connexion </h2></legend>
         <label for="pseudo"><h3>   Pseudo   </h3></label>
         <input name="pseudo" type="text" id="pseudo" placeholder="Pseudo" maxlenght="20" pattern="[a-z0-9._%+-]{3,20}$"><br>
         <label for="mdp"><h3>Password</h3></label>
         <input name="mdp" type="password" id="password" placeholder="mot de passe"><br>
     </fieldset>


       <input class="btn btn-primary btn-lg" type="submit" name="submit" value="Soummettre">
   </form>

<?php
require_once('inc/bas.inc.php');
?>
