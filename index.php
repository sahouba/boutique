<?php require_once('inc/init.inc.php');

$r = $pdo->prepare("SELECT DISTINCT(categorie) FROM produit");
$r->execute();
$content .= '<div class="row">';
$content .= '<div class="col-md-3"><div class="list-group">';
while($categorie = $r->fetch(PDO::FETCH_ASSOC)) {
	$content .= "<a href=\"?categorie=$categorie[categorie]\" class=\"list-group-item\">$categorie[categorie]</a>";
}
$content .= '</div></div>';
$content .= '<div class="col-md-8 col-md-offset-1">';

if(isset($_GET['categorie'])) {
	$r = $pdo->prepare("SELECT * FROM produit WHERE categorie = :categorie");
	$r->execute(array(':categorie' => $_GET['categorie']));
	while($produit = $r->fetch(PDO::FETCH_ASSOC)) {
		$content .= '
		<div class="col-sm-4 col-lg-4 col-sm-4">
		<div class="thumbnail">
			<a href="fiche-produit.php?id_produit=' . $produit['id_produit'] . '">
			<img  class="thumbnail" src="' . $produit['photo'] . '" alt=""></a><br><br>
			<div class="caption">
				<a href="fiche-produit.php?id_produit=' . $produit['id_produit'] . '"><h4>' . $produit['titre'] . '</h4></a>
				<p>' . $produit['description'] . '</p><strong>' . $produit['prix'] . '€</strong>
				</div>
			</div>
			</div>
		';
	}
}
require_once('inc/haut.inc.php');
?>
<h1>Nos produits</h1>
<p>Voici notre catalogue de vêtements</p>
<hr>
<?= $content; ?>

<?php require_once('inc/bas.inc.php'); ?>
