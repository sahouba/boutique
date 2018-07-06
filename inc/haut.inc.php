<!Doctype html>
<html lang="fr" dir="ltr">
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
		<title>Boutique</title>
	</head>
	<body>
		<header>
			<div class="container">
				<div>
					<a href="" title="Mon Site">Monsite.com</a>
				</div>
        <nav class="navbar navbar-dark bg-dark">

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      

      <div class="collapse navbar-collapse" id="navbarsExample01">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link" href="<?= URL; ?>index.php">Accueil </a>
          </li>
          <li class="nav-item">
            	<?php if(internauteEstConnecteEtEstAdmin()): ?>
            <a class="nav-link" href="<?= URL; ?>admin/gestion-des-produits.php">Gestion des produits</a>
            	<?php endif; ?>
          </li>
          <li class="nav-item">
            <?php if(internauteEstConnecte()): ?>
          			<li><a class="nav-link" href="<?= URL; ?>panier.php">Panier</a></li>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membre</a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                  <ul>
                    <li class="dropdown-item"><a href="<?= URL; ?>profil.php">Profil</a></li>
                    <li class="dropdown-item"><a href="<?= URL; ?>connexion.php?action=deconnexion">Déconnexion</a></li>

                  </ul>
                </li>
                  </div>
                </div>
              <?php else: ?>
              <li> <a class="nav-link" href="<?= URL; ?>panier.php">Panier</a></li>
              <div class="dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membre</a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <li>
                <ul>
                  <li class="dropdown-item"><a href="<?= URL; ?>inscription.php">Inscription</a></li>
                  <li class="dropdown-item"><a href="<?= URL; ?>connexion.php">Connexion</a></li>

                </ul>
              </li>
                </div>
              </div>
              <?php endif; ?>

          </li>

        </ul>

      </div>
      <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </nav>
    <!--
				<nav class="navbar navbar-dark bg-dark">
					<ul>
						<li><a href="<?= URL; ?>index.php">Accueil</a></li>
					<?php if(internauteEstConnecteEtEstAdmin()): ?>
						<li><a href="<?= URL; ?>admin/gestion-des-produits.php">Gestion des produits</a></li>
					<?php endif; ?>
					<?php if(internauteEstConnecte()): ?>
						<li><a href="<?= URL; ?>panier.php">Panier</a></li>
						<div class="dropdown">
							<button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membre</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<li><a href='#'></a>
							<ul>
								<li class="dropdown-item"><a href="<?= URL; ?>profil.php">Profil</a></li>
								<li class="dropdown-item">
								<a href="<?= URL; ?>connexion.php?action=deconnexion">Déconnexion</a></li>
							</ul>
						</li>
							</div>
						</div>
						<?php else: ?>
						<li><a href="<?= URL; ?>panier.php">Panier</a></li>
						<div class="dropdown">
							<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membre</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<li><a href='#'></a>
							<ul>
								<li class="dropdown-item"><a href="<?= URL; ?>inscription.php">Inscription</a></li>
								<li class="dropdown-item"><a href="<?= URL; ?>connexion.php">Connexion</a></li>
							</ul>
						</li>
							</div>
						</div>
						<?php endif; ?>
				</nav>
			</div>
    -->
		</header>
			<section>
				<div class="container">
