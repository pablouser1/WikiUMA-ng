<?php $this->layout('layouts/default', ['title' => $title]) ?>

<?php $this->start('header') ?>
<p class="title"><?= $this->e($profesor->nombre) ?></p>
<?php $this->stop() ?>

<?= $this->insert('components/summary', [
    'stats' => $stats
]) ?>

<div class="container">
    <?= $this->insert('components/review_add', ['data' => $profesor->email, 'subject' => 0]) ?>
    <?php if (count($reviews) > 0): ?>
        <div class="box">
            <?php foreach ($reviews as $review): ?>
                <?=$this->insert('components/review', [
                    'id' => $review->id,
                    'username' => $review->username,
                    'message' => $review->message,
                    'note' => $review->note,
                    'votes' => $review->votes,
                    'controls' => true,
                    'voting' => true
                ])?>
            <?php endforeach ?>
            <?= $this->insert('components/pagination', ['count' => count($reviews)]) ?>
        </div>
    <?php endif ?>
</div>
