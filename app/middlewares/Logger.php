<?php
use Slim\Psr7\Response;

class Logger
{
    public static function LogOperacion($request, $response, $next)
    {
        $retorno = $next($request, $response);
        return $retorno;
    }

    public static function VerificadorDeCredenciales($request, $handler)
    {
        $requestType = $request->getMethod();
        $response = new Response();

        switch($requestType)
        {
            case 'GET':
                $response->getBody()->write("Operacion realizada por: " . $requestType . ". No se verificaron credenciales");
                break;
            case 'POST':
                $response->getBody()->write("Operacion realizada por: " . $requestType);
                $formData = $request->getParsedBody();
                $nombre = $formData['nombre'];
                $perfil = $formData['perfil'];
                if($perfil === "admin")
                {
                }
                else
                {

                }
                break;
            default:
                break;
        }

        return $response;
    }
}