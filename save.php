<?php

require_once 'db.php';
$exercise = ORM::for_table('exercises')->find_one($_GET['id']);
$rankings = array('green' => 0, 'orange' => 0, 'red' => 0);
if (empty($exercise->votes)){
    $votes = json_decode($exercise->exercises, true);
    foreach ($votes as $key => $value) {
        if(is_array($value)){
            foreach ($value as $key2 => $value2) {
                $votes[$key][$value2] = $rankings;
                unset($votes[$key][$key2]);
            }
        }else{
            $votes[$key] = $rankings;
        }
    }
}else{
    $votes = json_decode($exercise->votes, true);
}
$data = [];
foreach ($_POST as $key => $value) {
    if(strpos($key, '-') !== false){
        $t = explode('-', $key);
        $votes[$t[0]][$t[1]][$value]++;
    }else{
        $votes[$key][$value]++;
    }
}
$exercise->votes = json_encode($votes);
$exercise->save();

header('Location: index.php');
