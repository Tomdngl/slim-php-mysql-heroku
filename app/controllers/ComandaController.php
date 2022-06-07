<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class ComandaController extends Comanda implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $parametros['id'];
        $id_cliente = $parametros['id_cliente'];
        $id_mesa = $parametros['id_mesa'];
    
        $comanda = new comanda();
        $comanda->id = $id;
        $comanda->id_cliente = $id_cliente;
        $comanda->id_mesa = $id_mesa;
        $comanda->crearComanda();

        $payload = json_encode(array("mensaje" => "Comanda creada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $comanda = $args['id'];
        $comanda = Comanda::obtenerComanda($comanda);
        $payload = json_encode($comanda);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Comanda::obtenerTodos();
        $payload = json_encode(array("listaComandas" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $id = $parametros['id'];
      $id_cliente = $parametros['id_cliente'];
      $id_mesa = $parametros['id_mesa'];

      //Busco si existe la mesa a modificar
      $miComanda = Comanda::obtenerComanda($id);
      if($miComanda != null)
      {
        // Creamos el producto modificado
        $Comanda = new Comanda();
        $Comanda->id_cliente = $id_cliente;
        $Comanda->id_mesa = $id_mesa;
        $Comanda->modificarComanda($miComanda->id);

        $payload = json_encode(array("mensaje" => "Comanda modificada con exito"));
      }
      else
      {
        $payload = json_encode(array("mensaje" => "La comanda no se encontró, intente de nuevo."));
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $comandaId = $parametros['comandaId'];
        Comanda::borrarComanda($comandaId);

        $payload = json_encode(array("mensaje" => "Comanda borrada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
