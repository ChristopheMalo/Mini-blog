# Mini-blog
TP Openclassrooms - Développement d'un mini-blog avec fonctions basiques

Le mini-blog se veut très simple. Dans ce TP j'utilise PDO pour me connecter à une base de donnée MySQL.

Grâce à PDO, le code est utilisable avec d'autres bases de données.

Pour mettre en forme les écrans du site, j'utilise bootstrap minifié (maxcdn en version 3.3.5).

Les requêtes SQL sont des requêtes préparées.

##Résumé du TP :
Utilisation de :
- SELECT
- Jointure
- Requêtes préparées

##Ajout de fonctions supplémentaires :
- Mise en forme avec Bootstrap
- Utilisation include pour la configuration
- Pagination dynamique PHP/Bootstrap pour les billets
- Formulaire pour ajouter des commentaires aux billets
- Cookie pour retenir le pseudo saisi par l'utilisateur

##Attention
Je sais que l'on ne doit pas mettre en ligne un fichier de configuration. Mais dans ce cas précis, l'exercice est développé en local.
Aucune donnée sensible ne transite dans ce fichier. Dans le cas d'un développement avec des données sensibles, j'utilise .gitignore.
