<?=$this->insert('components/head', ['title' => $title])?>

<body>
    <section class="hero">
        <div class="hero-body">
            <div class="container has-text-centered">
                <?=$this->section('header')?>
            </div>
        </div>
        <div class="hero-foot">
            <?=$this->insert('components/navbar')?>
        </div>
    </section>
    <section class="section">
        <?=$this->section('content')?>
    </section>
    <?=$this->insert('components/footer')?>
</body>
</html>
