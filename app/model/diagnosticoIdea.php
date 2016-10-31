<?php
require_once "./app/model/model.php";

class diagnosticoIdeaModel extends Model {

    //CONSULTA EL NOMBRE DEL ASESOR  QUE TIENE SESSION INICIADA
    public function consultarNombreAsesor(){
        $this->connect();
        $consulta = "SELECT * FROM user WHERE id=".$_SESSION["user_id"];
        $query = $this->query($consulta);
        $this->terminate();
        while($row = mysqli_fetch_array($query)){
            return $row["nombre"];
        }
        return "";
    }

    public function editarForm($form){
        $this->connect();
        $update = "UPDATE `diagnostico_idea` SET `Asesor`= '".$form['Asesor']."', `Nombres`= '".$form['Nombres']."', `Apellidos`= '".$form['Apellidos']."', `CC`='".$form['CC']."',
             `Posicion`= '".$form['Posicion']."', `Telefono`= '".$form['Telefono']."', `Celular`= '".$form['Celular']."', `Idea`= '".$form['Idea']."',
             `Motivacion`= '".$form['Motivacion']."', `Elecion`= '".$form['Elecion']."', `Productos`= '".$form['Productos']."',
             `Personal_requerido`= '".$form['Personal_requerido']."', `Grupo_empresarial`= '".$form['Grupo_empresarial']."',
             `Equipo_caracteristicas`= '".$form['Equipo_caracteristicas']."', `Criterios_contratacion`= '".$form['Criterios_contratacion']."',
             `Mercado_objetivo`= '".$form['Mercado_objetivo']."', `Mercado_objetivo_ubica`= '".$form['Mercado_objetivo_ubica']."',
             `Competidores`= '".$form['Competidores']."', `Factor_diferenciador`= '".$form['Factor_diferenciador']."',
             `Condiciones_venta`= '".$form['Condiciones_venta']."', `Ubicacion_negocio`= '".$form['Ubicacion_negocio']."',
             `Ubicacion_influencia`= '".$form['Ubicacion_influencia']."', `Estrategia_precios`= '".$form['Estrategia_precios']."',
             `Canales_distribucion`= '".$form['Canales_distribucion']."', `Promocion_negocio`= '".$form['Promocion_negocio']."',
             `Costo_operacion`= '".$form['Costo_operacion']."', `Fuentes_financiacion`= '".$form['Fuentes_financiacion']."',
             `Tiempo_retorno_inversion`= '".$form['Tiempo_retorno_inversion']."', `Como_estimo_precio`= '".$form['Como_estimo_precio']."',
             `Costo_producto`= '".$form['Costo_producto']."', `Asuntos_finanza`= '".$form['Asuntos_finanza']."', `Desarrollo_producto`= '".$form['Desarrollo_producto']."',
             `Tecnologia_requerida`= '".$form['Tecnologia_requerida']."', `Infraestructura_requerida`= '".$form['Infraestructura_requerida']."',
             `Regulaciones_operacion`= '".$form['Regulaciones_operacion']."', `Tipo_persona`= '".$form['Tipo_persona']."',
             `Aspectos_mejorar`= '".$form['Aspectos_mejorar']."' WHERE `Num_consecutivo`=".$form['Num_consecutivo'];

        $query = $this->query($update);
        $this->terminate();
    }

