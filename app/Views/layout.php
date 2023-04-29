<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->yield('title', 'Bauto Framework') ?></title>
    <?= google_fonts([
        'Poppins' =>
        ['as' => 'h1', 'weight' => [400, 700], 'italic' => true],
        'Roboto' =>
        ['as' => 'h2', 'weight' => [400, 700], 'italic' => true]
    ]) ?>
</head>

<body>
    <header>
        <h1><?= $e->yield('title', 'Bauto Framework') ?></h1>
    </header>
    <main>
        <?= $e->yield('content') ?>
    </main>
    <footer>
        Copyrigth &copy; <?= date('Y') ?> - Bauto Framework
    </footer>
    <?= $e->yield('scripts') ?>
</body>

</html>