<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var int $titulacion_id
 * @var \UMA\Models\Titulacion $titulacion
 * @var array $cursos
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Plan',
    'uri' => $uri,
    'withSearch' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Plan',
    'subtitle' => $titulacion?->plan,
]) ?>

<section class="section">
    <?php $this->insert('partials/search-client') ?>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach ($cursos as $i => $curso): ?>
            <div class="column is-narrow">
                <?php $this->insert('partials/panel', [
                    'title' => "{$i}º año",
                    'items' => array_map(fn (object $asignatura) => (object) [
                        'name' => $asignatura->nombre,
                        'url' =>  $this->url('/planes/' . $titulacion_id . '/asignaturas/' . $asignatura->codigo),
                    ], $curso)
                ]) ?>
            </div>
        <?php endforeach ?>
    </div>
</section>
