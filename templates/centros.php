<?php $this->layout('layouts/default', ['title' => 'Centros']) ?>

<?php $this->start('header') ?>
    <p class="title">Centros</p>
<?php $this->stop() ?>

<?=$this->insert('components/client_search')?>
<div class="columns is-centered is-vcentered is-multiline">
    <?php foreach($centros as $centro): ?>
        <?php if ($centro->alfilws !== ""): ?>
            <div class="column item is-narrow" data-name="<?=$this->e($centro->nombre)?>">
                <?=$this->insert('components/card', [
                    'name' => $centro->nombre,
                    'url' => $this->url('/centros/titulaciones/' . $centro->alfilws)
                ])?>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>
