<div class="box">
    <p class="title has-text-centered">Escribe tu reseña</p>
    <form action="<?= $this->url('/reviews', ['data' => $data, 'subject' => $subject]) ?>" method="POST">
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
                He leído y acepto los <a href="<?= $this->url('/legal') ?>">términos de uso</a>
            </label>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-success">Enviar</button>
            </div>
        </div>
    </form>
</div>
