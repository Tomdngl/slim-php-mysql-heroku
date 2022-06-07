<?php
require_once './models/Empleado.php';
require_once './interfaces/IApiUsable.php';

class EmpleadoController extends Empleado implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $tipo = $parametros['tipo'];

        // Creamos el usuario
        $emp = new Empleado();
        $emp->usuario = $usuario;
        $emp->clave = $clave;
        $emp->nombre = $nombre;
        $emp->apellido = $apellido;
        $emp->tipo = $tipo;
        $emp->crearUsuario();

        $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $cli = $args['usuario'];
        $usuario = Empleado::obtenerUsuario($cli);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Empleado::obtenerTodos();
        $payload = json_encode(array("listaEmpleados" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $tipo = $parametros['tipo'];
  
        //Busco si existe el usuario a modificar
        $myemp = Empleado::obtenerUsuario($usuario);
        if($myemp != null)
        {
          // Creamos el usuario modificado
          $emp = new Empleado();
          $emp->usuario = $usuario;
          $emp->clave = $clave;
          $emp->nombre = $nombre;
          $emp->apellido = $apellido;
          $emp->tipo = $tipo;
          $emp->modificarUsuario($myemp->id);
  
          $payload = json_encode(array("mensaje" => "Empleado modificado con exito"));
        }
        else
        {
          $payload = json_encode(array("mensaje" => "El empleado no se encontró, intente de nuevo."));
        }
  
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuarioId = $parametros['usuarioId'];
        Empleado::borrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Empleado borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
