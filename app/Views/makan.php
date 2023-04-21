<h1>
    Test Broo
</h1>
<article>
    <?php foreach ($filtered as $student) : ?>
        <h2>
            <?= $student['name'] ?>
        </h2>
        <p>
            <?= $student['age'] ?>
        </p>
    <?php endforeach; ?>
</article>
<?= request()->baseURL() ?>