<?php
namespace App\Constants;

class Messages
{
    public const string API_ERROR = "Error en servidores de la UMA";
    public const string CLIENT_ERROR = "Error del cliente";
    public const string UNKNOWN_ERROR = "Error desconocido";

    public const string INVALID_REQUEST = "Solicitud inválida";
    public const string MUST_SEND_ID = "Debes enviar un email o un idnc";
    public const string MUST_SEND_VALID_EMAIL = "El email enviado no es válido";
    public const string MUST_SEND_BODY = "No hay cuerpo";
}
