<?php
require_once(__DIR__.'/hotwords.php');
// For any word, we can get the stem using Porter stemmer Algorithm.
// $stem=HotWords::wordNormalize($anyword);

$text=isset($_REQUEST['text'])?$_REQUEST['text']:'';

$words=preg_split('/[^A-Za-z]+/', $text);

foreach ($words as $word) {
	$lower_word=strtolower($word);
	$stem=HotWords::wordNormalize($lower_word);
	echo $word . " -> " . $lower_word . PHP_EOL;
}

?>