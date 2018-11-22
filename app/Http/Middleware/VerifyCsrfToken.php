<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/app/doacoes/insert',
        '/app/doacoes/update',
        '/app/checkarAuth',
        '/app/logarUsuario',
        '/app/usuario/insert',
        '/app/usuario/update',
        '/app/dadosUsuario',
        '/app/conversas',
        '/app/mensagens',
        '/app/enviarMensagem',
    ];
}
