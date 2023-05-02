<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User list</title>
</head>
<body>
        <?php if (is_array($emails)) { ?>
            <ol>
                <h3>List user and email:</h3>
                <?php foreach ($emails as $email) { ?>
                    <li>User this email = <?php echo $email ?></li>
                <?php } ?>
            </ol>
        <?php } else { ?>
            <p>User this email = <?= $emails ?></p>
        <?php } ?>
</body>
</html>