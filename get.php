<?php
require_once 'db.php';
$taList = array();
$subjectList = array();
$entries = ORM::for_table('exercises')->find_many();
foreach ($entries as $exercise) {
	$taList[] = $exercise->ta;
	$subjectList[] = $exercise->subject;
}
$taList = array_unique($taList);
$subjectList = array_unique($subjectList);
$output = array($taList);
?>