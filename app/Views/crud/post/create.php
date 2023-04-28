<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <form action="<?= route('crud/post/store') ?>" method="POST">
        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
        <br>
        <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="Post Content"></textarea>
        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<?= $this->endSection() ?>