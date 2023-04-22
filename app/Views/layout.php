<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->yield('title', 'Aplikasi Rico') ?></title>
    <?= google_fonts([
        'Poppins' =>
        ['as' => 'h1', 'weight' => [400, 700], 'italic' => true],
        'Roboto' =>
        ['as' => 'h2', 'weight' => [400, 700], 'italic' => true]
    ]) ?>
</head>

<body>
    <header>
        <h1><?= $this->yield('title', 'Aplikasi Rico') ?></h1>
    </header>
    <main>
        <?= $this->yield('content') ?>
    </main>
    <footer>
        Copyrigth <?= date('Y') ?> - Aplikasi Rico
    </footer>
    <?= $this->yield('scripts') ?>
</body>

</html>