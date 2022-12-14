<?php $this->layout('layouts/default', ['title' => $title]) ?>

<?php $this->start('header') ?>
    <p class="title"><?=$this->e($asignatura->nombre)?></p>
    <p class="subtitle"><?= $this->e($asignatura->curso) ?>º año - <?= $this->e($asignatura->cuatrimestre) ?>º cuatrimestre</p>
    <small>
        <a target="_blank" rel="nofollow" href="<?= $this->e($asignatura->programa) ?>">
            <?= $this->insert('components/icon/main', ['icon' => 'eye', 'text' => 'Ver programa']) ?>
        </a>
    </small>
<?php $this->stop() ?>

<div class="block">
    <?= $this->insert('components/summary', [
        'stats' => $stats
    ]) ?>
</div>

<?php if (count($reviews) > 0): ?>
    <div class="block">
        <?php $this->insert('components/sort') ?>
    </div>
    <div class="block">
        <div class="container">
            <?php foreach ($reviews as $review): ?>
                <div class="box">
                    <?=$this->insert('components/review', [
                        'id' => $review->id,
                        'username' => $review->username,
                        'message' => $review->message,
                        'note' => $review->note,
                        'votes' => $review->votes,
                        'controls' => true,
                        'voting' => true
                    ])?>
                </div>
            <?php endforeach ?>
            <?= $this->insert('components/pagination', ['count' => count($reviews)]) ?>
        </div>
    </div>
<?php endif ?>

<hr />

<div class="block">
    <div class="container">
        <p class="title has-text-centered">Profesores</p>
        <?=$this->insert('components/search_client')?>
        <?php foreach($asignatura->grupos as $grupo): ?>
            <p class="title has-text-centered">Grupo <?=$this->e($grupo->nombre)?></p>
            <div class="columns is-centered is-vcentered is-multiline">
                <?php foreach($grupo->profesores as $profesor): ?>
                    <div class="column item is-narrow" data-name="<?=$this->e($profesor->nombre)?>">
                        <?=$this->insert('components/card', [
                            'name' => $profesor->nombre,
                            'url' => $this->url('/profesores', ['email' => $profesor->email])
                        ])?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endforeach ?>
    </div>
</div>
<div class="block">
    <div class="container">
        <?= $this->insert('components/review_add', ['data' => $asignatura->cod_asig . ';' . $plan_id, 'subject' => 1]) ?>
    </div>
</div>
