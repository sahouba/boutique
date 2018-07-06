<?php require_once('../inc/init.inc.php');
//------------- TRAITEMENTS PHP -----------//
//------------ VÉRIFICATION ADMIN ---------//
if(!internauteEstConnecteEtEstAdmin()) {
	header("location:../connexion.php");
	exit();
}
//------------ VÉRIFICATION ADMIN ---------//

//------- ENREGISTREMENT D'UN PRODUIT -----//
if(!empty($_POST)) {
	// debug($_POST);
	$photo_bdd = '';
	if(isset($_GET['action']) && $_GET['action'] == 'modification') {
		$photo_bdd = $_POST['photo_actuelle']; // en cas de modification, on récupère la photo actuelle.
	}

	if(!empty($_FILES['photo']['name'])) { // s'il y a une photo qui a été ajoutée
		$photo_bdd = URL . "photo/$_POST[reference]_" . $_FILES['photo']['name']; // cette variable nous permettera de sauvegarder le chemin de la photo dans la base
		$photo_dossier = RACINE_SITE . "photo/$_POST[reference]_" . $_FILES['photo']['name']; // cette variable nous permettera de sauvegarder la photo dans le dossier
		copy($_FILES['photo']['tmp_name'], $photo_dossier); // copy permet de sauvegarder une fichier sur le serveur
	}

	$id_produit = (isset($_GET['id_produit'])) ? $_GET['id_produit'] : 'NULL'; // s'il y a un id_produit dans l'url c'est que nous sommes dans le cas d'une modification
	$produit = $pdo->prepare("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, sexe, photo, prix, stock) VALUES (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :sexe, :photo, :prix, :stock)");
	$produit->execute(array(
		':id_produit' => $id_produit,
		':reference' => $_POST['reference'],
		':categorie' => $_POST['categorie'],
		':titre' => $_POST['titre'],
		':description' => $_POST['description'],
		':couleur' => $_POST['couleur'],
		':taille' => $_POST['taille'],
		':sexe' => $_POST['sexe'],
		':photo' => $photo_bdd,
		':prix' => $_POST['prix'],
		':stock' => $_POST['stock']
	));
	$content .= '<div class="alert alert-success">Le produit a bien été ajouté ;-) !</div>';
header('Refresh: 2; gestion-des-produits.php?action=affichage');
}
//------- ENREGISTREMENT D'UN PRODUIT -----//

//--------- SUPPRESSION D'UN PRODUIT -------//
if(isset($_GET['action']) && $_GET['action'] == 'suppression') {
	$resultat = $pdo->prepare("DELETE FROM produit WHERE id_produit = :id_produit");
	$resultat->execute(array(':id_produit' => $_GET['id_produit']));
}
//--------- SUPPRESSION D'UN PRODUIT -------//

//------------- LIENS PRODUITS -------------//
$content .= '<a href="?action=affichage">Affichage des produits</a><br>'; // Lien d'affichage
$content .= '<a href="?action=ajout">Ajout d\'un produit</a><br><br><hr><br>'; // Lien d'ajout
//------------- LIENS PRODUITS -------------//

//-------- AFFICHAGE DES PRODUITS ----------//
if(isset($_GET['action']) && $_GET['action'] == "affichage") {
	$resultat = $pdo->prepare('SELECT * FROM produit');
	$resultat->execute();
	$content .= '<h2>Affichage des produits</h2>';
	$content .= 'Nombre de produit(s) dans la boutique : ' . $resultat->rowCount();
	$content .= '<table class="table table-bordered table-striped"><tr>';
	for($i = 0; $i < $resultat->columnCount(); $i++) { // boucle sur les colonnes
		$colonne = $resultat->getColumnMeta($i); // getColumnMeta récupère les informations sur les columnCount
		$content .= "<th>$colonne[name]</th>";
	}
	$content .= '<th colspan="2">Actions</th>';
	$content .= '</tr>';
	while($produits = $resultat->fetch(PDO::FETCH_ASSOC)) { // boucle sur les données
		$content .= '<tr>';
		foreach($produits as $indice => $valeur) {
			if($indice == 'photo')
				$content .= "<td><img class='thumbnail' src=\"$valeur\"></td>";
			else
				$content .= "<td>$valeur</td>";
		}
		$content .= '<td><a href="?action=modification&id_produit=' . $produits['id_produit'] . '"><span class="glyphicon glyphicon-pencil"></span></a></td>'; // lien de modification
		$content .= '<td><a href="?action=suppression&id_produit=' . $produits['id_produit'] . '" onClick="return(confirm(\'En êtes vous certain ?\'))"><span class="glyphicon glyphicon-trash"></span></a></td>'; // lien de suppression
	}
	$content .= '</tr></table><br><hr><br>';
}
//-------- AFFICHAGE DES PRODUITS ----------//

