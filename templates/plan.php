<?php $this->layout('layouts/default', ['title' => $title]) ?>

<?php $this->start('header') ?>
    <p class="title">Plan</p>
<?php $this->stop() ?>

<?=$this->insert('components/search_client')?>
<?php foreach ($cursos as $index => $curso): ?>
    <p class="title has-text-centered">Año <?=$this->e($index)?></p>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach ($curso as $asignatura): ?>
            <div class="column item is-narrow" data-name="<?=$this->e($asignatura->nombre)?>">
                <?=$this->insert('components/card', [
                    'name' => $asignatura->nombre,
                    'url' => $this->url('/asignaturas/' . $asignatura->codigo . '/' . $plan_id)
                ])?>
            </div>
        <?php endforeach ?>
    </div>
    <?php if ($index !== $duracion): ?>
        <hr />
    <?php endif ?>
<?php endforeach ?>
