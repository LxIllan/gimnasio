<?php
    require_once 'Producto.php';
    require_once 'DineroDAO.php';
    require_once 'Conexion.php';
    require_once 'Util.php';

    class ProductoDAO
    {
        private $conexion;

        public function __construct()
        {
            $this->conexion = new Conexion();
        }

        public function agregarProducto($producto)
        {
            return $this->conexion->sentencia("INSERT INTO producto(nombre, ruta_fotografia, precio, contenido, num_piezas,"
                . " idtipo_producto)" . "VALUES ('" . $producto->getNombre() . "', '"
                . $producto->getRutaFotografia() . "', "
                . $producto->getPrecio() . ", '"
                . $producto->getContenido() . "', "
                . $producto->getNumPiezas() . ", "
                . $producto->getIdTipoProducto() . ")");
        }

        public function getSiguienteId(): int
        {
            $tupla = $this->conexion->consultarTupla("SELECT AUTO_INCREMENT FROM "
                . "INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'producto'");
            return $tupla[0];
        }

        public function editarProducto($producto)
        {
            return $this->conexion->sentencia("UPDATE producto SET "
                . "nombre = '" . $producto->getNombre() . "', "
                . "ruta_fotografia = '" . $producto->getRutaFotografia() . "', "
                . "precio = " . $producto->getPrecio() . ", "
                . "contenido = '" . $producto->getContenido() . "', "
                . "num_piezas = " . $producto->getNumPiezas() . ", "
                . "idtipo_producto = " . $producto->getIdTipoProducto() . " "
                . "WHERE idproducto = " . $producto->getIdProducto());
        }

        public function editarVisita($precio)
        {
            return $this->conexion->sentencia("UPDATE producto SET precio = " . $precio . " WHERE idproducto = " . Producto::VISITA);
        }

        public function eliminarProducto($idProducto)
        {
            $ubicacionDeLaFoto = "img/Productos/IMG_" . $idProductos . ".jpeg";
			if (file_exists($ubicacionDeLaFoto)) {
				unlink($ubicacionDeLaFoto);
			}
            return $this->conexion->sentencia("DELETE FROM producto WHERE idproducto = " . $idProducto);
        }

        public function surtirProducto($idProducto, $numPiezas)
        {
            $numPiezasGuardadas = 0;
            $tupla = $this->conexion->consultarTupla("SELECT num_piezas FROM producto WHERE idproducto = " . $idProducto);
            $numPiezasGuardadas = $tupla[0];
            return $this->conexion->sentencia("UPDATE producto SET num_piezas = "
                . ($numPiezasGuardadas + $numPiezas) . " WHERE idproducto = " . $idProducto);
        }

        public function registrarVisita($idGimnasio, $idRecepcionista)
        {
            $dineroDAO = new DineroDAO();
            $precio = 0;
            $tupla = $this->conexion->consultarTupla("SELECT precio FROM producto WHERE idproducto = " . Producto::VISITA);
            $precio = $tupla['precio'];
            return $dineroDAO->actualizarMontoActual($idGimnasio, $precio) && $this->conexion->sentencia(
            "INSERT INTO venta_productos(fecha, idProducto, num_piezas, precio, idusuario) VALUES ('"
                . date('Y-m-d') . "', '" . Producto::VISITA . "', 1, " . $precio . ", "
                . $idRecepcionista . ")"
            );
        }

        public function venderProducto($idProducto, $piezasVendidas, $idGimnasio, $idRecepcionista)
        {
            $dineroDAO = new DineroDAO();
            $numPiezas = 0;
            $ganancia = 0;
            $precio = 0;
            $tupla = $this->conexion->consultarTupla("SELECT precio, num_piezas FROM producto WHERE idproducto = " . $idProducto);
            $numPiezas = $tupla['num_piezas'];
            $precio = $tupla['precio'];
            $ganancia = $precio * $piezasVendidas;
            return $this->conexion->sentencia("UPDATE producto SET num_piezas = " . ($numPiezas - $piezasVendidas) . " WHERE idproducto = " . $idProducto)
            && $dineroDAO->actualizarMontoActual($idGimnasio, $ganancia)
                && $this->conexion->sentencia(
            "INSERT INTO venta_productos(fecha, idProducto, num_piezas, precio, idusuario) VALUES ('"
                . date('Y-m-d') . "', " . $idProducto . ", " . $piezasVendidas . ", ". $precio .", "
                . $idRecepcionista .")"
                );
        }

        public function dameProducto($idProducto)
        {
            $tupla = $this->conexion->consultarTupla('SELECT idproducto, nombre, ruta_fotografia, '
                . 'precio, contenido, num_piezas, idtipo_producto FROM producto '
                . 'WHERE idproducto = ' . $idProducto);
            return new Producto(
                $tupla[0],
                $tupla[1],
                $tupla[2],
                $tupla[3],
                $tupla[4],
                $tupla[5],
                                $tupla[6]
            );
        }

        public function dameProductos($nombre = '')
        {
            $productos = new ArrayList();
            $result = $this->conexion->consultar("SELECT idproducto FROM producto WHERE nombre LIKE '%$nombre%' AND idproducto > 1 ORDER BY nombre");
            while ($tupla = $result->fetch_array()) {
                $productos->add(self::dameProducto($tupla['idproducto']));
            }
            if (!$productos->isEmpty()) {
                return $productos;
            } else {
                return null;
            }
        }

        public function dameVentaDeProductos($ventasDeHoy)
        {
            $strQuery = "SELECT producto.nombre, producto.contenido, "
                        . "venta_productos.precio, venta_productos.num_piezas, usuario.nombre_pila, "
                        . "usuario.apellido1 "
                        . "FROM venta_productos, producto, usuario "
                        . "WHERE venta_productos.idproducto = producto.idproducto "
                        . "AND venta_productos.idusuario = usuario.idusuario ";
            if ($ventasDeHoy) {
                $ahora = date('Y-m-j');
                $result = $this->conexion->consultar($strQuery . "AND venta_productos.fecha = '$ahora'");
            } else {
                $result = $this->conexion->consultar($strQuery);
            }
            $ventaDeProductos = array();
            while ($tupla = $result->fetch_array()) {
                array_push($ventaDeProductos, array($tupla[0], $tupla[1], $tupla[2], $tupla[3],
                            $tupla[4] . ' ' . $tupla[5]));
            }
            if (count($ventaDeProductos) > 0) {
                return $ventaDeProductos;
            } else {
                return null;
            }
        }

        public function dameVentaDeProductosFechas($fechaInicio, $fechaFin)
        {
            $result = $this->conexion->consultar("SELECT producto.nombre, producto.contenido, "
                . "venta_productos.precio, venta_productos.num_piezas, venta_productos.fecha, "
                . "usuario.nombre_pila, usuario.apellido1 "
                . "FROM venta_productos, producto, usuario "
                . "WHERE venta_productos.idproducto = producto.idproducto "
                . "AND venta_productos.idusuario = usuario.idusuario "
                . "AND venta_productos.fecha >= '$fechaInicio' "
                . "AND venta_productos.fecha <= '$fechaFin'"
                . "ORDER BY venta_productos.fecha");
            $ventaDeProductos = array();
            while ($tupla = $result->fetch_array()) {
                array_push($ventaDeProductos, array($tupla[0], $tupla[1], $tupla[2], $tupla[3],
                    $tupla[4], $tupla[5] . ' ' . $tupla[6]));
            }
            if (count($ventaDeProductos) > 0) {
                return $ventaDeProductos;
            } else {
                return null;
            }
        }
    }