    public function setDificultad ($num_consecutivo, $numero, $descripcion) {
            $this->connect();
            if($descripcion==null){
                $descripcion="NULL";
            }
            $this->query("INSERT INTO lista_dificultades (num_consecutivo, numero, descripcion) 
                             values ('$num_consecutivo', '$numero', '$descripcion')");
            $this->terminate();

    }



    public function agregarDificultades ($arrayDTO) {
        for($i = 0; $i < count($arrayDTO); $i++){
            $DTO = $arrayDTO[$i];
            $this->setDificultad($DTO->num_consecutivo, $DTO->numero, $DTO->descripcion);
        }
    }


    public function agregarForm($DTO){
        $array = get_object_vars($DTO);
        foreach($array as $clave=>$valor){
            if($valor ==null){
                $array[$clave]="NULL";
            }else{
                $array[$clave]="'$valor'";
            }
        }
       
        $this->connect();
        //esto lo daño omar
        $insert = "INSERT INTO `diagnostico_idea` (`Asesor`, `CC`, `Posicion`,`Idea`,`Motivacion`, `Elecion`, `Productos`, `Personal_requerido`, `Grupo_empresarial`, `Equipo_caracteristicas`, `Criterios_contratacion`, `Mercado_objetivo`, `Mercado_objetivo_ubica`, `Competidores`, `Factor_diferenciador`, `Condiciones_venta`, `Ubicacion_negocio`, `Ubicacion_influencia`, `Estrategia_precios`, `Canales_distribucion`, `Promocion_negocio`, `Costo_operacion`, `Fuentes_financiacion`, `Tiempo_retorno_inversion`, `Como_estimo_precio`, `Costo_producto`, `Asuntos_finanza`, `Desarrollo_producto`, `Tecnologia_requerida`, `Infraestructura_requerida`, `Regulaciones_operacion`, `Tipo_persona`) VALUES (".$array['Asesor'].",".$array['CC'].",". $array['Posicion'].",".$array['Idea'].",".$array['Motivacion'].",".$array['Elecion'].",".$array['Productos'].",".$array['Personal_requerido'].",".$array['Grupo_empresarial'].",".$array['Equipo_caracteristicas'].",".$array['Criterios_contratacion'].",".$array['Mercado_objetivo'].",".$array['Mercado_objetivo_ubica'].",".$array['Competidores'].",".$array['Factor_diferenciador'].",".$array['Condiciones_venta'].",".$array['Ubicacion_negocio'].",".$array['Ubicacion_influencia'].",".$array['Estrategia_precios'].",".$array['Canales_distribucion'].",".$array['Promocion_negocio'].",".$array['Costo_operacion'].",".$array['Fuentes_financiacion'].",".$array['Tiempo_retorno_inversion'].",".$array['Como_estimo_precio'].",".$array['Costo_producto'].",".$array['Asuntos_finanza'].",".$array['Desarrollo_producto'].",".$array['Tecnologia_requerida'].",".$array['Infraestructura_requerida'].",".$array['Regulaciones_operacion'].",".$array['Tipo_persona'].")";

        $this->query($insert);
        $consulta="SELECT * FROM diagnostico_idea order by Num_consecutivo desc LIMIT 1";
        $row=mysqli_fetch_array($this->query($consulta));
        $id= $row["Num_consecutivo"];
        $this->terminate();
        return $id;
    }

    public function consultarForm($consecutivo){
        $this->connect();
        $consulta = "SELECT * FROM diagnostico_idea WHERE Num_consecutivo = ".$consecutivo;
        $query = $this->query($consulta);
        $this->terminate();
        $row= mysqli_fetch_array($query);
        return $row;
    }


    public function consultarDiagIdea(){
        $this->connect();
        $consulta = "SELECT Num_consecutivo, Nombres, Apellidos, CC, Idea, Fecha FROM diagnostico_idea";
        $query = $this->query($consulta);
        $this->terminate();
        $array=array();
        while($row = mysqli_fetch_array($query)){
            array_unshift($array,$row);
        }
        return $array;
    }

    //CLIENTE
    public function consultarEmprendedor(){
        $this->connect();
        $consulta = "SELECT cl_cedula, cl_nombre, cl_apellido FROM cliente";
        $query = $this->query($consulta);
        $this->terminate();
        $array = array();
        while($row = mysqli_fetch_array($query)){
            array_unshift($array, $row);
        }
        return $array;
    }

    public function consultarDatosEmprendedor($cc){
        $this->connect();
        $consulta = "SELECT cl_cedula, cl_nombre, cl_apellido, cl_telefono, cl_celular, cl_cedula FROM cliente WHERE cl_cedula = ".$cc;
        $query = $this->query($consulta);
        $this->terminate();
        $row= mysqli_fetch_array($query);
        return $row;
    }

}

?>