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
    
    public function insertarPlanAccion($numConsecutivo, $obs_adicionales, $que_sucedio, $cumplio, $alcanzaron_obj){
        $this->connect();
        $insert="";
        if($form['tipo']=="idea"){
            $insert = "INSERT INTO `plan_accion_idea` (`diag_idea`, `obs_adicionales`,`asesor`, `que_sucedio`, `cumplio`, `alcanzaron_obj`) VALUES ($numConsecutivo, '$obs_adicionales','".$form['asesor']."', '$que_sucedio', '$cumplio', '$alcanzaron_obj')";
        }else{
            $insert = "INSERT INTO `plan_accion_empresa` (`diag_empresa`, `obs_adicionales`,`asesor`, `que_sucedio`, `cumplio`, `alcanzaron_obj`) VALUES ($numConsecutivo, '$obs_adicionales','".$form['asesor']."', '$que_sucedio', '$cumplio', '$alcanzaron_obj')";
        }
        $query = $this->query($insert);
        
        //consulta ultimo id
        $consulta="";
        if($form['tipo']=="idea"){
            $consulta="SELECT id_paccion from plan_accion_idea where diag_idea=$numConsecutivo";
        }else{
            $consulta="SELECT id_paccion from plan_accion_empresa where diag_empresa=$numConsecutivo";
        }
        $consulta =mysqli_fetch_array($this->query($consulta));
        $this->terminate();
        return $consulta['id_paccion'];
    }
    
    public function insertarProblemas($form, $id_plan_accion){
        $cantProblemas=$form['cant-problemas'];
        $numConsecutivo=$form['num-consecutivo'];
        $this->connect();
        for ($i=1; $i <=$cantProblemas; $i++) {
            $insert="";
            if($form['tipo']=="idea"){
                $insert="INSERT INTO `problema_idea` (`id_paccion`, `diag_idea`, `problema`, `causa`, `efecto`, `solucion_obj`, `fecha_reunion`, `fecha_prox_reunion`) VALUES ('".$id_plan_accion."', '".$numConsecutivo."', '".$form['problemas-'.$i]."', '".$form['causas-'.$i]."', '".$form['efectos-'.$i]."', '".$form['soluciones-'.$i]."', '".$form['fecha_reunion-'.$i]."', '".$form['fecha_prox_reunion-'.$i]."'); ";
            }else{
                $insert="INSERT INTO `problema_empresa` (`id_paccion`, `diag_empresa`, `problema`, `causa`, `efecto`, `solucion_obj`, `fecha_reunion`, `fecha_prox_reunion`) VALUES ('".$id_plan_accion."', '".$numConsecutivo."', '".$form['problemas-'.$i]."', '".$form['causas-'.$i]."', '".$form['efectos-'.$i]."', '".$form['soluciones-'.$i]."', '".$form['fecha_reunion-'.$i]."', '".$form['fecha_prox_reunion-'.$i]."'); ";
            }
            $query = $this->query($insert);
        }
        
        
        //consulta ultimo id problema
        $array=array();
        $consulta="";
        if($form['tipo']=="idea"){
            $consulta="SELECT id_problema from problema_idea where diag_idea=$numConsecutivo and id_paccion=$id_plan_accion ORDER BY id_problema ASC";
        }else{
            $consulta="SELECT id_problema from problema_empresa where diag_empresa=$numConsecutivo and id_paccion=$id_plan_accion ORDER BY id_problema ASC";
        }
        $consulta=$this->query($consulta);
        while ($row=mysqli_fetch_array($consulta)) {
            array_push($array,$row['id_problema']);
        }
        $this->terminate();
        
        return $array;
    }
    
    public function insertarTareas($form, $id_plan_accion, $ids_problemas){
        $cantObjectivos=$form['cant-problemas'];
        $numConsecutivo=$form['num-consecutivo'];
        $this->connect();
        
        for ($i=1; $i <=$cantObjectivos; $i++) {
            $cantTareas=$form[$i.'-cant-tareas'];
            for ($j=1; $j <=$cantTareas; $j++) {
                $insert="";
                if($form['tipo']=="idea"){
                    $insert="INSERT INTO `tarea_idea` (`id_paccion`, `diag_idea`, `id_problema`, `tarea`, `fecha_entrega`) VALUES ($id_plan_accion, $numConsecutivo,'".$ids_problemas[$i-1]."','".$form[$i.'-tarea-'.$j]."', '".$form[$i.'-fecha_tarea-'.$j]."')";
                }else{
                    $insert="INSERT INTO `tarea_empresa` (`id_paccion`, `diag_empresa`, `id_problema`, `tarea`, `fecha_entrega`) VALUES ($id_plan_accion, $numConsecutivo,'".$ids_problemas[$i-1]."','".$form[$i.'-tarea-'.$j]."', '".$form[$i.'-fecha_tarea-'.$j]."')";
                }
                $query = $this->query($insert);
            }
        }
        $this->terminate();
    }
    
    public function insertarResultados($form, $id_plan_accion){
        $cantResultados=$form['cant-resultados'];
        $numConsecutivo=$form['num-consecutivo'];
        
        $this->connect();
        
        for ($i=1; $i <=$cantResultados; $i++) {
            $insert="";
            if($form['tipo']=="idea"){
                $insert="INSERT INTO `resultado_idea` (`diag_idea`, `id_paccion`, `resultado`) VALUES ($numConsecutivo, $id_plan_accion, '".$form['resultados-plan-accion-'.$i]."')";
            }else{
                $insert="INSERT INTO `resultado_empresa` (`diag_empresa`, `id_paccion`, `resultado`) VALUES ($numConsecutivo, $id_plan_accion, '".$form['resultados-plan-accion-'.$i]."')";
            }
            $query = $this->query($insert);
        }
        $this->terminate();
    }
    
    public function consultarProblemasDiagEmpresa($numConsecutivo){
        
    }
}
?>