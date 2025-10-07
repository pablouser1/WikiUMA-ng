<?php $this->layout('layouts/default', ['title' => 'Legal']) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Legal',
])
?>

<section class="section">
    <div class="content">
        <h1>Términos de uso</h1>
        <ul>
            <li>
                Esta página web <strong>NO ESTÁ AFILIADA</strong> a la Universidad de Málaga.
            </li>
            <li>
                La administración de este servicio no verifica ni avala las publicaciones escritas por los usuarios.
            </li>
            <li>
                Cualquier publicación no apropiada (amenazas, publicación de información privada...) no está permitida y
                puede ser eliminada por la administración.
            </li>
            <li>
                Las publicaciones pueden ser manualmente denunciadas, en este caso la administración de la página web
                valorará el caso y puede borrar el comentario.
            </li>
        </ul>
    </div>
    <div class="content">
        <h1>Privacidad</h1>
        <p>WikiUMA recoge la siguiente información:</p>
        <ul>
            <li>Dirección IP <b>SÓLO</b> en los siguientes casos:</li>
            <ul>
                <li>Fallos repetidos a la hora de resolver captchas.</li>
                <li>Gran cantidad de solicitudes continuadas.</li>
                <li>En el resto de casos, tu dirección IP no se almacena.</li>
            </ul>
            <li>
                Al crear un informe, el correo electrónico dado es almacenado y
                usado exclusivamente para enviar actualizaciones de su estado.
            </li>
        </ul>
    </div>
    <div class="content">
        <p><strong>Al usar el servicio confirmas haber leído y aceptado los términos de uso.</strong></p>
    </div>
</section>
