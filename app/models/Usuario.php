<?php

abstract class Usuario
{
    public $id;
    public $usuario;
    public $clave;
    public $nombre;
    public $apellido;

    abstract public function crearUsuario();

    abstract public static function obtenerTodos();

    abstract public static function obtenerUsuario($usuario);

    abstract public function modificarUsuario($id);

    abstract public static function borrarUsuario($usuario);
}