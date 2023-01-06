<?php $this->layout('layouts/admin', ['title' => 'Reseñas']) ?>

<?php $this->start('header') ?>
<p class="title">Reseñas</p>
<?php $this->stop() ?>

<div class="container">
    <?php $this->insert('components/sort') ?>
    <?php foreach($reviews as $review): ?>
        <div class="box mt-4">
            <?=$this->insert('components/review', [
                'id' => $review->id,
                'username' => $review->username,
                'message' => $review->message,
                'note' => $review->note,
                'votes' => $review->votes,
            ])?>
            <div class="buttons">
                <a class="button is-info" href="<?=$this->url_to($review->data, $review->subject)?>">Ver en contexto</a>
                <a class="button is-danger" href="<?=$this->url('/reviews/' . $review->id . '/delete')?>">Eliminar reseña</a>
            </div>
        </div>
    <?php endforeach ?>
    <?php if (empty($reviews)): ?>
        <p class="has-text-centered">No hay reseñas</p>
    <?php endif ?>
</div>
