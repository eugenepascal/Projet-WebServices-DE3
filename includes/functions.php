<?php

// Authorization Using the Client Credentials Flow

require 'vendor/autoload.php';

// Hook
<<<<<<< HEAD
add_action("wp_head", "SpotifySearchBar");
add_action("wp_head", "SpotifySearch");
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

=======
add_action("wp_head", "EY_MR_SpotifySearchBar");
add_action("wp_head", "EY_MR_SpotifySearch");
>>>>>>> 75757fd703b0a15ecac216fcb7e567ead4dfc1e9

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

<<<<<<< HEAD
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

function SpotifySearch() {
=======
function EY_MR_SpotifySearch() {
>>>>>>> 75757fd703b0a15ecac216fcb7e567ead4dfc1e9
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

<<<<<<< HEAD

        ?>
=======
            $iframe = '<iframe src="https://open.spotify.com/embed/track/'.$track_id.'" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>';
            echo $iframe;
        } else {
>>>>>>> 75757fd703b0a15ecac216fcb7e567ead4dfc1e9

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
                $results = $api->search($search_query, 'artist');
                break;

            case 'album':
                $results = $api->search($search_query, 'album');
                break;

            case 'track':
                $results = $api->search($search_query, 'track');
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
<<<<<<< HEAD



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
=======
}}
?>

>>>>>>> 75757fd703b0a15ecac216fcb7e567ead4dfc1e9
