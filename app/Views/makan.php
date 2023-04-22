<?= $this->section('title', 'Test') ?>
<?= $this->section('content') ?>
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
<?= $this->endSection() ?>

<?= $this->push('scripts') ?>
<h2>Script 1</h2>
<?= $this->endPush() ?>

<?= $this->push('scripts') ?>
<h2>Script 2</h2>
<?= $this->endPush() ?>

<?= $this->extend('layout') ?>