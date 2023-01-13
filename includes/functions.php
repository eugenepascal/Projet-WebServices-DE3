<?php

// Authorization Using the Client Credentials Flow
require_once 'vendor/autoload.php';

// Other files from projet
require_once 'display.php';
require_once 'db_connection.php';

// Hook
add_action("wp_head", "EY_MR_SpotifySearchBar");
add_action("wp_head", "EY_MR_SpotifySearch");

// Add search bar
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

function EY_MR_SpotifySearch() {
    // No need to execute anything if no request was received.
    if (!empty($_GET)) {

        // Open SpotifyAPI Session for later requests
        $session = new SpotifyWebAPI\Session(
            '8d4e36b37abf4965917bc9fd437ab54d',
            '196a5af2d5c544fd8c612e42190cb86b'
        );
        
        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        // Either you load a track to play, either you request the DB or Spotify API
        if(isset($_GET['track_id'])) {
        
            $track_id = $_GET['track_id'];
		    $iframe = '<iframe src="https://open.spotify.com/embed/track/'.$track_id.'" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>';
            echo $iframe;

        } else {

            $db = connect_to_db();

            if(isset($_GET['search_type']) and isset($_GET['search'])) {
                $search_type = $_GET['search_type'];
                $search_query = $_GET['search'];
            }

            switch($search_type) {

                case 'artist':
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
                    displayArtist($results);
                    break;
                case 'album':
                    displayAlbum($results);
                    break;
                case 'track':
                    displayTrack($results);
                    break;
            }
        }
    }
}


// Admin control panel

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