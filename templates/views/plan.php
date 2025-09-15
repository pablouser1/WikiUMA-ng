<?php $this->layout('layouts/default', ['title' => 'Plan', 'withSearch' => true]) ?>

<?php $this->insert('partials/hero', ['title' => 'Plan']) ?>

<section class="section">
    <?php $this->insert('partials/search-client') ?>
    <?php foreach ($cursos as $i => $curso): ?>
        <div class="block">
            <p class="title has-text-centered"><?= $this->e($i) ?>º año</p>
            <div class="columns is-centered is-vcentered is-multiline">
                <?php foreach ($curso as $asignatura): ?>
                    <div class="column item is-narrow" data-name="<?= $this->e($asignatura->nombre) ?>">
                        <?php $this->insert('partials/card', [
                            'name' => $asignatura->nombre,
                            'url' => $this->url('/planes/' . $plan_id . '/asignaturas/' . $asignatura->codigo),
                        ]) ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
</section>
