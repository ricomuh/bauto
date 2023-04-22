<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $code . ' - ' . $message ?></title>
    <?= google_fonts([
        'Poppins' =>
        ['as' => 'h1', 'weight' => [500]]
    ]) ?>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #333546;
            letter-spacing: 0.4rem;
        }

        h1 {
            font-size: 2rem;
            text-align: center;
            color: #fff;
        }
    </style>
</head>

<body>
    <h1>
        <?= $code . ' - ' . $message ?>
    </h1>
</body>

</html>