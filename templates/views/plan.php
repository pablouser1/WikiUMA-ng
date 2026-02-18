<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var int $plan_id
 * @var array $cursos
 * @todo Consider adding better title
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Plan',
    'uri' => $uri,
    'withSearch' => true,
]) ?>

<?php $this->insert('partials/hero', ['title' => 'Plan']) ?>

<section class="section">
    <?php $this->insert('partials/search-client') ?>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach ($cursos as $i => $curso): ?>
            <div class="column is-narrow">
                <?php $this->insert('partials/panel', [
                    'title' => "{$i}º año",
                    'items' => array_map(fn (object $asignatura) => (object) [
                        'name' => $asignatura->nombre,
                        'url' =>  $this->url('/planes/' . $plan_id . '/asignaturas/' . $asignatura->codigo),
                    ], $curso)
                ]) ?>
            </div>
        <?php endforeach ?>
    </div>
</section>
