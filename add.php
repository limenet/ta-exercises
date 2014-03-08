<?php
require_once 'db.php';
$exercise_set = ORM::for_table('exercises')->create();
$exercise_set->subject = $_POST['subject'];
$exercise_set->ta = $_POST['ta'];
$exercise_set->ex_set = $_POST['ex_set'];
$exercise_set->exercises = json_encode(parseExString($_POST['exercises']));
$exercise_set->save();
header('Location: index.php?admin');
?>