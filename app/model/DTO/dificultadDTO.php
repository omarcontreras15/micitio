<?php

    class DificultadDTO {
        public $num_consecutivo;
        public $numero;
        public $descripcion;

        public function __construct ($num_consecutivo, $numero, $descripcion){
            $this->num_consecutivo = $num_consecutivo;
            $this->numero = $numero;
            $this->descripcion = $descripcion;
        }
    }


?>