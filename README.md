# apidae-metadata-tripadvisor

Ce projet fournit des scripts pour faciliter la mise en place d'une
correspondance entre la base Apidae et tripadvisor.

Une fois la correspondance établie entre l'offre Apidae et l'offre tripadvisor,
un script permet d'injecter l'information de correspondance sous forme de
métadonnées sur les objets touristiques Apidae. Cela permet de faire profiter
de l'information tripadvisor à l'ensemble de vos projets ainsi qu'à l'ensemble
du réseau Apidae.

L'injection des informations sous forme de métadonnées nécessite de demander
au réseau Apidae la création d'un noeud de métadonnée qui vous sera dédié.
Tous les noeuds de métadonnées sont nommés sous le format suivant :
  tripadvisor-[fournisseur]

**Pour fonctionner, ces scripts supposent d'être en possession d'un listing
tripadvisor de l'offre que vous désirez associer à Apidae ainsi que de
demander au réseau Apidae un nodeId qui vous soit dédié.**

Ce listing peut être demandé par votre commanditaire à tripadvisor. Ce
listing contient les identifants tripadvisor, le nom et la commune de l'offre.
Les scripts fournis permettent de vous assister dans la mise en correspondance
avec l'offre Apidae.

**La liste des fournisseurs ainsi que la façon d'exploiter la métadonnée sont
décrites dans la documentation Apidae : http://dev.apidae-tourisme.com**

# Prérequis

Les scripts nécessitent la bibliothèque sitra-api-php pour fonctionner. Il faut
utiliser [composer](https://getcomposer.org/) pour
l'[installer](https://github.com/sitra-tourisme/sitra-api-php/) :

```
composer require sitra-tourisme/sitra-api-php
```

# Extraction d'un fichier de proposition - apidae-recherche.php

Le but de cette phase et est de fournir, à partir d'un fichier d'offre
tripadvisor au format CSV suivant :

```
LocationId; Nom; Adresse; Ville
```

D'obtenir un fichier CSV de proposition de correspondance sur la base Apidae.
Les correspondances proposées sont effectuées sur la base d'une recherche par
nom.

**Pour fonctionner, il vous faut modifier le fichier fourni pour y indiquer
vos paramètres projet personnels ainsi que la liste des communes sur
lesquelles faire la recherche de correspondance.** (cf commentaires en début de
fichier)

# Validation du fichier de proposition

Pour assurer la qualité des données Apidae, il est nécessaire de procéder à une
validation des propositions effectuées. Le fichier comporte une ligne par
proposition trouvée via la recherche Apidae. Il faut supprimer du fichier tous
les éléments de manière à ne conserver pour chaque identifiant tripadvisor la
seule correspondance Apidae pertinente.

# Injection des correspondances tripadvisor - Apidae - apidae-metadonnees.php

Les correspondances sont injectées sur les fiches Apidae en utilisant les
métadonnées.

**Pour fonctionner, il vous faut modifier le fichier fourni pour y indiquer
vos paramètres projet personnels ainsi que votre nodeId pour les métadonnées.**

# Résultat de l'injection des correspondances

Une fois les correspondances injectées, le résultat est disponible dans les
flux v2 sous la forme d'un champ métadonnées :

```
"metadonnees" : [ {
    "noeudId" : "tripadvisor-adaka",
    "contenus" : [ {
      "cible" : "general",
      "metadonnee" : {
        "locationId" : "1893513",
        "version" : 1
      }
    } ]
  } ]
```
