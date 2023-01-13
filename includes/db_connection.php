<?php

function connect_to_db() {

    $db = new PDO('sqlite:database.db');

    /*
    ** We recreate tables in case they were drop due to a wrong manipulation 
    ** or if the user did not run the script.
    */
    
    create_tables_if_not_exist($db);

    return $db;
}

function create_tables_if_not_exist($db) {
    $query = "
    CREATE TABLE IF NOT EXISTS artist (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        uri TEXT NOT NULL,
        image_uri TEXT NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    ";

    $db->exec($query);

    $query = "
    CREATE TABLE IF NOT EXISTS album (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        artist_id INTEGER,
        name TEXT NOT NULL,
        uri TEXT NOT NULL,
        image_uri TEXT NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (artist_id) -- Add foreign key
            REFERENCES artist (id)
                ON DELETE CASCADE
                ON UPDATE NO ACTION
    );
    ";

    $db->exec($query);

    $query = "
    CREATE TABLE IF NOT EXISTS track (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        artist_id INTEGER,
        name TEXT NOT NULL,
        uri TEXT NOT NULL,
        image_uri TEXT NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (artist_id) -- Add foreign key
            REFERENCES artist (id)
                ON DELETE CASCADE
                ON UPDATE NO ACTION
    );
    ";

    $db->exec($query);

    $query = "
    CREATE TABLE IF NOT EXISTS playlist (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        uri TEXT NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    ";

    $db->exec($query);

    $query = "
    CREATE TABLE IF NOT EXISTS playlist_track (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        playlist_id INTEGER NOT NULL,
        track_id INTEGER NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (playlist_id) -- Add foreign keys
            REFERENCES playlist (id)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
        FOREIGN KEY (track_id)
            REFERENCES track (id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
    );
    ";

    $db->exec($query);

    $query = null;
}