# Projet-WebServices-DE3

Plugin WordPress Spotify

Vous devez créer une nouvelle extension pour le CMS WordPress permettant d'utiliser la base de données du site web d'écoute musicale Spotify.

WordPress pourra être installé

    en local via Wamp/Mamp/Xamp
    chez un hébergeur web
        par exemple InfinityFree/ByetHost + Installation en 3 clic Softaculous.
            Attention : gratuit et sans pub, bien pour POC de courte durée. Non fiable dans le temps comme tous les hébergeurs gratuits sans pubs.
        Hébergement perso (EVXOnline, OVH, Ionos, O2Switch...)
        Attention : sur le réseau EduRoam : accès FTP en clair + Softaculous indisponible.

Utilisation de l'extension :

Cette extension sera accessible :

    côté interface d'administration de WP : pour consulter/réaliser/enregistrer les réglages de l'extension
    côté site web vitrine :
        accès au moteur de recherche pour utiliser la base de données Spotify = rechercher des informations (Groupe / Album / Titre) dans la base de données Spotify
        affichage des informations récupérées = fiche artiste, fiche album, autres informations.

Fonctionnement de l'extension :

L'extension fonctionnera en 2 étapes :
Une recherche d'information est d'abord réalisée dans une base de données locale au format SQLite.
Si l'information n'existe pas / est incomplète, l'extension interroge la base de donnée Spotify, récupére les informations et les stocke en local dans la base SQLite et système de fichier.
Dans les deux cas, le résultat montre où les données sont récupérées : en local ou à distance.

Les informations récupérées sont horodatées. Un réglage dans l'extension permet de déclencher un message d'alerte "données périmées, veuillez mettre à jour" + bouton de déclenchement de mise à jour des données périmées.
Les informations sont consultables côté administration : recherche et suppression d'un enregistrement, suppression de tous les enregistrements.

Les informations sont récupérées via l'API Web Spotify : besoin d'un compte et d'une clef API pour accéder aux informations : https://developer.spotify.com/documentation/web-api/
Base technique :

Prérequis lancement de projet :

    le nom du plugin, son dossier, les fonctions internes contiennent vos initiales
    concevoir un plugin WP avec shortcode et variables en BDD WP
    concevoir un script PHP pour stocker des informations avec SQLite
    utiliser une API avec, par exemple, PostMan.
    disposer d'un compte gratuit chez Spotify et créer une nouvelle application : https://developer.spotify.com/dashboard/applications

Evaluation :

Le rendu de projet sur Mootse contiendra :

    le plugin (uniquement) au format ZIP, prêt à être installé et activé dans une quelconque instance de WordPress
    un CR technique : installation, utilisation, gestion des données, prérequis + captures d'écran des différents cas d'utilisation (en cas de soucis)
    un CR de projet : méthode projet, problèmes et solutions apportées. Pour chaque étudiant : bilan technique et impressions personnelles
    le soin et la qualité du projet seront autant appréciés que le code ou l'orthographe.
