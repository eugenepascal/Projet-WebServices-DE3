-- Drop tables
DROP TABLE IF EXISTS artist;
DROP TABLE IF EXISTS album;
DROP TABLE IF EXISTS track;
DROP TABLE IF EXISTS playlist;

DROP TABLE IF EXISTS playlist_track;


-- Create tables
CREATE TABLE IF NOT EXISTS artist (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    uri TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS album (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER,
    name TEXT NOT NULL,
    uri TEXT NOT NULL,,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    FOREIGN KEY (artist_id) -- Add foreign key
        REFERENCES artist (id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS track (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER,
    name TEXT NOT NULL,
    uri TEXT NOT NULL,,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    FOREIGN KEY (artist_id) -- Add foreign key
        REFERENCES artist (id)
            ON DELETE CASCADE
            ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS playlist (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    uri TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS playlist_track (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    playlist_id INTEGER NOT NULL,
    track_id INTEGER NOT NULL,,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    FOREIGN KEY (playlist_id) -- Add foreign keys
        REFERENCES playlist (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    FOREIGN KEY (track_id)
        REFERENCES track (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
);