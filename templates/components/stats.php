<?php if (count($stats) > 0) : ?>
    <p class="title has-text-centered">Estadísticas</p>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php if (isset($stats[0])) : ?>
            <div class="column is-narrow">
                <div class="box">
                    <p><b>Profesores:</b></p>
                    <p>Total de reseñas: <?= $stats[0]->total ?></p>
                    <p>Nota media: <?= $stats[0]->med ?></p>
                </div>
            </div>
        <?php endif ?>
        <?php if (isset($stats[1])) : ?>
            <div class="column is-narrow">
                <div class="box">
                    <p><b>Asignaturas:</b></p>
                    <p>Total de reseñas: <?= $stats[1]->total ?></p>
                    <p>Nota media: <?= $stats[1]->med ?></p>
                </div>
            </div>
        <?php endif ?>
    </div>
<?php endif ?>
