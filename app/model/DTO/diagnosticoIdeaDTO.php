<?php

    class DiagnosticoIdeaDTO {
         public $Num_consecutivo;
         public $Asesor;
         public $CC;
         public $Posicion;
         public $Idea;
         public $Motivacion;
         public $Elecion;
         public $Productos;
         public $Personal_requerido;
         public $Grupo_empresarial;
         public $Equipo_caracteristicas;
         public $Criterios_contratacion;
         public $Mercado_objetivo;
         public $Mercado_objetivo_ubica;
         public $Competidores;
         public $Factor_diferenciador;
         public $Condiciones_venta;
         public $Ubicacion_negocio;
         public $Ubicacion_influencia;
         public $Estrategia_precios;
         public $Canales_distribucion;
         public $Promocion_negocio;
         public $Costo_operacion;
         public $Fuentes_financiacion;
         public $Tiempo_retorno_inversion;
         public $Como_estimo_precio;
         public $Costo_producto;
         public $Asuntos_finanza;
         public $Desarrollo_producto;
         public $Tecnologia_requerida;
         public $Infraestructura_requerida;
         public $Regulaciones_operacion;
         public $Tipo_persona;

        public function __construct($Asesor, $CC, $Posicion){
            $this->Asesor = $Asesor;
            $this->CC = $CC;      
            $this->Posicion = $Posicion;
        }
        
        public function setNumConsecutivo($Num_consecutivo){
            $this->Num_consecutivo = $Num_consecutivo;
        }


        public function paso2 ($Idea, $Motivacion, $Elecion, $Productos){
            $this->Idea = $Idea;
            $this->Motivacion = $Motivacion;
            $this->Elecion = $Elecion;
            $this->Productos = $Productos;
        }
        
        public function paso3 ($Personal_requerido, $Grupo_empresarial, $Equipo_caracteristicas, $Criterios_contratacion){
            $this->Personal_requerido = $Personal_requerido;
            $this->Grupo_empresarial = $Grupo_empresarial;
            $this->Equipo_caracteristicas = $Equipo_caracteristicas;
            $this->Criterios_contratacion = $Criterios_contratacion;
        }
        
        public function paso4 ($Mercado_objetivo, $Mercado_objetivo_ubica, $Competidores, $Factor_diferenciador, $Condiciones_venta, $Ubicacion_negocio, $Ubicacion_influencia){
            $this->Mercado_objetivo = $Mercado_objetivo;
            $this->Mercado_objetivo_ubicacion = $Mercado_objetivo_ubica;
            $this->Competidores = $Competidores;
            $this->Factor_diferenciador = $Factor_diferenciador;
            $this->Condiciones_venta = $Condiciones_venta;
            $this->Ubicacion_negocio = $Ubicacion_negocio;
            $this->Ubicacion_influencia = $Ubicacion_influencia;
       }
        
        public function paso5 ($Estrategia_precios, $Canales_distribucion, $Promocion_negocio){
            $this->Estrategia_precios = $Estrategia_precios;
            $this->Canales_distribucion = $Canales_distribucion;
            $this->Promocion_negocio = $Promocion_negocio;
        }
        
        public function paso6 ($Costo_operacion, $Fuentes_financiacion, $Tiempo_retorno_inversion, $Como_estimo_precio, $Costo_producto, $Asuntos_finanza){
            $this->Costo_operacion = $Costo_operacion;
            $this->Fuentes_financiacion = $Fuentes_financiacion;
            $this->Tiempo_retorno_inversion = $Tiempo_retorno_inversion;
            $this->Como_estimo_precio = $Como_estimo_precio;
            $this->Costo_producto = $Costo_producto;
            $this->Asuntos_finanza = $Asuntos_finanza;
        }
        
        public function paso7 ($Desarrollo_producto, $Tecnologia_requerida, $Infraestructura_requerida){
            $this->Desarrollo_producto = $Desarrollo_producto;
            $this->Tecnologia_requerida = $Tecnologia_requerida;
            $this->Infraestructura_requerida = $Infraestructura_requerida;
        }
        
        public function paso8 ($Regulaciones_operacion, $Tipo_persona){
            $this->Regulaciones_operacion = $Regulaciones_operacion;
            $this->Tipo_persona = $Tipo_persona;
        }

    }

?>