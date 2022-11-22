<?=$this->insert('components/head', ['title' => $title])?>

<body>
    <section class="hero is-medium is-primary">
        <div class="hero-body">
            <div class="container has-text-centered">
                <?=$this->section('header')?>
            </div>
        </div>
    </section>
    <?=$this->insert('components/navbar')?>
    <section class="section">
        <?=$this->section('content')?>
    </section>
    <?=$this->insert('components/footer')?>
</body>
</html>
