<div class="box">
    <p class="title has-text-centered">Escribe tu reseña</p>
    <form action="<?= $this->url('/reviews', ['data' => $data, 'subject' => $subject]) ?>" method="POST">
        <div class="field">
            <label class="label">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => 'empty-page']) ?>
                    </span>
                    <span>Reseña</span>
                </span>
            </label>
            <div class="control">
                <textarea name="message" class="textarea"></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => 'user']) ?>
                    </span>
                    <span>Nombre de usuario (opcional)</span>
                </span>
            </label>
            <div class="control">
                <input name="username" class="input" type="text" autocomplete="off" />
            </div>
        </div>
        <div class="field">
            <label class="label">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => 'emoji']) ?>
                    </span>
                    <span>Valoración (sobre 10)</span>
                </span>
            </label>
            <div class="control">
                <input name="note" class="input" type="number" min="0" max="10" step=".01" required placeholder="Escribe tu valoración del 0 al 10" />
            </div>
        </div>
        <?php if (isset($tags) && count($tags) > 0): ?>
            <label class="label">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => 'hashtag']) ?>
                    </span>
                    <span>Etiquetas</span>
                </span>
            </label>
            <div class="field">
                <div class="control">
                    <div class="tags">
                        <?php foreach ($tags as $tag): ?>
                            <span class="tag is-rounded is-<?= $this->tag($tag->type) ?>">
                                <label class="checkbox">
                                    <input name="tags[]" value="<?= $this->e($tag->id) ?>" type="checkbox" />
                                    <?php $this->insert('partials/tag', ['tag' => $tag]) ?>
                                </label>
                            </span>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <div class="field">
            <label class="checkbox">
                <input name="accepted" type="checkbox" required>
                He leído y acepto los <a href="<?= $this->url('/legal') ?>">términos de uso</a>
            </label>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-success">
                    <span class="icon-text">
                        <span class="icon">
                            <?php $this->insert('partials/icon', ['icon' => 'send']) ?>
                        </span>
                        <span>Enviar</span>
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
