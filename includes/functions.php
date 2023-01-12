<?php

// Authorization Using the Client Credentials Flow

require 'vendor/autoload.php';

// Hook
add_action("wp_head", "SpotifySearchBar");
add_action("wp_head", "SpotifySearch");

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
