# Projet-WebServices-DE3
By Matthieu Remond & Eugène Pascal Yaro

Plugin WordPress Spotify

Consigne

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


Installation & Test de la solution
 --
  Téléchargement du répertoire git
      
     A partir du fichier zip envoyé
     - Extraction du fichier zip
     - Se rendre dans Wordpress installé en local via Wamp/Mamp/Xamp ou chez un hébergeur
     - Se rendre dans wp-content puis plugins 
     - Ajouter le répertoire avec tout le code source

  Exécution du script sqlite pur la création de la base de données en locale
  
       
      Pour créer la base de données sqlite, il suffit juste de faire un double-click sur le
      fichier create_db.bat et le script s'exécute.

  Organisation du code source

      Au niveau du code source, dans includes nous avons :
       - les modules composer et jwilson qui regroupent tous les composants nécessaires à l'accès à l'API Web Spotify 
       - le fichier db_connection.php pour la connexion à la base de données
       - le fichier display.php qui contient les fonctions pour l'affichage des informations sur wordpress
       - le fichier functions.php qui contient toutes les fonctions php qui nous ont permis d'implémenter le plugin spotify.
      la partie sqlite qui est notre base de données locale qui stocke les informations sur les artistes, albums, tracks.
         Le script de création de la base de données locale se trouve dans le fichier create_db.sql :
         La base de  données est constituée des tables :
         artist -> contenant les informations sur les artistes
         album  -> contenant es informations sur les albums
         track  -> contenant les informations sur les titres
         playlist -> contenant les informations sur les playlists utilisateurs
         playlist_track -> contenant les informations sur les titres des playlists.


  Fonctionnement du plugin 
----
Partie Admin

     Une fois le code enregisté, il faut se connecter sur woedpress
     Après que l'authentication soit validée, nous avons accès au dashboard de wordpress.
     Il faut :
      - sur le dashboard, dans la liste des menus à gauche, cliquer sur extensions
      - on retrouve le plugin (MR et EPY plugin) qui s'affiche tout en bas de la liste des plugins
      - En dessous du plugin, cliquer sur activer pour pouvoir l'utiliser.

      Dans la base de données locale, les données sont horodatées.
      Au niveau du dashboard, principalement sur le menu de wordpress qui se trouve 
      à gauche  de la page, nous avons une partie Spotify Admin Control Panel dans laquelle l'Admin peut:
      Faire une recherche sur des données enregistrées.
      Supprimer un enregistrement ou tous les enregistrements.



Partie User ---- Guide d'utilisation

      Une fois le plugin activé, se rendre sur le site wordpress :
      Nous pouvons tester notre plugin.
      Nous pouvons rechercher :
      - un sélectionnant l'option artiste en tapant son nom dans la barre de recherche.
        on obtient l'image de l'artiste concernée et son nom.
        En cliquant éventuellement sur l'image de l'artiste, on a une redirection sur l'api spotify et on peut vérifier les informations de l'artiste à savoir ses sorties les plus populaires, etc....
        
      - En sélectionnant l'option album on peut rechercher un album suivant :
        le nom de l'artiste -> dans ce cas on a la liste de ces albums.
        le nom de l'album -> on obtient directement l'album concerné
        Et si on clique sur l'image de l'album concernée,  on a éventuellement un redirection vers l'API Spotify et on obtient la liste de tous les titres de l'album.
       
      - En sélectionnant l'option Piste on peut rechercher une piste :
        Comme résultat de la recherche, on obtient le nom de la piste
        Et en cliquant sur le nom de la piste nous avons :
        le titre et l'icône play pour écouter le son.
        une redirection sur l'API spotify et nous avons accès à la piste concernée et au sorties les plus populaires de l'artiste.


  
      
 

       
           

          