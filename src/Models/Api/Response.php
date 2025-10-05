<?php

namespace App\Models\Api;

/**
 * Wrapped response.
 */
class Response
{
    public int $code;
    public bool $success;
    /**
     * @var object|array|string $data
     */
    public $data;
    public ?string $error = null;

    public function __construct(int $initialCode, $data, bool $isJson = true)
    {
        $code = $initialCode;
        // Check that it has data
        if ($data) {
            if (!$isJson) {
                // Handle HTML
                $this->data = $data;
            } else {
                // Handle JSON
                $jsonData = json_decode($data);
                if ($jsonData) {
                    /**
                     * Por algún motivo, todos los endpoints devuelven
                     * 200 aunque haya habido algún error
                     * Esta cadena de ifs intenta adaptarlo y poner el código adecuado
                     */

                    // Usado en /profesores, *generalmente* implica un 404
                    if (isset($jsonData->error) && $jsonData->error) {
                        $code = 404;
                        $this->error = $jsonData->nombre;
                        // Usado en /plan, *generalmente* implica un 404
                    } elseif (isset($jsonData->creditos) && $jsonData->creditos === '') {
                        $code = 404;
                        $this->error = 'Este plan no existe';
                        // Usado cuando SQL falla???
                    } elseif (isset($jsonData->ERROR)) {
                        $code = 502;
                        $this->error = $jsonData->ERROR;
                    } else {
                        $this->data = $jsonData;
                    }
                } else {
                    // Servidor devolvió un string vacío
                    $code = 502;
                    $this->error = 'JSON inválido';
                }
            }
        } else {
            $this->error = 'Respuesta vacía';
        }

        $this->code = $code;

        // To a request to be successful it has to be HTTP 200. have non-empty data and not contain any errors
        $this->success = $this->code >= 200 && $this->code < 400 && !$this->error;
    }
}
