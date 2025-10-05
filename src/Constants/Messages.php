<?php

namespace App\Constants;

/**
 * Messages sent to user via HTTP.
 */
class Messages
{
    public const string API_ERROR = "Error en servidores de la UMA";
    public const string UNKNOWN_ERROR = "Error desconocido";
    public const string INVALID_REQUEST = "Solicitud inválida";

    public const string MUST_SEND_BODY = "No hay cuerpo o es inválido";
    public const string MUST_SEND_PARAMS = "No hay parámetros requeridos o son inválidos";

    // -- LOGIN -- //
    public const LOGIN_FAILED = "No se ha podido iniciar sesión.";

    // -- VOTING -- //
    public const ALREADY_VOTED = "Ya has votado.";
}
