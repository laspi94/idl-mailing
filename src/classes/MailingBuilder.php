<?php

namespace IdlMailing\Class;

use Idl\Mailing\Helpers\Codigo;

class MailingBuilder
{
    public String $USER;

    public String $PASSWORD;

    public String $API_BASE_PATH;

    public String $API_BASE_PATH_ENDPOINT;

    public String $API_ENDPOINT_LOGIN;

    public String $API_ENDPOINT_SEND;

    protected string $direccionCorreo;

    protected string $asunto;

    protected string $nombre;

    protected string $idPlantilla;

    protected array $datos = [];

    public function __construct()
    {
        $this->USER = config('mailing.user');
        $this->PASSWORD = config('mailing.password');
        $this->API_BASE_PATH = config('mailing.base_path');
        $this->API_BASE_PATH_ENDPOINT = config('mailing.api_base_path_endpoint');
        $this->API_ENDPOINT_LOGIN = config('mailing.api_endpoint_login');
        $this->API_ENDPOINT_SEND = config('mailing.api_endpoint_send');
    }

    public static function direccionCorreo(string $correo): self
    {
        $instance = new self();
        $instance->direccionCorreo = $correo;
        return $instance;
    }

    public function asunto(string $asunto): self
    {
        $this->asunto = $asunto;
        return $this;
    }

    public function nombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function idPlantilla(string $id): self
    {
        $this->idPlantilla = $id;
        return $this;
    }

    public function datos(array $datos): self
    {
        $this->datos = $datos;
        return $this;
    }

    public function send()
    {
        $payload = [
            "direccion_correo" => $this->direccionCorreo,
            "asunto" => $this->asunto,
            "nombre" => $this->nombre,
            "id_plantilla" => $this->idPlantilla,
            "datos" => $this->datos
        ];

        $this->sendEmail($payload);
    }

    public function login()
    {
        try {
            $url = $this->API_BASE_PATH . $this->API_BASE_PATH_ENDPOINT . $this->API_ENDPOINT_LOGIN;

            $additional_headers = array(
                'Content-Type: multipart/form-data'
            );

            $authData = [
                'usuario' => $this->USER,
                'clave' => $this->PASSWORD
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $authData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response, true);

            if ($response['codigo'] == Codigo::CERO) {
                return $response;
            } else {
                throw new \Exception("Error en el proceso de autenticasción en el envío de email");
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function sendEmail($payload)
    {
        try {
            $login = $this->login();

            $url = $this->API_BASE_PATH . $this->API_BASE_PATH_ENDPOINT . $this->API_ENDPOINT_SEND;

            $additional_headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $login['token']
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response, true);

            if ($response['codigo'] == Codigo::CERO) {
                return $response;
            } else {
                throw new \Exception("Error en el proceso de envío de email");
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}
