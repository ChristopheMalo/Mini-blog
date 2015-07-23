<!DOCTYPE html>
<html lang='fr'>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Les derniers commentaires du blog</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/style_01.css"  rel="stylesheet" type="text/css" media="all">
    </head>
    <body>
        <div class="container">
            <h1 class="row">Un blog basique</h1>
            <h2 class="row">Le billet</h2>
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
                <h3 class="row">Les commentaires</h3>
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
                
                $req->closeCursor();  // Ferme le curseur, après affichage billet, permettant à la requête d'être de nouveau exécutée
                $req2->closeCursor(); // Ferme le curseur, après affichage commentaires, permettant à la requête d'être de nouveau exécutée
                $bdd = null;          // Fermeture de la connexion à la base
                ?>
                
                <!-- Ajouter un commentaire au billet -->
                <!-- Formulaire de saisie -->
                <h3 class="row">Ajouter un commentaire</h3>
                <div class="row">
                    <form class="form-horizontal col-md-12" method="post" action="commentaire_post.php?forBillet=<?php echo $id_billet; ?>">

                        <!-- Champ de saisie texte une ligne -->
                        <div class="form-group form-group-lg">
                            <label for="pseudo" class="col-sm-2 control-label">Pseudo : </label>
                            <div class="col-sm-10 focus"> 
                                <input class="form-control" <?php
                                    /*
                                     * si un pseudo existe dans le cookie,
                                     * alors renseigne automatiquement la valeur du champ pseudo
                                     * implicitement, si le cookie n'est pas détecté,
                                     * la valeur du champ n'est pas renseignée
                                     */
                                    if (isset($_COOKIE['pseudo'])) {
                                        $cookie_pseudo = htmlspecialchars(strip_tags($_COOKIE['pseudo']));
                                        echo 'value="' . $cookie_pseudo . '"';
                                    }
                                    ?> type="text" name="pseudo" id="pseudo" placeholder="Ton pseudo" autofocus required>
                            </div>
                        </div>

                        <div class="form-group form-group-lg">
                            <label for="commentaire" class="col-sm-2 control-label">Message : </label>
                            <div class="col-sm-10 focus"> 
                                <input class="form-control" type="text" name="commentaire" id="message" placeholder="Ton commentaire" autofocus required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-default btn-lg pull-right clearfix">Envoyer</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
                
                <p><a href="../index.php">Retour à la liste des billets</a></p>
            </section>
        </div>
    </body>
</html>