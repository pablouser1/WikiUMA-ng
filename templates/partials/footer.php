<footer class="footer has-text-centered mt-2">
    <div class="block">
        <p>
            Hecho con <span style="color: #e25555;">&#9829;</span> en
            <a target="_blank" href="https://github.com/pablouser1/WikiUMA-ng">
                <span class="icon-text">
                    <span class="icon">
                        <?= icon('fa7-brands:github') ?>
                    </span>
                    <span>Github</span>
                </span>
            </a>
        </p>
        <p>Versión: <b><?= $this->version() ?></b></p>
    </div>
    <div class="block">
        <a href="https://github.com/pablouser1/WikiUMA-ng/blob/master/LICENSE" target="_blank">
            <img src="<?= $this->url('/img/agplv3.png') ?>" />
        </a>
    </div>
</footer>
