<?php
// importing
require_once('vendor/autoload.php');
require_once('login.php');
require_once('wordnik.php');

use Stichoza\GoogleTranslate\GoogleTranslate;

// connect to database
$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die($connection->connect_error);

// read file and choose a word
$lines = file('3000.txt');
$count = sizeof($lines);
$random = rand(0, $count);
$word = trim($lines[$random]);

// translate word to spanish with google
$translator = new GoogleTranslate();
$translator->setSource('en');
$translator->setTarget('es');

$word_translation = $translator->translate($word);

// get an example for the word with wordnik
$api_url = 'http://api.wordnik.com/v4/';
$options = array(
	'http'=>array(
		'method'=>"GET",
		'header'=>"api_key: " . $api_key
	)
);
$context = stream_context_create($options);
$json = file_get_contents($api_url . "word.json/" . $word . "/topExample", false, $context);
$example = json_decode($json)->text;

// translate example to spanish with google
$example_translation = $translator->translate($example);

// date
$date = date('Y/m/d');

// insert entry into database
$query = "INSERT INTO words (date, word, word_translation, example, example_translation)
VALUES ('$date', '$word', '$word_translation', '" .
	mysqli_real_escape_string($connection, "$example") . "', '" .
	mysqli_real_escape_string($connection, "$example_translation") . "');";

$result = $connection->query($query);
if (!$result) die("Database access failed: " . $connection->error);

// close database
$connection->close();
?>