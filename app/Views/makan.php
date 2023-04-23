<?= $e->extend('layout') ?>

<?= $e->section('title', 'Makanan') ?>
<?= $e->section('content') ?>
<h2>Daftar Makanan</h2>
<ul>
    <li>Nasi Goreng</li>
    <li>Nasi Uduk</li>
    <li>Nasi P
        adang</li>
    <li>Nasi Kuning</li>
</ul>
<?= $e->endSection() ?>
<?= $e->push('scripts') ?>
<script>
    console.log('Ini adalah script untuk halaman makanan');
</script>
<?= $e->endPush() ?>