<nav class="navbar is-transparent" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a href="<?=$this->url('/')?>" class="navbar-item">
      <?= $this->insert('components/icon', ['icon' => 'home', 'text' => 'WikiUMA-ng']) ?>
    </a>

    <a role="button" id="navbar-burger" class="navbar-burger" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbar-menu" class="navbar-menu">
    <div class="navbar-start">
      <?php foreach($this->links() as $link): ?>
      <a class="navbar-item" href="<?=$this->url($link['endpoint'])?>">
        <?= $this->insert('components/icon', ['icon' => $this->e($link['icon']), 'text' => $this->e($link['name'])]) ?>
      </a>
      <?php endforeach ?>
    </div>
    <div class="navbar-end">
      <?php if ($this->isLoggedIn()): ?>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          <?= $this->insert('components/icon', ['icon' => 'user', 'text' => $this->e($_SESSION['niu'])]) ?>
        </a>
        <div class="navbar-dropdown">
          <?php if ($this->isLoggedIn(true)): ?>
            <a class="navbar-item" href="<?=$this->url('/admin')?>">Panel de Control</a>
          <?php endif ?>
          <a class="navbar-item" href="<?=$this->url('/logout')?>">Cerrar sesión</a>
        </div>
      </div>
      <?php else: ?>
        <div class="navbar-item">
          <div class="buttons">
            <a href="/login" class="button is-info">
              <?= $this->insert('components/icon', ['icon' => 'user', 'text' => 'Iniciar sesión']) ?>
            </a>
            <?php if ($this->mode() !== 0): ?>
                <a href="/register" class="button is-primary">
                  <?= $this->insert('components/icon', ['icon' => 'user-add', 'text' => 'Registrarse']) ?>
                </a>
            <?php endif ?>
          </div>
        </div>
      <?php endif ?>
    </div>
  </div>
</nav>

<script defer src="<?=$this->url('/js/navbar.js')?>"></script>
