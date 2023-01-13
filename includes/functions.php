<?php

// Authorization Using the Client Credentials Flow

require 'vendor/autoload.php';

// Hook
add_action("wp_head", "EY_MR_SpotifySearchBar");
add_action("wp_head", "EY_MR_SpotifySearch");
add_action("wp_footer", "Add_Date");

//Spotify plugin background color

function change_plugin_background_color_EY_MR() {
    echo '<style type="text/css">';
    echo '.plugin-container {
            background: linear-gradient(to bottom, #F5F5DC, #F5F5DC);
          }';
    echo '</style>';
}

//welcome part
function add_welcome_sentence() {
    echo '<div class="welcome-sentence-container">';
    echo '<p class="welcome-sentence">Welcome to our plugin!</p>';
    echo '</div>';
}


function EY_MR_SpotifySearchBar() {
    ?>
    <center>
    <form action="" method="GET">

    <input type="radio" name="search_type" value="artist" checked> Artiste
    <input type="radio" name="search_type" value="album"> Album
    <input type="radio" name="search_type" value="track"> Piste

    <input name="search" id="search" type="text" placeholder="Search on Spotify">
    <input id="submit" type="submit" value="Search">

    </form>
    </center>

    <?php
}

function Add_Date()
{

$date = date("d-m-Y");
$heure = date("H:i:s");
$sec = date("s");

  if ($sec % 2 == 0) //Afficher l'heure si secondes paires !
  {
    echo("Nous sommes le $date et il est $heure");
  }
  else // si secondes impaires
  {
    echo "Perdu : $sec";
  }
}

function EY_MR_SpotifySearch() {
    if (!empty($_GET)) {
        $session = new SpotifyWebAPI\Session(
            '8d4e36b37abf4965917bc9fd437ab54d',
            '196a5af2d5c544fd8c612e42190cb86b'
        );
        
        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        if(isset($_GET['track_id'])) {
        
            $track_id = $_GET['track_id'];

		    $iframe = '<iframe src="https://open.spotify.com/embed/track/'.$track_id.'" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>';
            echo $iframe;
        } else {
        $search_type = $_GET['search_type'];
        $search_query = $_GET['search'];

        ?>
        <style>.album img {
            height: 100px;
        }

        </style>
        <?php

        switch($search_type) {
            case 'artist':

           
                    $db = new PDO('sqlite:database.db');
                    $query = "SELECT * FROM artist WHERE name == $search_query";
                    $results = $db->exec($query);

                if(empty($results)) {
                    $results = $api->search($search_query, 'artist');

                        if (!empty($results->artists->items)) {
                            foreach($results->artists->items as $artist) {
                                $artist_uri = $artist->external_urls->spotify;
                                $artist_image_uri = $artist->images[0]->url;
                                $query = "INSERT INTO artist (name, uri, image_uri) VALUES ('$artist->name','$artist_uri', '$artist_image_uri')";
                                $db->exec($query);

                            }
                        }
                }
                
                break;

            case 'album':
                $db = new PDO('sqlite:database.db');
                $query = "SELECT * FROM album WHERE name == $search_query";
                $results = $db->exec($query);

            if(empty($results)) {
                $results = $api->search($search_query, 'album');

                    if (!empty($results->albums->items)) {
                        foreach($results->albums->items as $album) {
                            $album_uri = $album->external_urls->spotify;
                            $album_image_uri = $album->images[0]->url;
                            $query = "INSERT INTO album (name, uri, image_uri) VALUES ('$album->name','$album_uri', '$album_image_uri')";
                            $db->exec($query);

                        }
                    }
            }
                break;

            case 'track':
                $db = new PDO('sqlite:database.db');
                $query = "SELECT * FROM track WHERE name == $search_query";
                $results = $db->exec($query);

            if(empty($results)) {
                $results = $api->search($search_query, 'track');

                    if (!empty($results->tracks->items)) {
                        foreach($results->tracks->items as $track) {
                            $track_uri = $track->external_urls->spotify;
                            $track_image_uri = $track->images[0]->url;
                            $query = "INSERT INTO track (name, uri, image_uri) VALUES ('$track->name','$track_uri', '$track_image_uri')";
                            $db->exec($query);

                        }
                    }
            }
                break;
        }

        switch($search_type) {
            case 'artist':
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom de l'artiste</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($results->artists->items)) {
                            foreach($results->artists->items as $artist) {
                                if(isset($artist->images[0]->url)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo $artist->external_urls->spotify; ?>">
                                                <img src="<?php echo $artist->images[0]->url; ?>" alt="<?php echo $artist->name; ?>" class="album">
                                            </a>
                                        </td>
                                        <td><?php echo $artist->name; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                break;
            case 'album':
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom de l'album</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($results->albums->items)) {
                            foreach($results->albums->items as $album) {
                                if(isset($album->images[0]->url)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo $album->external_urls->spotify; ?>">
                                                <img src="<?php echo $album->images[0]->url; ?>" alt="<?php echo $album->name; ?>" class="album">
                                            </a>
                                        </td>
                                        <td><?php echo $album->name; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                break;
            case 'track':
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom de la piste</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($results->tracks->items)) {
                            foreach($results->tracks->items as $track) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo $track->preview_url; ?>">
                                            <img src="<?php echo $track->album->images[0]->url; ?>" alt="<?php echo $track->album->name; ?>" class="images">
                                        </a>
                                    </td>
                                    <td>
                                    <a href="?track_id=<?php echo $track->id; ?>"><?php echo $track->name; ?></a>

                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                break;
        }
    }

    }

}

// Partie Admin Control Panel

function theme_options_panel(){
add_menu_page('Theme page title', 'Spotify Admin control panel', 'manage_options', 'theme-options', 'wps_theme_func');
}
add_action('admin_menu', 'theme_options_panel');

function wps_theme_func(){
    echo "
    <center>
    <form action=\"\" method=\"GET\">
    <input name=\"search\" id=\"search\" type=\"text\" placeholder=\"Search for a record\">
    <input id=\"submit\" type=\"submit\" value=\"submit\">
    </form>
    </center>
    ";
    echo '<div class="top-bottom-button-container">';
    echo '<button type="button" class="top-bottom-button" id="button1">Delete a record</button>';
    echo '<button type="button" class="top-bottom-button" id="button2">Delete all the records</button>';
    echo '</div>';
}

?>