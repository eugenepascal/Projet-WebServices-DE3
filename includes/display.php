<?php

require_once 'vendor/autoload.php';

function displayArtist($results) {
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
                                    <img src="<?php echo $artist->images[0]->url; ?>" alt="<?php echo $artist->name; ?>">
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
}

function displayAlbum($results) {
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
}

function displayTrack($results) {
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
}