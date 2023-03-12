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
