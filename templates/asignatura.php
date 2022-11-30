<?php $this->layout('layouts/default', ['title' => $title]) ?>

<?php $this->start('header') ?>
    <p class="title"><?=$this->e($asignatura->nombre)?></p>
<?php $this->stop() ?>

<?=$this->insert('components/search_client')?>
<?php foreach($asignatura->grupos as $index => $grupo): ?>
    <p class="title has-text-centered">Grupo <?=$this->e($grupo->nombre)?></p>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach($grupo->profesores as $profesor): ?>
            <div class="column item is-narrow" data-name="<?=$this->e($profesor->nombre)?>">
                <?=$this->insert('components/card', [
                    'name' => $profesor->nombre,
                    'url' => $this->url('/profesores', ['email' => $profesor->email])
                ])?>
            </div>
        <?php endforeach ?>
    </div>
    <?php if ($index !== count($asignatura->grupos) - 1): ?>
        <hr />
    <?php endif ?>
<?php endforeach ?>
