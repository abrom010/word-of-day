<?php
require_once('login.php');

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die($connection->connect_error);

$query = "SELECT * FROM words ORDER BY id DESC LIMIT 1";
$result = $connection->query($query);

if($result->num_rows==0) die('COULDN\'T FIND A WORD!');

$row = $result->fetch_array(MYSQLI_ASSOC);

$word = $row['word'];
$example = $row['example'];
$word_translation = $row['word_translation'];
$example_translation = $row['example_translation'];

$connection->close()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Word of the Day</title>
    <meta name="viewport" content="1800" http-equiv="refresh">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

    <div class="the-container">
        <div>
            <h1>Palabra del dia</h1>
            <h2><?php echo $word ?></h2>
            <p><?php echo $example ?></p>
            <h2><?php echo $word_translation ?></h2>
            <p><?php echo $example_translation ?></p>
        </div>
    </div>

<script src="script.js"></script>
</body>
</html>