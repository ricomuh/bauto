<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Post</h1>
            <a href="<?= route('crud/post/create') ?>" class="btn btn-primary">Tambah</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Slug</th>
                        <th>Isi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $key => $post) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $post->title ?></td>
                            <td><?= $post->slug ?></td>
                            <td><?= $post->content ?></td>
                            <td>
                                <a href="<?= route('crud/post/' . $post->slug) ?>" class="btn btn-info">Detail</a>
                                <a href="<?= route('crud/post/' . $post->slug . '/edit') ?>" class="btn btn-warning">Edit</a>
                                <form action="<?= route('crud/post/' . $post->slug . '/destroy') ?>" method="POST" style="display: inline-block">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>