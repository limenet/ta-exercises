<?php

require_once 'db.php';
$source = ORM::for_table('exercises')->where('subject', $_POST['subject'])->where('ex_set', $_POST['ex_set'])->where('ta', $_POST['source-ta'])->find_one();
//var_dump($source);
foreach (explode(',', $_POST['destination-ta']) as $destinationTa) {
    $destinationTa = trim($destinationTa);
    $destination = ORM::for_table('exercises')->create();
    foreach ($source->as_array() as $key => $value) {
        if (!in_array($key, ['id', 'ta', 'votes'])) {
            $destination->$key = $value;
        }
    }
    $destination->ta = $destinationTa;
    $destination->save();
}
header('Location: index.php?admin');
