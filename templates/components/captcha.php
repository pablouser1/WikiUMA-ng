<label class="label">
    <?= $this->insert('components/icon/main', ['icon' => 'bot', 'text' => 'Captcha']) ?>
</label>
<div class="field has-addons">
    <div class="control">
        <figure class="figure">
            <img src="<?= $this->captcha() ?>" alt="Captcha" />
        </figure>
    </div>
    <div class="control">
        <input name="captcha" type="text" class="input" placeholder="Escribe el Captcha" required />
    </div>
</div>
