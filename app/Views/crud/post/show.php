<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <!-- showing the detail of post, not iterate them -->
    <h2><?= $post->title ?></h2>
    <i>
        <small>
            <?= $post->created_at ?>
        </small>
        <a href="<?= route('crud/post/' . $post->slug . '/edit') ?>">Edit</a>
    </i>

    <p><?= $post->content ?></p>
</div>
<?= $this->endSection() ?>