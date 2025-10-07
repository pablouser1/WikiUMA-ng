<?php $this->layout('layouts/default', [
    'title' => 'Plan',
    'withSearch' => true,
]) ?>

<?php $this->insert('partials/hero', ['title' => 'Plan']) ?>

<section class="section">
    <?php $this->insert('partials/search-client') ?>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach ($cursos as $i => $curso): ?>
            <div class="column is-narrow">
                <?php
                $this->insert('partials/panel', [
                    'title' => "{$i}º año",
                    'items' => array_map(fn (object $asignatura) => (object) [
                        'name' => $asignatura->nombre,
                        'url' =>  $this->url('/planes/' . $plan_id . '/asignaturas/' . $asignatura->codigo),
                    ], $curso)
                ]);
                ?>
            </div>
        <?php endforeach ?>
    </div>
</section>
