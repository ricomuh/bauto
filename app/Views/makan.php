<?= $this->section('title', 'Makanan') ?>
<?= $this->section('content') ?>
<h2>Daftar Makanan</h2>
<ul>
    <li>Nasi Goreng</li>
    <li>Nasi Uduk</li>
    <li>Nasi Padang</li>
    <li>Nasi Kuning</li>
</ul>
<?= $this->endSection() ?>
<?= $this->push('scripts') ?>
<script>
    console.log('Ini adalah script untuk halaman makanan');
</script>
<?= $this->endPush() ?>

<?= $this->extend('layout') ?>