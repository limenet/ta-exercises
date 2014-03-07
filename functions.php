<?php
function parseExString($in){
	$out = array();
	foreach (explode(',', $in) as $ex) {
		$exNo = $ex;
		$exPartital = NULL;
		if(strrpos($ex, ':') !== false){
			$exParts = explode(':', $ex);
			$exNo = $exParts[0];
			$exBounds = explode('-', $exParts[1]);
			$exPartital = range($exBounds[0], $exBounds[1]);
		}
		$out[$exNo] = $exPartital;
	}
	return $out;
}
?>