<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \Illuminate\Support\Collection<\App\Models\Exclusion> $exclusions
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Exclusiones',
    'uri' => $uri,
    'withForm' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Exclusiones',
]) ?>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/exclusions/index', [
            'exclusions' => $exclusions,
            'uri' => $uri,
            'query' => $query,
        ]) ?>
    </div>
</section>
