<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <form action="<?= route('crud/post/' . $post->slug . '/update') ?>" method="POST">
        <input type="text" name="title" id="title" class="form-control" value="<?= $post->title ?>">
        <br>
        <textarea name="content" id="content" cols="30" rows="10" class="form-control"><?= $post->content ?></textarea>
        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<?= $this->endSection() ?>