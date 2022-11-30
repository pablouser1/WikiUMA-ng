<?php $this->layout('layouts/default', ['title' => $title]) ?>

<?php $this->start('header') ?>
<p class="title"><?= $this->e($profesor->nombre) ?></p>
<?php $this->stop() ?>

<section class="hero is-small is-info">
    <div class="hero-body">
        <div class="container has-text-centered">
            <p class="title">Resumen</p>
            <?php if ($stats->total !== 0) : ?>
                <div class="columns is-centered is-vcentered is-mobile">
                    <div class="column is-narrow">
                        <p>Media</p>
                        <div class="note has-background-<?=$this->color($stats->med)?>">
                            <p><?= $this->e($stats->med) ?></p>
                        </div>
                    </div>
                    <div class="column is-narrow">
                        <p>Votos totales: <?= $this->e($stats->total) ?></p>
                        <p>Nota mínima: <?= $this->e($stats->min) ?></p>
                        <p>Nota máxima: <?= $this->e($stats->max) ?></p>
                    </div>
                </div>
            <?php else : ?>
                <p>No hay ningún voto. ¡Se el primero en votar!
            <?php endif ?>
        </div>
    </div>
</section>
<div class="container">
    <div class="box">
        <p class="title has-text-centered">Escribe tu reseña</p>
        <form action="<?=$this->url('/reviews', ['email' => $profesor->email])?>" method="POST">
            <div class="field">
                <label class="label">Reseña</label>
                <div class="control">
                    <textarea name="message" class="textarea"></textarea>
                </div>
            </div>
            <div class="field">
                <label class="label">Nombre de usuario (opcional)</label>
                <div class="control">
                    <input name="username" class="input" type="text" autocomplete="off" />
                </div>
            </div>
            <div class="field">
                <label class="label">Valoración (sobre 10)</label>
                <div class="control">
                    <input name="note" class="input" type="number" min="0" max="10" required />
                </div>
            </div>
            <div class="field has-addons">
                <div class="control">
                    <figure class="figure">
                        <img src="<?= $this->url('/captcha') ?>" />
                    </figure>
                </div>
                <div class="control">
                    <input name="captcha" type="text" class="input" placeholder="Escribe el Captcha" required />
                </div>
            </div>
            <div class="field">
                <label class="checkbox">
                    <input name="accepted" type="checkbox" required>
                    He leído y acepto los <a href="<?= $this->url('/legal')?>">términos de uso</a>
                </label>
            </div>
            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-success">Enviar</button>
                </div>
            </div>
        </form>
    </div>
    <?php if ($stats->total !== 0): ?>
        <div class="box">
            <p class="title has-text-centered">Valoraciones</p>
            <?php foreach ($reviews as $review): ?>
                <?=$this->insert('components/review', [
                    'id' => $review->id,
                    'username' => $review->username,
                    'message' => $review->message,
                    'note' => $review->note,
                    'votes' => $review->votes,
                    'controls' => true
                ])?>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
