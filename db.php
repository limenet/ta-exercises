<?php

require_once 'idiorm.php';
require_once 'functions.php';

// Connect to the demo database file
ORM::configure('sqlite:./data.sqlite');
ORM::configure('return_result_sets', true);

// This grabs the raw database connection from the ORM
// class and creates the table if it doesn't already exist.
// Wouldn't normally be needed if the table is already there.
$db = ORM::get_db();
$db->exec('
    CREATE TABLE IF NOT EXISTS exercises (
        id INTEGER PRIMARY KEY,
        subject TEXT,
        ta TEXT,
        ex_set INTEGER,
        exercises TEXT,
        votes TEXT
    );'
);
