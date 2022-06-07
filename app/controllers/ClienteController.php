<?php
require_once './models/Cliente.php';
require_once './interfaces/IApiUsable.php';

//use \App\Models\Cliente as Cliente;

class ClienteController implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);
        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];

        // Creamos el usuario
        $cli = new Cliente();
        $cli->usuario = $usuario;
        $cli->clave = $claveHash;
        $cli->nombre = $nombre;
        $cli->apellido = $apellido;
        $cli->save();

        $payload = json_encode(array("mensaje" => "Cliente creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $usuario = $args['usuario'];
        $cliente = new Cliente();
        $miCliente = $cliente->where('usuario', $usuario)->get();
        $payload = json_encode($miCliente);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Cliente::all();
        $payload = json_encode(array("listaClientes" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();

      $usuario = $parametros['usuario'];
      $clave = $parametros['clave'];
      $claveHash = password_hash($clave, PASSWORD_DEFAULT);
      $nombre = $parametros['nombre'];
      $apellido = $parametros['apellido'];

      //Busco si existe el usuario a modificar
      $cliente = new Cliente();
      $miCliente = $cliente->find($args['id']);
      if($miCliente != null)
      {
        $miCliente->usuario = $usuario;
        $miCliente->clave = $clave;
        $miCliente->nombre = $nombre;
        $miCliente->apellido = $apellido;
        $miCliente->save();

        $payload = json_encode(array("mensaje" => "Cliente modificado con exito"));
      }
      else
      {
        $payload = json_encode(array("mensaje" => "El cliente no se encontró, intente de nuevo."));
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuarioId = $parametros['usuarioId'];
        Cliente::borrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Cliente borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
