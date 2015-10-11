<?php

require_once 'db.php';
$exercise = ORM::for_table('exercises')->find_one($_GET['id']);
switch ($_GET['what']) {
    case 'votes':
        $exercise->votes = null;
        $exercise->save();
        break;
    case 'exercise':
        $exercise->delete();
        break;
}

header('Location: index.php?admin');
