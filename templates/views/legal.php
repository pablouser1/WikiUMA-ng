<?php $this->layout('layouts/default', ['title' => 'Acerca de']) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Legal',
])
    ?>

<div class="container">
    <div class="content">
        <p class="title">Términos de uso</p>
        <ul>
            <li>
                Esta página web <strong>NO ESTÁ AFILIADA</strong> a la Universidad de Málaga
            </li>
            <li>
                La administración de este servicio no verifica ni avala las publicaciones escritas por los usuarios
            </li>
            <li>
                Cualquier publicación no apropiada (amenazas, publicación de información privada...) no está permitida y
                puede
                ser eliminada por la administración.
            </li>
            <li>
                Las publicaciones pueden ser manualmente denunciadas, en este caso la administración de la página web
                valorará el caso y puede borrar el comentario
            </li>
        </ul>
    </div>
    <div class="content">
        <p class="title">Privacidad</p>
        <ul>
            <li>
                Todas las publicaciones son <b>anónimas</b> y no se registra ningún tipo de información con el que se
                pueda identificar al usuario que la haya realizado.
            </li>
            <li>
                Esta página web utiliza cookies, necesarias para su correcto funcionamiento.
            </li>
        </ul>
    </div>
    <div class="content">
        <p><strong>Al usar el servicio confirmas haber leído y aceptado los términos de uso.</strong></p>
    </div>
</div>
