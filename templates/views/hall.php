<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \App\Dto\StatsData<\UMA\Models\Profesor>[] $hall
 */
?>

<?php $this->layout('layouts/hero', [
    'title' => 'Salón de la fama',
    'uri' => $uri,
]) ?>

<div class="has-text-centered">
    <p class="title">Salón de la fama</p>
    <?php foreach ($hall as $item): ?>
        <div class="card">
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4"><?= $this->e($item->for->nombre) ?></p>
                        <?php if (isset($item->for->departamentos[0])): ?>
                            <p class="subtitle is-6"><?= $this->e($item->for->departamentos[0][0]->nombre) ?></p>
                        <?php endif ?>
                    </div>
                </div>

                <div class="field is-grouped is-grouped-multiline is-grouped-centered">
                    <?php $this->insert('partials/stats/single', ['title' => 'Nº de valoraciones', 'value' => $item->total]) ?>
                    <?php $this->insert('partials/stats/single', ['title' => 'Nota media', 'value' => $item->avg, 'withColor' => true]) ?>
                </div>
            </div>
            <footer class="card-footer">
              <a href="<?= $this->url('/profesores', ['email' => $this->encrypt($item->for->email)]) ?>" class="card-footer-item">Ver perfil</a>
            </footer>
        </div>
    <?php endforeach ?>
</div>