//-------- MODIFICATION DES PRODUITS -------//
if(isset($_GET['action']) && $_GET['action'] == 'modification') {
	$r = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id_produit"); // récupération des informations d'un produit
	$r->execute(array(':id_produit' => $_GET['id_produit']));
	$produit = $r->fetch(PDO::FETCH_OBJ); // accès aux données
}
// Si nous sommes dans le cas d'une modification, nous souhaitons pré-remplir le formulaire avec les informations actuelles (sinon, en cas d'ajout, les variables seront vides).
$id_produit = (isset($produit->id_produit)) ? $produit->id_produit : '';
$reference = (isset($produit->reference)) ? $produit->reference : '';
$categorie = (isset($produit->categorie)) ? $produit->categorie : '';
$titre = (isset($produit->titre)) ? $produit->titre : '';
$description = (isset($produit->description)) ? $produit->description : '';
$couleur = (isset($produit->couleur)) ? $produit->couleur : '';
$taille = (isset($produit->taille)) ? $produit->taille : '';
$sexe = (isset($produit->sexe)) ? $produit->sexe : '';
$photo = (isset($produit->photo)) ? $produit->photo : '';
$prix = (isset($produit->prix)) ? $produit->prix : '';
$stock = (isset($produit->stock)) ? $produit->stock : '';
//-------- MODIFICATION DES PRODUITS -------//

//---- FORMULAIRE D'AJOUT D'UN PRODUIT -----//
require_once("../inc/haut.inc.php");
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) {
	if(isset($_GET['id_produit'])) {
		$resultat = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
		$resultat->execute(array(':id_produit' => $_GET['id_produit']));
		$produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
	}

$content .= 'Bonjour <br> voici la gestion des produits.<hr>';

$content .= '
<form method="post" action="" enctype="multipart/form-data">
	<input type="hidden" id="id_produit" name="id_produit" value="';
		if(isset($produit_actuel['id_produit'])) $content .= $produit_actuel['id_produit'];
		$content .= '">
	<div class="form-group">
		<label for="reference">Référence : </label><br>
		<input type="text" id="reference" name="reference" placeholder="Référence du produit" value="' . $reference . '"><br>
	</div>
	<div class="form-group">
		<label for="categorie">Catégorie : </label><br>
		<input type="text" id="categorie" name="categorie" placeholder="Catégorie du produit" value="' . $categorie . '"><br>
	</div>
	<div class="form-group">
		<label for="titre">Titre : </label><br>
		<input type="text" id="titre" name="titre" placeholder="Titre du produit" value="' . $titre .'"><br>
	</div>
	<div class="form-group">
		<label for="description">Description : </label><br>
		<textarea name="description" id="description" placeholder="Description du produit">' . $description . '</textarea><br>
	</div>
	<div class="form-group">
		<label for="couleur">Couleur : </label><br>
		<input type="text" id="couleur" name="couleur" placeholder="Couleur du produit" value="' . $couleur .'"><br>
	</div>
	<div class="form-group">
		<label for="taille">Taille : </label><br>
		<select name="taille" id="taille">
			<option value="S"';
			if($taille == 'S') $content .= ' selected';
			$content .= '>S</option>';
			$content .= '<option value="M"';
			if($taille == 'M') $content .= ' selected';
			$content .= '>M</option>';
			$content .= '<option value="L"';
			if($taille == 'L') $content .= ' selected';
			$content .= '>L</option>';
			$content .= '<option value="XL"';
			if($taille == 'XL') $content .= ' selected';
			$content .= '>XL</option>';
		$content .= '
		</select><br>
	</div>
	<div class="form-group">
		<label for="sexe">Sexe : </label><br>
		<select name="sexe" id="sexe">
			<option value="f" ';
			if($sexe == 'f') $content .= ' selected';
			$content .= '>Femme</option>';
			$content .= '<option value="m" ';
			if($sexe == 'm') $content .= ' selected';
			$content .= '>Homme</option>';
			$content .= '<option value="mixte" ';
			if($sexe == 'mixte') $content .= ' selected';
			$content .= '>Mixte</option>';
		$content .= '
		</select><br>
	</div>
	<div class="form-group">
		<label for="photo">Photo : </label><br>

		<input type="file" id="photo" name="photo" placeholder="Photo du produit"  required>';
		if(!empty($photo)) {
			$content .= 'Photo actuelle : <img src="' . $photo . '" width="50">';
			$content .= '<input type="hidden" name="photo_actuelle" value="' . $photo . '">';
		}
		$content .=	'<br>
	</div>
	<div class="form-group">
		<label for="prix">Prix : </label><br>
		<input type="text" id="prix" name="prix" placeholder="Prix du produit" value="' . $prix . '"><br>
	</div>
	<div class="form-group">
		<label for="stock">Stock : </label><br>
		<input type="text" id="stock" name="stock" placeholder="Stock du produit" value="' . $stock . '"><br>
	</div>
	<div class="form-group">
		<input type="submit" value="';
		$content .= ucfirst($_GET['action']) . ' du produit';
		$content .=	'"><br>
	</div>
</form>';
}
//---- FORMULAIRE D'AJOUT D'UN PRODUIT -----//
echo $content;
require_once("../inc/bas.inc.php");
