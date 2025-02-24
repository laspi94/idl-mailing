<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DATOS_SET*
    |--------------------------------------------------------------------------
    |
    | Estas variables corresponde a la conexión con el API para la obtención de 
    | datos de contribuyentes de la SET, el BASE PATH depende del entorno el cual
    | se esté ejecutando.
    |
    */

    'user' => env('MAILING_USER', ''),
    'password' => env('MAILING_PASSWORD', ''),
    'base_path' => env('MAILING_API_BASE_PATH', 'http://dev-mailing-alb-1767758710.sa-east-1.elb.amazonaws.com:1031/'),
    'api_base_path_endpoint' => env('MAILING_API_BASE_PATH_ENDPOINT', 'v1'),
    'api_endpoint_login' => env('MAILING_API_ENDPOINT_LOGIN', '/login'),
    'api_endpoint_send' => env('MAILING_API_ENDPOINT_SEND', '/correos/enviar'),
];
