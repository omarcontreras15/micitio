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
    public function consultarDiagIdea($accion){
        $consulta="";
        $this->connect();
        if($accion=="agregar")
        $consulta = "SELECT Num_consecutivo, CC, Idea, Fecha FROM diagnostico_idea where Num_consecutivo not in (select diag_idea from plan_accion_idea)";
        else
        $consulta = "SELECT Num_consecutivo, CC, Idea, Fecha FROM diagnostico_idea where Num_consecutivo in (select diag_idea from plan_accion_idea)";


        $query = $this->query($consulta);
        $this->terminate();
        $array=array();
        while($row = mysqli_fetch_array($query)){
            array_unshift($array,$row);
        }
        return $array;
    }
    
    
    //retorna una lista con los datos de los diagnosticos de empresa sin plan de accion en agregar y en consultar con plan de accion para la tabla de seleccionar diagnostico a consultar
    public function consultarDiagEmpresa($accion){
        $consulta="";
        $this->connect();
        if($accion=="agregar")
        $consulta = "SELECT id_diagnostico_emp, fecha, sector, nit_empresa FROM diagnostico_empresa where id_diagnostico_emp not in (select diag_empresa from plan_accion_empresa)";
        else
        $consulta = "SELECT id_diagnostico_emp, fecha, sector, nit_empresa FROM diagnostico_empresa where id_diagnostico_emp  in (select diag_empresa from plan_accion_empresa)";

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

    
    public function insertarPlanAccion($numConsecutivo, $obs_adicionales, $que_sucedio, $cumplio, $alcanzaron_obj, $tipo, $asesor){
        $this->connect();
        $insert="";
        if($tipo=="idea"){
            $insert = "INSERT INTO `plan_accion_idea` (`diag_idea`, `obs_adicionales`,`asesor`, `que_sucedio`, `cumplio`, `alcanzaron_obj`) VALUES ($numConsecutivo, '$obs_adicionales','$asesor', '$que_sucedio', '$cumplio', '$alcanzaron_obj')";
        }else{
            $insert = "INSERT INTO `plan_accion_empresa` (`diag_empresa`, `obs_adicionales`,`asesor`, `que_sucedio`, `cumplio`, `alcanzaron_obj`) VALUES ($numConsecutivo, '$obs_adicionales','$asesor', '$que_sucedio', '$cumplio', '$alcanzaron_obj')";
        }
        $query = $this->query($insert);        
        //consulta ultimo id
        $consulta="";
        if($tipo=="idea"){
            $consulta="SELECT id_paccion from plan_accion_idea where diag_idea=$numConsecutivo";
        }else{
            $consulta="SELECT id_paccion from plan_accion_empresa where diag_empresa=$numConsecutivo";
        }
        $consulta =mysqli_fetch_array($this->query($consulta));
        $this->terminate();
        return $consulta['id_paccion'];
    }

    
    public function actualizarPlanAccion ($id, $obs_adicionales, $que_sucedio, $cumplio, $alcanzaron_obj, $tipo, $asesor) {
        if($tipo == 'idea'){
            $consulta = "UPDATE plan_accion_idea SET obs_adicionales = $obs_adicionales, asesor = $asesor, que_sucedio = $que_sucedio, cumplio = $cumplio WHERE diag_idea = $id";
        }else{
            $consulta = "UPDATE plan_accion_empresa SET obs_adicionales = $obs_adicionales, asesor = $asesor, que_sucedio = $que_sucedio, cumplio = $cumplio WHERE diag_empresa = $id";
        }
        $this->connect();        
        $query = $this->query($consulta);
        $this->terminate();
    }



    //consulta los posibles problemas que se van a listar para el plan de accion de la empresa seleccionada
    public function consultarProblemasDiagEmpresa($numConsecutivo){
        $this->connect();
        $array=array();
        //consulta de los puntos negativos en el diagnostico
        $consulta1 = "SELECT mision, vision, objetivos, estrategias, plan_accion, participacion_empleados, empleados_conocen, estrategias_crecimiento, organigrama, procesos_documentados, procesos_evaluacion, procesos_automatizar, max_colaboradores, clima_laboral, motivacion_empleados, define_acciones, sistema_control, comparar_planeado_eje, clave_desempenio, seguimiento_indicadores, contrata_direc_personal, combina_forma_contratar, procesos_establecidos, recompensas_establecidas, empleados_necesarios, depto_mercadeo_ventas, msj_marketing_claro, plan_mercadeo, implementa_plan, cronograma_marketing, perfil_cliente, clasificacion_cliente, web_ventas, tecnologia_seguimiento, sistema_compatibilidad, contabilidad_aldia, aplica_normas_contabilidad, planificacion_financiera_formal, margen_rentabilidad, margen_rentabilidad_pos, ingresos_cumplen_objetivos, suficiente_capital, flujo_caja_positivo, costo_producto, presupuesto_estable, desiciones_analisis, programa_produccion, corresponde_demanda_mercado, produccion_planes, pontrola_calidad_producto, problemas_abastecimiento, Adquisicion_maquinaria, Planes_contingencia_maprima, Inventarios_periodicos, Seguimiento_inventarios, eficiente_dist_trabajo FROM diagnostico_empresa WHERE id_diagnostico_emp =$numConsecutivo";
        $query1 = $this->query($consulta1);
        //consulta de la descripcion de cada posible punto negativo
        $consulta2 = "SELECT id, descripcion FROM desc_problemas";
        $query2 = $this->query($consulta2);
        //consulta de los puntos problematicos de la empresa
        $consulta3 = "SELECT nombre FROM puntos_problematicos p, diagxpuntos d WHERE d.id_diag_empresa = $numConsecutivo AND d.Codigo_puntos = p.Codigo";
        $query3 = $this->query($consulta3);
        //consulta aspectos a mejorar de la empresa
        $consulta4 = "SELECT descripcion from lista_dificultades_e where id_diagnostico_emp = $numConsecutivo";
        $query4 = $this->query($consulta4);

        $this->terminate();
        $row = mysqli_fetch_array($query1);
        
        while($desc = mysqli_fetch_array($query2)){
            if($row[$desc['id']]!='Si'){
                array_push($array, $desc['descripcion']);
            }
            if($desc['id']=='problemas_abastecimiento' && $row[$desc['id']]=='Si'){
                array_push($array, $desc['descripcion']);
            }
        }
        while($punto = mysqli_fetch_array($query3)){
            array_push($array, $punto['nombre']);
        }
        while($aspecto = mysqli_fetch_array($query4)){
            array_push($array, $aspecto['descripcion']);
        }

        return $array;

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
    
    
    public function consultarPlanAccion ($tipo, $id) {
        if($tipo == 'idea'){
            $consulta = "SELECT id_paccion, asesor, obs_adicionales, que_sucedio, cumplio, alcanzaron_obj, fecha_registro FROM plan_accion_idea WHERE diag_idea = $id";
        }else{
            $consulta = "SELECT id_paccion, asesor, obs_adicionales, que_sucedio, cumplio, alcanzaron_obj, fecha_registro FROM plan_accion_empresa WHERE diag_empresa = $id";
        }
        $this->connect();        
        $query = $this->query($consulta);
        $row=mysqli_fetch_array($query);
        $this->terminate();
        return $row;
    }

    
    public function consultarProblema ($tipo, $id) {
        if($tipo == 'idea'){
            $consulta = "SELECT id_problema, estado, problema, causa, efecto, solucion_obj, fecha_reunion, fecha_prox_reunion FROM problema_idea WHERE diag_idea = $id ORDER BY id_problema ASC";
        }else{
            $consulta = "SELECT id_problema, estado, problema, causa, efecto, solucion_obj, fecha_reunion, fecha_prox_reunion FROM problema_empresa WHERE diag_empresa = $id ORDER BY id_problema ASC";
        }
        $this->connect();        
        $query = $this->query($consulta);
        $this->terminate();
        $array = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push($array,$row);
        }
        return $array;
    }

    public function eliminarProblema ($tipo, $id) {
        if($tipo == 'idea'){
            $consulta = "DELETE FROM problema_idea WHERE diag_idea = $id ORDER BY id_problema ASC";
        }else{
            $consulta = "DELETE FROM problema_empresa WHERE diag_empresa = $id ORDER BY id_problema ASC";
        }
        $this->connect();        
        $query = $this->query($consulta);
        $this->terminate();
    }


    public function consultarTarea ($tipo, $id_diagnostico, $id_problema) {
        if($tipo == 'idea'){
            $consulta = "SELECT id_problema, id_tarea, tarea, fecha_entrega FROM tarea_idea WHERE diag_idea = $id_diagnostico AND id_problema = $id_problema";
        }else{
            $consulta = "SELECT id_problema, id_tarea, tarea, fecha_entrega FROM tarea_empresa WHERE diag_empresa = $id_diagnostico AND id_problema = $id_problema";
        }
        $this->connect();        
        $query = $this->query($consulta);
        $this->terminate();
        $array = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push($array,$row);
        }
        return $array;
    }

    public function eliminarTarea ($tipo, $id_diagnostico) {
        if($tipo == 'idea'){
            $consulta = "DELETE FROM tarea_idea WHERE diag_idea = $id_diagnostico";
        }else{
            $consulta = "DELETE FROM tarea_empresa WHERE diag_empresa = $id_diagnostico";
        }
        $this->connect();        
        $query = $this->query($consulta);
        $this->terminate();
    }

    public function consultarResultado ($tipo, $id_diagnostico) {
        if($tipo == 'idea'){
            $consulta = "SELECT id_resultado, resultado FROM resultado_idea WHERE diag_idea = $id_diagnostico";    
        }else{
            $consulta = "SELECT id_resultado, resultado FROM resultado_empresa WHERE diag_empresa = $id_diagnostico";
        }
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();
        $array = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push($array,$row['resultado']);
        }
        return $array;
    }


   /* public function eliminarResultado ($tipo, $id_diagnostico) {
        if($tipo == 'idea'){
            $consulta = "DELETE FROM resultado_idea WHERE diag_idea = $id_diagnostico";    
        }else
            $consulta = "DELETE FROM resultado_empresa WHERE diag_empresa = $id_diagnostico";
        }
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();
    }*/


}
?>