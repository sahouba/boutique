<?php require_once('inc/init.inc.php');
//---------------- AJOUT AU PANIER ----------------//
if(isset($_POST['ajout_panier'])) {
	$r = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
	$r->execute(array(':id_produit' => $_POST['id_produit']));
	$produit = $r->fetch(PDO::FETCH_ASSOC);
	ajoutProduitDansPanier($produit['id_produit'], $produit['titre'], $produit['reference'], $_POST['quantite'], $produit['prix']);
}
//---------------- AJOUT AU PANIER ----------------//

//---------------- VIDER LE PANIER ----------------//
if(isset($_GET['action']) && $_GET['action'] == "vider") {
	unset($_SESSION['panier']);
}
//---------------- VIDER LE PANIER ----------------//


//--------------- PAIEMENT DU PANIER --------------//
if(isset($_POST['payer'])) {
	for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
		$resultat = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
		$resultat->execute(array(':id_produit' => $_SESSION['panier']['id_produit'][$i]));
		$produit = $resultat->fetch(PDO::FETCH_ASSOC);
		if($produit['stock'] < $_SESSION['panier']['quantite'][$i]) {
			if($produit['stock'] > 0) { // encore un peu de stock
				$_SESSION['panier']['quantite'][$i] = $produit['stock'];
			$content .= '<div class="alert alert-warning" role="alert">La quantité du produit n° ' . $_SESSION['panier']['id_produit'][$i] . ' a été reduite car notre stock était insuffisant, veuillez vérifier vos achats.</div>';
			} else { // plus de stock
				$content .= '<div class="alert alert-warning" role="alert">Le produit n° ' . $_SESSION['panier']['id_produit'][$i] . ' a été retiré de votre panier car nous sommes en rupture de stock, veuillez vérifier vos achats.</div>';
				retireProduitPanier($_SESSION['panier']['id_produit'][$i]);
				$i--;
			}
		}
		$erreur = true;
	}
	if(!isset($erreur)) {
		$r = $pdo->prepare("INSERT INTO commande (id_membre, montant, date_enregistrement) VALUES (:id_membre, :montant, :date_enr)");
		$r->execute(array(
			':id_membre' => $_SESSION['membre']['id_membre'],
			':montant' => montantTotal(),
			':date_enr' => NOW()
		));
		$id_commande = $pdo->lastInsertId();
		for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
			$result = $pdo->prepare("INSERT INTO details_commande (id_commande, id_produit, quantite, prix) VALUES (:id_commande, :id_produit, :quantite, :prix)");
			$result->execute(array(
				':id_commande' => $id_commande,
				':id_produit' => $_SESSION['panier']['id_produit'][$i],
				':quantite' => $_SESSION['panier']['quantite'][$i],
				':prix' => $_SESSION['panier']['prix'][$i]
			));
			$r = $pdo->prepare("UPDATE produit SET stock = stock - :stock WHERE id_produit = :id_produit");
			$r->execute(array(
				':stock' => $_SESSION['panier']['quantite'][$i],
				':id_produit' => $_SESSION['panier']['id_produit'][$i]
			));
		}
		unset($_SESSION['panier']);
		$content .= '<div class="alert alert-success" role="alert">Merci pour votre commande, votre n° de suivi est le ' . $id_commande . '.</div>';
	}
}
//--------------- PAIEMENT DU PANIER --------------//

//--------------- SUPPRIMER UN PRODUIT ------------//
if(isset($_GET['action']) && $_GET['action'] == 'suppression') {
	retireProduitPanier($_GET['id_produit']);
}
//--------------- SUPPRIMER UN PRODUIT ------------//

//---------------- AFFICHAGE DU PANIER ------------//
$content .= '<table class="table">';
$content .= '<tr><th>id_produit</th><th>titre</th><th>référence</th><th>quantité</th><th>prix</th>';
$content .= '<th colspan="1">Supprimer</th></tr>';
if(empty($_SESSION['panier']['id_produit'])) { // si le panier est vide
	$content .= '<tr><td colspan="6">Votre panier est vide</td></tr>';
} else {
	for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
		$content .= '<tr>';
		$content .= '<td>' . $_SESSION['panier']['id_produit'][$i] . '</td>';
		$content .= '<td>' . $_SESSION['panier']['titre'][$i] . '</td>';
		$content .= '<td>' . $_SESSION['panier']['reference'][$i] . '</td>';
		$content .= '<td>' . $_SESSION['panier']['quantite'][$i] . '</td>';
		$content .= '<td>' . $_SESSION['panier']['prix'][$i] . '</td>';
		$content .= '<td><a href="?action=suppression&id_produit=' . $_SESSION['panier']['id_produit'][$i] . '" onClick="return(confirm(\'En êtes vous certain ?\'))"><span class="glyphicon glyphicon-trash"></span></a></td>';
		$content .= '</tr>';
	}
	$content .= '<tr><th colspan="6">Montant total de vos achats&nbsp;:' . montantTotal() . '€</th></tr>';
	if(internauteEstConnecte()) {
		$content .= '<form method="post" action="">';
		$content .= '<tr><td colspan="6"><input type="submit" name="payer" value="Valider le paiement" class="btn btn-default"></td></tr>';
		$content .= '</form>';
	} else {
		$content .= '<tr><td colspan="6">Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir payer</td></tr>';
	}
}
$content .= '</table>';
$content .= '<i>Réglement par CHÈQUE uniquement à l\'adresse suivante : <a href="https://www.google.com.br/maps/search/aston/@48.8301586,2.287713,12z/data=!3m1!4b1" target="_blank">19-21 Rue du 8 Mai 1945, 94110 Arcueil.</a></i><br>';
//---------------- AFFICHAGE DU PANIER ------------//

require_once('inc/haut.inc.php');
?>
<h1>Panier</h1>
<?= $content; ?>
<?php require_once('inc/bas.inc.php'); ?>
