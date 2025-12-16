<?php $this->layout('layouts/default', [
    'title' => 'Lista de difusión',
    'uri' => $uri,
]) ?>

<section class="hero has-text-centered">
    <div class="hero-body">
        <p class="title">Lista de difusión de estudiantes</p>
    </div>
</section>

<div class="container">
    <article class="message is-info">
        <div class="message-header">
            <p>Contexto</p>
        </div>
        <div class="message-body">
            <p>
                Probablemente hayas recibido en tu correo una gran cantidad de mensajes con un asunto empezando por
                <strong>[ldestudiantes]</strong>.
            </p>
            <p>
                Esta es la lista de difusión usada por la Universidad de Málaga para enviar correos
                a todos los estudiantes, administrada usando "sympa", un programa de código abierto para gestionar este tipo de correos.
            </p>
            <p>
                Si bien no puedes desuscribirte de esta lista, puedes hacer que no te lleguen los correos.
            </p>
        </div>
    </article>
    <div class="content">
        <p>Pasos a seguir para no recibir estos correos:</p>
        <ol>
            <li>
                Accede a <a href="https://sympa.sci.uma.es/sympa/suboptions/ldestudiantes" rel="nofollow" target="_blank">https://sympa.sci.uma.es/sympa/suboptions/ldestudiantes</a>
            </li>
            <li>
                Verás un mensaje que pone "Autorización rechazada. ¿Puede ser que te hayas olvidado de acceder?". Ciérrala y haz click
                en el botón que pone "Pulsar para acceder por iDUMA".
            </li>
            <li>
                Inicia sesión con tus credenciales de la UMA.
            </li>
            <li>
                Una vez iniciada sesión deberías poder ver una página con la configuración de tu suscripción.
            </li>
            <li>
                Busca la opción "Modo de recepción" y elige la opción "sin correo".
            </li>
            <li>
                Haz click en el botón que pone "Actualizar".
            </li>
            <li>¡Listo!</li>
        </ol>
    </div>
</div>
