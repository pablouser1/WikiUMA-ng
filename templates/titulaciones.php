<?php $this->layout('layouts/default', ['title' => $title]) ?>

<?php $this->start('header') ?>
<p class="title">Titulaciones</p>
<p class="subtitle"><?=$this->e($titulaciones[0]->CENTRO)?></p>
<?php $this->stop() ?>

<?=$this->insert('components/client_search')?>
<div class="columns is-centered is-vcentered is-multiline">
    <?php foreach($titulaciones as $titulacion): ?>
        <div class="column item is-narrow" data-name="<?=$this->e($titulacion->PLAN)?>">
            <?=$this->insert('components/card', [
                'name' => $titulacion->PLAN,
                'url' => $this->url('/plan/' . $titulacion->COD_PLAN)
            ])?>
        </div>
    <?php endforeach ?>
</div>
