<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $descripcion = $parametros['descripcion'];
        $precio = $parametros['precio'];
        $tipoProducto = $parametros['tipoProducto'];
    
        // Creamos el usuario
        $pro = new Producto();
        $pro->descripcion = $descripcion;
        $pro->precio = $precio;
        $pro->tipoProducto = $tipoProducto;
        $pro->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos producto por id
        $pro = $args['id'];
        $producto = Producto::obtenerProducto($pro);
        $payload = json_encode($producto);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Empleado::obtenerTodos();
        $payload = json_encode(array("listaProductos" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $id = $parametros['id'];
      $descripcion = $parametros['descripcion'];
      $precio = $parametros['clave'];
      $tipoProducto = $parametros['nombre'];

      //Busco si existe el producto a modificar
      $mypro = Producto::obtenerProducto($id);
      if($mypro != null)
      {
        // Creamos el producto modificado
        $pro = new Producto();
        $pro->descripcion = $descripcion;
        $pro->precio = $precio;
        $pro->tipoProducto = $tipoProducto;
        $pro->modificarProducto($mypro->id);

        $payload = json_encode(array("mensaje" => "Producto modificado con exito"));
      }
      else
      {
        $payload = json_encode(array("mensaje" => "El producto no se encontró, intente de nuevo."));
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $productoId = $parametros['productoId'];
        Producto::borrarProducto($productoId);

        $payload = json_encode(array("mensaje" => "Cliente borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
