<?php $this->layout('layouts/default', ['title' => $title]) ?>

<?php $this->start('header') ?>
    <p class="title">Plan <?= $this->e($plan_id) ?></p>
<?php $this->stop() ?>

<?=$this->insert('components/search_client')?>
<?php foreach ($cursos as $i => $curso): ?>
    <div class="block">
        <p class="title has-text-centered"><?=$this->e($i)?>º año</p>
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
    </div>
<?php endforeach ?>
