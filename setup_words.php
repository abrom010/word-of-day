<?php
require_once('vendor/autoload.php');
require_once('login.php');
require_once('wordnik.php');

use Stichoza\GoogleTranslate\GoogleTranslate;

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die($connection->connect_error);

$lines = file('3000.txt');
$count = sizeof($lines);

$translator = new GoogleTranslate();
$translator->setSource('en');
$translator->setTarget('es');

$api_url = 'http://api.wordnik.com/v4/';
$options = array(
	'http'=> array(
		'method'=>'GET',
		'header'=>'api_key: ' . $api_key
	)
);
$context = stream_context_create($options);

for($i=0; $i<$count; $i++) {
	$random = rand(0, $count);
	$word = trim($lines[$random]);
	$word_translation = $translator->translate($word);
	$json = file_get_contents($api_url . "word.json/" . $word . "/topExample", false, $context);
	$example = json_decode($json)->text;	
	$example_translation = $translator->translate($example);
	$example = substr($example, 0, min(strlen($example), 255));
	$example_translation = substr($example_translation, 0, min(strlen($example_translation), 255));
	$query = "INSERT INTO words (word, word_translation, example, example_translation)
VALUES ('$word', '$word_translation', '" .
        mysqli_real_escape_string($connection, "$example") . "', '" .
	mysqli_real_escape_string($connection, "$example_translation") . "');";	
	
	$result = $connection->query($query);
	if (!$result) die("Database acces failed: " . $connection->error);
	sleep(1);
}

$connection->close();
?>
