<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "http://www.carteprayssac46.fr/#/",
        "http://www.carteprayssac46.fr/#/admin",
        "http://www.carteprayssac46.fr/#/languages",
        "http://www.carteprayssac46.fr/#/contact"
    ];
}
