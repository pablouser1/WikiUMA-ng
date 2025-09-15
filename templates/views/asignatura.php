<?php $this->layout('layouts/default', [
    'title' => $asignatura->nombre,
    'withSearch' => true,
    'withReviews' => true,
])
?>

<?php $this->insert('partials/hero', [
    'title' => $asignatura->nombre,
    'subtitle' => "{$asignatura->curso} año - {$asignatura->cuatrimestre} cuatrimestre"
])
?>

<section class="section">
    <div class="block">
        <div class="container">
            <p class="title has-text-centered">Profesores</p>
            <?=$this->insert('partials/search-client')?>
            <?php foreach ($asignatura->grupos as $grupo): ?>
                <p class="title has-text-centered">Grupo <?= $this->e($grupo->nombre) ?></p>
                <div class="columns is-centered is-vcentered is-multiline">
                    <?php foreach ($grupo->profesores as $profesor): ?>
                        <div class="column item is-narrow" data-name="<?= $this->e($profesor->nombre) ?>">
                            <?= $this->insert('partials/card', [
                                'name' => $profesor->nombre,
                                'url' => $this->url('/profesores', ['email' => $profesor->email])
                            ]) ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="block">
</section>
