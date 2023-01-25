<?php $this->layout('layouts/default', ['title' => 'Añadir reporte']) ?>

<?php $this->start('header') ?>
<p class="title">Informar sobre comentario</p>
<?php $this->stop() ?>

<div class="container">
    <p>Se va a informar a la administración sobre el siguiente comentario:</p>
    <div class="box">
        <?=$this->insert('components/review', [
            'id' => $review->id,
            'username' => $review->username,
            'message' => $review->message,
            'note' => $review->note,
            'votes' => $review->votes,
            'tags' => $review->tags
        ])?>
    </div>
    <form action="<?=$this->url('/reports/new/' . $review->id)?>" method="POST">
        <div class="field">
            <label class="label">Motivo</label>
            <div class="control">
                <textarea name="reason" class="textarea"></textarea>
            </div>
        </div>
        <?= $this->insert('components/captcha') ?>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-success">Enviar</button>
            </div>
        </div>
    </form>
</div>
