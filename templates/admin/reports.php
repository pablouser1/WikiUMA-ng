<?php $this->layout('layouts/admin', ['title' => 'Reportes']) ?>

<?php $this->start('header') ?>
<p class="title">Reportes</p>
<?php $this->stop() ?>

<div class="container">
    <?php if (count($reports) > 0): ?>
    <div class="columns is-multiline is-centered is-vcentered">
        <?php foreach($reports as $report): ?>
        <div class="column is-narrow">
            <div class="box">
                <?=$this->insert('components/review', [
                    'id' => $report->reviewId,
                    'username' => $report->username,
                    'message' => $report->message,
                    'note' => $report->note,
                    'votes' => $report->votes,
                    'tags' => $report->tags
                ])?>
                <p>Razón: <?=$this->e($report->reason)?></p>
                <div class="buttons">
                    <a class="button is-warning" href="<?=$this->url('/reports/' . $report->reportId . '/delete')?>">Ignorar</a>
                    <a class="button is-danger" href="<?=$this->url('/reviews/' . $report->reviewId . '/delete')?>">Eliminar review</a>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <?php else: ?>
    <p class="has-text-centered">No hay reportes</p>
    <?php endif ?>
</div>
