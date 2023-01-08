<?php $this->layout('layouts/default', ['title' => 'Añadir reporte']) ?>

<?php $this->start('header') ?>
<p class="title">Reporte a comentario</p>
<?php $this->stop() ?>

<div class="container">
    <p>Se va a reportar el siguiente comentario:</p>
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
            <label class="label">Razón</label>
            <div class="control">
                <textarea name="reason" class="textarea"></textarea>
            </div>
        </div>
        <div class="field has-addons">
            <div class="control">
                <figure class="figure">
                    <img src="<?=$this->url('/captcha')?>" />
                </figure>
            </div>
            <div class="control">
                <input name="captcha" type="text" class="input" placeholder="Escribe el Captcha" />
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-success">Enviar</button>
            </div>
        </div>
    </form>
</div>
