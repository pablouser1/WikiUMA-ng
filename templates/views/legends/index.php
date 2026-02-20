<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \Illuminate\Support\Collection<\App\Models\Legend> $legends
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Leyendas',
    'uri' => $uri,
    'withSearch' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Leyendas',
]) ?>

<section class="section">
    <?php $this->insert('partials/search/client') ?>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach ($legends as $legend): ?>
            <div class="column item is-narrow" data-name="<?= $this->e($legend->full_name) ?>">
                <?php $this->insert('partials/card', [
                    'name' => $legend->full_name,
                    'url' => $this->url("/legends/{$legend->id}"),
                ]) ?>
            </div>
        <?php endforeach ?>
    </div>
</section>
