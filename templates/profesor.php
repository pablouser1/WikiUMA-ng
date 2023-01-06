<?php $this->layout('layouts/default', ['title' => $title]) ?>

<?php $this->start('header') ?>
<p class="title"><?= $this->e($profesor->nombre) ?></p>
<?php $this->stop() ?>

<div class="block">
    <?= $this->insert('components/summary', [
        'stats' => $stats
    ]) ?>
</div>

<div class="block">
    <div class="container">
        <?php if (count($reviews) > 0): ?>
            <?php $this->insert('components/sort', ['params' => ['email' => $profesor->email]]) ?>
            <?php foreach ($reviews as $review): ?>
                <div class="box">
                    <?= $this->insert('components/review', [
                        'id' => $review->id,
                        'username' => $review->username,
                        'message' => $review->message,
                        'note' => $review->note,
                        'votes' => $review->votes,
                        'controls' => true,
                        'voting' => true
                    ]) ?>
                </div>
            <?php endforeach ?>
            <?= $this->insert('components/pagination', ['count' => count($reviews)]) ?>
        <?php endif ?>
        <?= $this->insert('components/review_add', ['data' => $profesor->email, 'subject' => 0]) ?>
    </div>
</div>
