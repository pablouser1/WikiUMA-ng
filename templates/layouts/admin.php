<?=$this->insert('components/head', ['title' => $title])?>

<body>
    <?=$this->insert('components/navbar')?>
    <div class="columns">
        <div class="column is-2 ml-2">
            <aside class="menu">
                <p class="menu-label">
                  Administración
                </p>
                <ul class="menu-list">
                  <li><a href="<?= $this->url('/admin/reports') ?>">Reportes</a></li>
                  <li><a href="<?= $this->url('/admin/reviews') ?>">Reseñas</a></li>
                  <li><a href="<?= $this->url('/admin/tags') ?>">Etiquetas</a></li>
                </ul>
            </aside>
        </div>
        <div class="column is-10">
            <section class="hero is-info">
                <div class="hero-body">
                    <div class="container has-text-centered">
                        <?=$this->section('header')?>
                    </div>
                </div>
            </section>
            <section class="section">
                <?=$this->section('content')?>
            </section>
        </div>
    </div>
    <?=$this->insert('components/footer')?>
</body>
</html>
