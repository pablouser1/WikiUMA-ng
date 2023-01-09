<div class="box">
    <p class="title has-text-centered">Escribe tu reseña</p>
    <?php if ($this->mode_handle(1) ): ?>
        <form action="<?= $this->url('/reviews', ['data' => $data, 'subject' => $subject]) ?>" method="POST">
            <div class="field">
                <label class="label">
                    <?= $this->insert('components/icon', ['icon' => 'file-document', 'text' => 'Reseña']) ?>
                </label>
                <div class="control">
                    <textarea name="message" class="textarea"></textarea>
                </div>
            </div>
            <div class="field">
                <label class="label">
                    <?= $this->insert('components/icon', ['icon' => 'user', 'text' => 'Nombre de usuario (opcional)']) ?>
                </label>
                <div class="control">
                    <input name="username" class="input" type="text" autocomplete="off" />
                </div>
            </div>
            <div class="field">
                <label class="label">
                    <?= $this->insert('components/icon', ['icon' => 'smile', 'text' => 'Valoración (sobre 10)']) ?>
                </label>
                <div class="control">
                    <input name="note" class="input" type="number" min="0" max="10" required placeholder="Escribe tu valoración del 0 al 10" />
                </div>
            </div>
            <?php if(isset($tags) && count($tags) > 0): ?>
                <label class="label">
                    <?= $this->insert('components/icon', ['icon' => 'tag', 'text' => 'Etiquetas']) ?>
                </label>
                <div class="field">
                    <div class="control">
                        <div class="tags">
                            <?php foreach($tags as $tag): ?>
                                <span class="tag is-rounded is-<?= $this->tag($tag->type) ?>">
                                    <label class="checkbox">
                                        <input name="tags[]" value="<?= $this->e($tag->id) ?>" type="checkbox" />
                                        <?= $this->e($tag->name) ?>
                                    </label>
                                </span>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?= $this->insert('components/captcha') ?>
            <div class="field">
                <label class="checkbox">
                    <input name="accepted" type="checkbox" required>
                    He leído y acepto los <a href="<?= $this->url('/legal') ?>">términos de uso</a>
                </label>
            </div>
            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-success">
                        <?= $this->insert('components/icon', ['icon' => 'check', 'text' => 'Enviar']) ?>
                    </button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <p class="has-text-centered">Necesitas una cuenta para poder agregar un comentario</p>
    <?php endif ?>
</div>
