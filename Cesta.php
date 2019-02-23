<?php

class Cesta {

    private $productos = [];

    function getProductos() {
        return $this->productos;
    }

    public static function generaCesta() {
        if (isset($_SESSION['cesta'])) {
            return $_SESSION['cesta'];
        } else {
            return new Cesta();
        }
    }

    public function mostrarCesta() {
        $listado = "";
        if ($this->productos == 0 || $this->productos == null) {
            $listado .= "<p class='cestaVacia'>0 PRODUCTOS</p>";
        } else {
            foreach ($this->productos as $codigo => $prods) {
                $listado .= "<form action='sitio.php' method='post'>"
                        . "<p>"
                        . "<span class='cantidad'>" . $prods[0] . "</span>"
                        . "<span class='codigo'>" . $codigo . "</span>"
                        . "<span class='precio'>" . $prods[1] . "</span>"
                        . "<input class='cestaAccion3' type='submit' name='accion' value='Borrar'>"
                        . "<input type='hidden' name='cod' value='$codigo'>"
                        . "</p>"
                        . "</form>";
            }
            $listado .= "<br><hr/><span class='coste'>  Total:" . $this->calcularTotal() . "</span> ";
        }
        return $listado;
    }

    public function nuevoProd($precio, $codigo) {
        if ($this->productos[$codigo][0] > 0) {
            $this->productos[$codigo][0] ++;
        } else {
            $this->productos[$codigo][0] = 1;
            $this->productos[$codigo][1] = $precio;
        }
    }

    public function guardaCesta() {
        return $_SESSION['cesta'] = $this;
    }

    public function calcularTotal() {
        foreach ($this->productos as $prods) {
            $total += $prods[0] * $prods[1];
        }
        return $total;
    }

    public function vaciar() {
        unset($this->productos);
    }

    public function eliminoProducto($codigo) {
        if ($this->productos[$codigo][0] > 1) {
            $this->productos[$codigo][0] --;
        } else {
            unset($this->productos[$codigo]);
        }
    }

}
