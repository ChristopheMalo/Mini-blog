<!DOCTYPE html>
<html lang='fr'>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Les derniers commentaires du blog</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1 class="row">Un blog basique</h1>
            <h2 class="row">Le billet <titre du billet></h2>
            <!-- Afficher le billet et les commentaires -->
            <section class="row">
                <p><a href="../index.php">Retour à la liste des billets</a></p>
                <?php
                include '../configuration/configurationPDO.php'; // Connexion à la base
        
                // Récupérer le billet
                $sql = "SELECT id, titre, contenu, DATE_FORMAT(date_creation_billet, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_billet_fr
                        FROM billets
                        WHERE id = :id_billet
                       ";
                
                $req = $bdd->prepare($sql);
                
                $id_billet = htmlspecialchars(strip_tags($_GET['billet']));
                $req->bindParam(':id_billet', $id_billet, PDO::PARAM_INT);
                
                $req->execute();
                $datas_billet = $req->fetch(PDO::FETCH_ASSOC);
                
                /*
                 *  Récupérer les commentaires associés au billet
                 * Ici je peux réutiliser $sql et $req
                 * Mais pour plus de clarté du code j'introduis un $sql2 et $req2
                 */
                $sql2 = "SELECT auteur, commentaire, DATE_FORMAT(date_creation_commentaire, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_commentaire_fr
                        FROM commentaires
                        WHERE id_billet = :id_billet
                        ORDER BY date_creation_commentaire
                       ";
                
                $req2 = $bdd->prepare($sql2);
                $req2->bindParam(':id_billet', $id_billet, PDO::PARAM_INT);
                $req2->execute();
                $datas_commentaires = $req2->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- Afficher le billet -->
                <div class="panel panel-default">
                    <div class="panel-heading"><p><strong><?php echo htmlspecialchars(strip_tags($datas_billet['titre'])); ?></strong> - <em>Le <?php echo $datas_billet['date_creation_billet_fr'] ; ?></em></p></div>
                    <div class="panel-body">
                        <p><?php echo nl2br(htmlspecialchars(strip_tags($datas_billet['contenu']))); ?></p>
                    </div>
                </div>

                <!-- Afficher les commentaires -->
                <h3>Les commentaires</h3>
                <?php

                if (empty($datas_commentaires)) {
                    echo '<p>Il n\'y a aucun commentaire</p>';
                }
                
                foreach ($datas_commentaires as $row) {
                    $auteur           = htmlspecialchars(strip_tags($row['auteur']));
                    $commentaire      = nl2br(htmlspecialchars(strip_tags($row['commentaire'])));
                    $date_commentaire = $row['date_creation_commentaire_fr'];
                ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><p><strong><?php echo $auteur; ?></strong> - <em>Le <?php echo $date_commentaire; ?></em></p></div>
                        <div class="panel-body">
                            <p><?php echo $commentaire; ?></p>
                        </div>
                    </div>
                <?php
                } // Fin du foreach
                
                $req->closeCursor();  // Ferme le curseur après affichage billet, permettant à la requête d'être de nouveau exécutée
                $req2->closeCursor(); // Ferme le curseur après affichage commentaires, permettant à la requête d'être de nouveau exécutée
                $bdd = null;          // Fermeture de la connexion à la base
                ?>
                
                
                <p><a href="../index.php">Retour à la liste des billets</a></p>
            </section>
        </div>
    </body>
</html>