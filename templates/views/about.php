<?php $this->layout('layouts/default', ['title' => 'Acerca de']) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Acerca de WikiUMA',
    'subtitle' => "Versión: {$this->version()}",
])
?>

<section class="section">
    <div class="content">
        <p>WikiUMA <small>ng</small> aspira a continuar el funcionamiento de su antecesor con varias mejoras.
    </div>
    <div class="content">
        <p class="title">Créditos</p>
        <p>Este proyecto no sería posible sin la ayuda de:</p>
        <ul>
            <li>
                <a rel="nofollow" href="https://github.com/thephpleague/plates">Plates</a>
            </li>
            <li>
                <a rel="nofollow" href="https://github.com/jgthms/bulma">Bulma</a>
            </li>
            <li>
                <a rel="nofollow" href="https://github.com/developerdino/ProfanityFilter">developerdino/ProfanityFilter</a>
                (con algunas modificaciones)
            </li>
            <li>
                <a rel="nofollow" href="https://iconoir.com">Iconoir</a>
            </li>
        </ul>
    </div>
</section>
