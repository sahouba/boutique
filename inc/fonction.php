<?php
 function debug($var,$mode=1){
   $trace=debug_backtrace();
   $trace =array_shift($trace);
   echo "<strong> Debug demandé dans le fichier
    :$trace[file] à la ligne : $trace
    [line]</strong>";
     if($mode===1){
        print '<pre>'; print_r($var);print '</pre>';
      }else {
          var_dump($var);
        }
     }
 function internauteEstConnecte()
 {
   if(!isset($_SESSION['membre']))
     return false;
     else {
       return true;
     }
 }
 function internauteEstConnecteEtEstAdmin()
 {
   if(internauteEstConnecte() && $_SESSION['membre']['statut'] == 1) {
     return true;
   }
   else {
     return false;
  }
 }
  function creationPanier(){
    if(!isset($_SESSION['panier'])){
      $_SESSION['panier']= array();
      $_SESSION['panier']['id_produit']= array();
      $_SESSION['panier']['titre']= array();
      $_SESSION['panier']['reference']= array();
      $_SESSION['panier']['quantite']= array();
      $_SESSION['panier']['prix']= array();
    }
  }
  function ajoutProduitDansPanier($id_produit, $titre, $reference, $quantite, $prix){
    creationPanier();
    $postion_produit  = array_search($id_produit,$_SESSION['panier']['$id_produit']);
  }
 ?>
