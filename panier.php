<?php require_once('inc/init.inc.php');

//--------- AFFICHAGE DU PANIER ---------//
$content .= '<table class="table">';
$content .= '<tr><th>id_produit</th><th>référence</th><th>quantité</th><th>prix</th>';
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
$content .= '<i>Réglement par CHÈQUE uniquement à l\'adresse suivante : <a href="https://www.google.com.br/maps/search/aston/@48.8301586,2.287713,12z/data=!3m1!4b1">19-21 Rue du 8 Mai 1945, 94110 Arcueil.</a></i><br>';

require_once('inc/haut.inc.php');
?>
<h1>Panier</h1>
<?= $content; ?>
<?php require_once('inc/bas.inc.php'); ?>
