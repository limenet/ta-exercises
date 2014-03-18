<?php
require_once 'db.php';
$taList = array();
$subjectList = array();
$entries = ORM::for_table('exercises')->order_by_desc('ex_set')->find_many();
foreach ($entries as $key => $exercise) {
	$taHash = substr(sha1($exercise->ta), 0, 8);
	$taList[$taHash] = $exercise->ta;
	$subjectList[] = $exercise->subject;
	$entries[$key]->taHash = $taHash;
}
$taList = array_unique($taList);
$subjectList = array_unique($subjectList);
?>