<?php

// Authorization Using the Client Credentials Flow

require 'vendor/autoload.php';

// Hook
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


function SpotifySearchBar() {
    echo "
    <center>
    <form action=\"\" method=\"GET\">
    <input name=\"search\" id=\"search\" type=\"text\" placeholder=\"Search on Spotify\">
    <input id=\"submit\" type=\"submit\" value=\"Search\">
    </form>
    </center>
    ";
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

function SpotifySearch() {
    if (!empty($_GET)) {
        $session = new SpotifyWebAPI\Session(
            '8d4e36b37abf4965917bc9fd437ab54d',
            '196a5af2d5c544fd8c612e42190cb86b'
        );
        
        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $results = $api->search($_GET["search"], 'album');


        ?>

        <style>.album img {
            height: 100px;
        }

        </style>

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
                                <td><img src="<?php echo $album->images[0]->url; ?>" alt="<?php echo $album->name; ?>" class="album"></td>
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
