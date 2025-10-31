<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a href="<?= $this->url('/') ?>" class="navbar-item">
            WikiUMA
        </a>

        <a role="button" id="navbar-burger" class="navbar-burger" aria-label="menu" aria-expanded="false">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbar-menu" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="<?= $this->url('/centros') ?>">
                Directorio
            </a>
            <a class="navbar-item" href="<?= $this->url('/reports') ?>">
                Informes
            </a>
            <a class="navbar-item" href="<?= $this->url('/hall') ?>">
                Salón de la fama
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <div class="navbar-link">
                    Información
                </div>
                <div class="navbar-dropdown is-right">
                    <a class="navbar-item" href="<?= $this->url('/about') ?>">
                        Acerca de / FAQ
                    </a>
                    <a class="navbar-item" href="<?= $this->url('/legal') ?>">
                        Legal
                    </a>
                    <a class="navbar-item" href="<?= $this->url('/contact') ?>">
                        Contacto
                    </a>
                </div>
            </div>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <?php $this->insert('partials/theme') ?>
            </div>
            <?php if ($this->loggedin()): ?>
                <div class="navbar-item has-dropdown is-hoverable">
                    <div class="navbar-link">
                        <?= $this->e($_SESSION['username']) ?>
                    </div>
                    <div class="navbar-dropdown is-right">
                        <a class="navbar-item" href="<?= $this->url('/staff/reviews') ?>">
                            Valoraciones
                        </a>
                        <a class="navbar-item" href="<?= $this->url('/staff/reports') ?>">
                            Informes
                        </a>
                        <a class="navbar-item" href="<?= $this->url('/staff/logout') ?>">
                            Cerrar sesión
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a class="navbar-item" href="<?= $this->url('/staff/login') ?>">
                    Restringido
                </a>
            <?php endif ?>
        </div>
    </div>
</nav>
