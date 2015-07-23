<?php
include '../configuration/configurationPDO.php';

// Réception données formulaire par method post
$auteur         = htmlspecialchars(strip_tags($_POST['pseudo']));  // Pseudo
$id_billet      = htmlspecialchars(strip_tags($_GET['forBillet']));   // id du billet associé
$commentaire    = htmlspecialchars(strip_tags($_POST['commentaire'])); // Messsage

// Preparation requete + execution
$requete = $bdd->prepare('INSERT INTO commentaires(
                                                   id_billet,
                                                   auteur,
                                                   commentaire,
                                                   date_creation_commentaire
                                                   ) 
                                             VALUES(
                                                   :id_billet,
                                                   :auteur, 
                                                   :commentaire,
                                                   NOW()
                                                   )');

$requete->bindParam(':id_billet',   $id_billet,   pdo::PARAM_INT);
$requete->bindParam(':auteur',      $auteur,      PDO::PARAM_STR);
$requete->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);

$requete->execute();

if ($requete) {
    /*
     * Le cookie est créé dans pour le dossier pages,
     * le path '/' rend le cookie accessible dès la racine du site
     * et nonb pas uniquement à partir du dossier pages
     */
    setcookie('pseudo',$auteur, time() + 365*24*3600, '/', null, false, true);
    header('Location: commentaires.php?billet=' . $id_billet); // Retour automatique au billet d'origine
} else {
    echo '<p>L\enregistrement a échoué<br><a href="commentaires.php?' . $id_billet . '">Retour au billet</a></p>';
}