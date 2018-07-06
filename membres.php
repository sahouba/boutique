<?php require_once("inc/init.inc.php");
//----------------------------------TRAITEMENTS PHP ----------------------------------------------------//
if(!internauteEstConnecte()) {
  header('location:connexion.php');
  exit();
}

require_once('inc/haut.inc.php');

//------------------- ENREGISTREMENT D'UNE MODIFICATION ----------------------//
if(!empty($_POST)) {
  $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
  foreach($_POST as $indice => $valeur) {
	$_POST[$indice] = addslashes($valeur);
  }
  $id_membre = (isset($_GET['id_membre'])) ? $_GET['id_membre'] : 'NULL'; // s'il y a un id_membre dans l'url c'est que nous sommes dans le cas d'une modification
  $pdo->exec("REPLACE INTO membre (id_membre, pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES ('$id_membre', '$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[cp]', '$_POST[adresse]')");
$content .= '<div class="alert alert-success">La modification a bien été enregistrée ;-) !</div>';
}

//------------------------------------- MODIFICATION DES MEMBRES --------------------------------//
if(isset($_GET['action']) && $_GET['action'] == 'modification') {
    $r = $pdo->query("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]"); // récupération des informations d'1 membre
    $membre = $r->fetch(PDO::FETCH_ASSOC); // accès aux données
}

// si nous sommes dans le cas d'une modification, nous souhaitons pré-remplir le formulaire avec les informations actuelles (sinon, en cas d'ajout, les variables seront vides) :
    $id_membre = (isset($membre['id_membre'])) ? $membre['id_membre'] : '';
    $pseudo = (isset($membre['pseudo'])) ? $membre['pseudo'] : '';
    $mdp = (isset($membre['mdp'])) ? $membre['mdp'] : '';
    $nom = (isset($membre['nom'])) ? $membre['nom'] : '';
    $prenom = (isset($membre['prenom'])) ? $membre['prenom'] : '';
    $email = (isset($membre['email'])) ? $membre['email'] : '';
    $civilite = (isset($membre['civilite'])) ? $membre['civilite'] : '';
    $ville = (isset($membre['ville'])) ? $membre['ville'] : '';
    $code_postal = (isset($membre['code_postal'])) ? $membre['code_postal'] : '';
    $adresse = (isset($membre['adresse'])) ? $membre['adresse'] : '';
    $statut = (isset($membre['statut'])) ? $membre['statut'] : '';

    if(isset($_GET['action']) && ($_GET['action'] ==  'modification')) {
        if(isset($_GET['id_membre'])) {
            $resultat = $pdo->query("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");
            $membre_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
        }
        $content .= '
        <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" id="id_membre" name="id_membre" value="';
		if(isset($membre_actuel['id_membre'])) $content .= $membre_actuel['id_membre'];
          $content .= '">
        <div class="form-group">
          <label for="pseudo">Pseudo : </label><br>
          <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo du membre" value="' . $pseudo . '"><br>
        </div>
        <div class="form-group">
          <label for="mdp">Mot de passe : </label><br>
          <input type="text" id="mdp" name="mdp" placeholder="Mdp du membre" value="' . $mdp . '"><br>
        </div>
        <div class="form-group">
          <label for="nom">Nom : </label><br>
          <input type="text" id="nom" name="nom" placeholder="Nom du membre" value="' . $nom . '"><br>
        </div>
        <div class="form-group">
          <label for="prenom">Prenom : </label><br>
          <textarea name="prenom" placeholder="Prenom du membre">' . $prenom . '</textarea><br>
        </div>
        <div class="form-group">
          <label for="email">Email : </label><br>
          <input type="text" id="email" name="email" placeholder="Email du membre" value="' . $email . '"><br>
        </div>
        <div class="form-group">
          <label for="civilite">Civilite : </label><br>
          <input type="radio" name="civilite" placeholder="Civilite du membre" value="m" checked';
          if($civilite == 'm') $content .= ' checked';
          $content .= '> Homme<br>
          <input type="radio" name="civilite" placeholder="Civilite du membre" value="f"';
          if($civilite == 'f') $content .= ' checked';
          $content .= '> Femme<br>
        </div>
        <div class="form-group">
          <label for="ville">Ville : </label><br>
          <input type="text" name="ville" placeholder="Ville du membre" value="' . $ville . '"><br>
        </div>
        <div class="form-group">
            <label for="code_postal">Code postal : </label><br>
            <input type="text" name="cp" placeholder="Votre cp" value="' . $code_postal . '"><br>
        </div>
        <div class="form-group">
            <label for="adresse">Adresse : </label><br>
            <textarea name="adresse" placeholder="Adresse du membre">' . $adresse . '</textarea><br>
        </div>

        <div class="form-group">
          <input type="submit" value="'; $content .= ucfirst($_GET['action']) . ' du membre';
          $content .= '">
        </div>
        </form>';
        }

?>
<?php echo $content; ?>
<?php require_once("inc/bas.inc.php"); ?>
