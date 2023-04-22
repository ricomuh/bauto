<h1>
    <?= $this->yield('title', 'Default Title') ?>
</h1>
<p>Wrapper Up</p>
<?= $this->yield('content') ?>
<p>Wrapper Down</p>
<?= $this->yield('scripts') ?>