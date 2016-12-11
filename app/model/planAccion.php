<?php
require_once "./app/model/model.php";

class PlanAccionModel extends Model {

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
    
//retorna una lista con los datos de los diagnosticos de idea para la tabla de seleccionar diagnostico a consultar
    public function consultarDiagIdea(){
        $this->connect();
        $consulta = "SELECT Num_consecutivo, CC, Idea, Fecha FROM diagnostico_idea where Num_consecutivo not in (select diag_idea from plan_accion_idea)";
        $query = $this->query($consulta);
        $this->terminate();
        $array=array();
        while($row = mysqli_fetch_array($query)){
            array_unshift($array,$row);
        }
        return $array;
    }


//retorna una lista con los datos de los diagnosticos de emrpesa para la tabla de seleccionar diagnostico a consultar 
     public function consultarDiagEmpresa(){
        $this->connect();
        $consulta = "SELECT id_diagnostico_emp, fecha, sector, nit_empresa FROM diagnostico_empresa where id_diagnostico_emp not in (select diag_empresa from plan_accion_empresa)";
        $query = $this->query($consulta);
        $this->terminate();
        $array=array();
        while($row = mysqli_fetch_array($query)){
            array_unshift($array,$row);
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

     public function consultarDatosEmpresa($nit){
        $this->connect();
        $consulta = "SELECT e.emp_nombre, e.emp_razons, e.emp_servicios, e.emp_telefono, e.emp_celular, p.cl_nombre
        FROM empresa e, contacto c, cliente p
        WHERE e.emp_nit = c.emp_nit
        AND c.cl_cedula = p.cl_cedula
        AND e.emp_nit = ".$nit;
        $query = $this->query($consulta);
        $this->terminate();
        $row= mysqli_fetch_array($query);
        return $row;
    }

    public function consultarDatosCliente($nit){
        $this->connect();
        $consulta = "SELECT c.cl_nombre, c.cl_apellido FROM cliente c, contacto p WHERE c.cl_cedula = p.cl_cedula AND   p.emp_nit =$nit";
        $query = $this->query($consulta);
        $this->terminate();
        $row = mysqli_fetch_array($query);
        return $row;
    }

    //consulta los posibles problemas que se van a listar para el plan de accion de la idea seleccionada
    public function consultarProblemasDiagIdea($numConsecutivo){
        $this->connect();
        $array=array();
        $consulta = "SELECT descripcion from lista_dificultades where num_consecutivo= $numConsecutivo";
        $query = $this->query($consulta);
        $this->terminate();
       while($row = mysqli_fetch_array($query)){
           array_unshift($array, $row['descripcion']);
       }
        return $array;
    }


    //consulta los posibles problemas que se van a listar para el plan de accion de la empresa seleccionada
    public function consultarProblemasDiagEmpresa($numConsecutivo){
        $this->connect();
        $array=array();
        $consulta1 = "SELECT mision, vision, objetivos, estrategias, plan_accion, participacion_empleados, empleados_conocen, estrategias_crecimiento, organigrama, procesos_documentados, procesos_evaluacion, procesos_automatizar, max_colaboradores, clima_laboral, motivacion_empleados, define_acciones, sistema_control, comparar_planeado_eje, clave_desempenio, seguimiento_indicadores, contrata_direc_personal, combina_forma_contratar, procesos_establecidos, recompensas_establecidas, empleados_necesarios, depto_mercadeo_ventas, msj_marketing_claro, plan_mercadeo, implementa_plan, cronograma_marketing, perfil_cliente, clasificacion_cliente, web_ventas, tecnologia_seguimiento, sistema_compatibilidad, contabilidad_aldia, aplica_normas_contabilidad, planificacion_financiera_formal, margen_rentabilidad, margen_rentabilidad_pos, ingresos_cumplen_objetivos, suficiente_capital, flujo_caja_positivo, costo_producto, presupuesto_estable, desiciones_analisis, programa_produccion, corresponde_demanda_mercado, produccion_planes, pontrola_calidad_producto, problemas_abastecimiento, Adquisicion_maquinaria, Planes_contingencia_maprima, Inventarios_periodicos, Seguimiento_inventarios, eficiente_dist_trabajo FROM diagnostico_empresa WHERE id_diagnostico_emp =$numConsecutivo";
        $query1 = $this->query($consulta1);
        $consulta2 = "SELECT id, descripcion FROM desc_problemas";
        $query2 = $this->query($consulta2);
        $this->terminate();
        $row = mysqli_fetch_array($query1);
        
        while($desc = mysqli_fetch_array($query2)){
            if($row[$desc['id']]!='Si'){
                array_unshift($array, $desc['descripcion']);
            }
            if($desc['id']=='problemas_abastecimiento' && $row[$desc['id']]=='Si'){
                array_unshift($array, $desc['descripcion']);
            }
        }
        return $array;

    }
    }
?>