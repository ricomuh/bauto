<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $code . ' - ' . $message ?></title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f1f1f1;
        }

        h1 {
            font-size: 5rem;
            text-align: center;
            color: #333;
        }
    </style>
</head>

<body>
    <h1>
        <?= $code . ' - ' . $message ?>
    </h1>
</body>

</html>