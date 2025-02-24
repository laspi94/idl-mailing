# Mailing

Package para realizar llamada al api de IDL S.A para envio de mails personalizados.

## Uso

#### Login.

```http
  POST /v1/login/
```

| Parameter | Type     | Description  |
| :-------- | :------- | :----------- |
| `usuario` | `string` | **Required** |
| `clave`   | `string` | **Required** |

```env
`ENV_MAILING_USER` = 'pepito'
`ENV_MAILING_PASSWORD` = '123'
```

#### Envío de email.

```http
  POST /v1/correos/enviar
```

```json
/** raw data */
{
  "direccion_correo": "alan.laspina@idl.com.py",
  "asunto": "Es un tema muy serio",
  "nombre": "Juan Perez",
  "id_plantilla": "1",
  "datos": {
    "texto": "hola mundo!"
  }
}
```

## Variables de entorno

Para ejecutar este proyecto, deberá agregar las siguientes variables de entorno a su archivo .env

`MAILING_USER` = '**xxxxxxxx**'
`MAILING_PASSWORD` = '\***\*\*\*\*\*\*\***'

Estas configuraciones ya vienen pre asignadas, pero las puede reemplazar desde el enviroment en caso de ser necesario.

`MAILING_API_BASE_PATH` = 'http://dev-mailing-alb-1767758710.sa-east-1.elb.amazonaws.com:1031/'
`MAILING_API_BASE_PATH_ENDPOINT` = 'v1'
`MAILING_API_ENDPOINT_LOGIN` = '/login'
`MAILING_API_ENDPOINT_SEND` = '/correos/enviar'

## Instalación

Instalar con composer

```bash
  composer require laspi94/idl-mailing
```

## Uso/Ejemplos

```php
<?php
class MailingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function NotificarMovimiento($asunto, $datos = [], $nombre = 'Destinatario', $idPlantilla = "1")
    {
        try {
            $listadoCorreos = [
              'exampleMail@gmail.com'
            ];

            foreach ($listadoCorreos as $correo) {
                $email = MailingBuilder::direccionCorreo(trim($correo))
                    ->asunto($asunto)
                    ->nombre($nombre)
                    ->idPlantilla($idPlantilla)
                    ->datos($datos);

                $email->send();
            }
        } catch (\Exception $e) {
            Log::critical($e);

            return $e;
        }
    }
}
```

## Usado por

Este proyecto es utilizado por las siguientes empresas:

- IDL S.A.

## License

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

## Authors

- [@laspi94](https://www.github.com/laspi94)
