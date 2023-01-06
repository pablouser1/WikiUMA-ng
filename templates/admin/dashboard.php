<?php $this->layout('layouts/admin', ['title' => 'Panel de Control']) ?>

<?php $this->start('header') ?>
<p class="title">Panel de Control</p>
<?php $this->stop() ?>

<div class="container">
    <?= $this->insert('components/stats', ['stats' => $stats]) ?>
</div>
