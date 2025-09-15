<!DOCTYPE html>
<html lang="en">
<?php $this->insert('partials/head', ['title' => $title]) ?>
<body>
    <div class="hero is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="columns is-centered">
                    <div class="column is-narrow">
                        <?=$this->section('content')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
