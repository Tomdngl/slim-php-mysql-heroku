<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $estadoMesa = $parametros['estadoMesa'];
        $id = $parametros['id'];
    
        // Creamos el usuario
        $mesa = new Mesa();
        $mesa->id = $id;
        $mesa->estadoMesa = $estadoMesa;
        $mesa->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos producto por id
        $mesa = $args['id'];
        $mesa = Mesa::obtenerMesa($mesa);
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos();
        $payload = json_encode(array("listaMesas" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $id = $parametros['id'];
      $estadoMesa = $parametros['estadoMesa'];

      //Busco si existe la mesa a modificar
      $miMesa = Mesa::obtenerMesa($id);
      if($miMesa != null)
      {
        // Creamos el producto modificado
        $mesa = new Mesa();
        $mesa->estadoMesa = $estadoMesa;
        $mesa->modificarMesa($miMesa->id);

        $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));
      }
      else
      {
        $payload = json_encode(array("mensaje" => "La mesa no se encontró, intente de nuevo."));
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $mesaId = $parametros['mesaId'];
        Mesa::borrarMesa($mesaId);

        $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
