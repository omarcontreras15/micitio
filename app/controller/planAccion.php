<?php
include_once "./app/controller/controller.php";
include_once "./app/model/planAccion.php";
class PlanAccion extends Controller{
    private $planAccionModel;
    private $view;
    private $menu;
    
    
    public function __construct() {
        $this->planAccionModel= new PlanAccionModel();
        $this->view = $this->getTemplate("./app/views/index.html");
        $this->menu= $this->getTemplate("./app/views/components/menu-login.html");
    }
    
    public function indexPlanAccion($accion){
        $contenido=$this->getTemplate("./app/views/PlanAccion/planAccion.html");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        if($accion=="agregar"){
            $this->view = $this->renderView($this->view, "{{TITULO}}","Agregar Plan De Acción");
            $contenido=$this->renderView($contenido,"{{ACCION_MAY}}","Agregar");
            $contenido=$this->renderView($contenido,"{{ACCION_MIN}}","agregar");
        }else{
            $this->view = $this->renderView($this->view, "{{TITULO}}","Consultar Plan De Acción");
            $contenido=$this->renderView($contenido,"{{ACCION_MAY}}","Consultar");
            $contenido=$this->renderView($contenido,"{{ACCION_MIN}}","consultar");
        }
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $contenido);
        $this->showView($this->view);
    }
    
    
    public function ventanaPlanAccionIdea($accion){
        $array=null;
        $ventana = $this->getTemplate("./app/views/PlanAccion/componentes/ventana-consultar-diag-idea.html");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        if($accion=="agregar"){
            $this->view = $this->renderView($this->view, "{{TITULO}}","Agregar Plan Acción");
            $ventana = $this->renderView($ventana, "{{TITULO_VENTANA}}", "Agregar Plan Acción Del Diagnostico Idea");
            $ventana = $this->renderView($ventana, "{{TITULO2}}","Seleccione el diagnostico que desea realizar su plan de accion.");
            $ventana = $this->renderView($ventana, "{{TITULO}}","Agregar Plan Acción");
        }else{
            $this->view = $this->renderView($this->view, "{{TITULO}}","Consultar Plan Acción");
            $ventana = $this->renderView($ventana, "{{TITULO_VENTANA}}", "Consultar Plan Acción Del Diagnostico Idea");
            $ventana = $this->renderView($ventana, "{{TITULO2}}","Seleccione el diagnostico que desea consultar su plan de accion.");
            $ventana = $this->renderView($ventana, "{{TITULO}}","Consultar Plan Acción");
        }
        
        // especificamos si la url va ser de consultar o agregar plan accion
        $ventana = $this->renderView($ventana, "{{URL}}",$accion);
        $array = $this->planAccionModel->consultarDiagIdea($accion);
        //reemplaza el contenido de la pagina dentro de la plantilla
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $ventana);
        
        $sizeArray=sizeof($array);
        $option="";
        $elementotabla = $this->getTemplate("./app/views/DiagnosticoIdea/componentes/elemento-tabla.html");
        
        if($sizeArray>0){
            foreach($array as $element) {
                $temp = $elementotabla;
                $temp = $this->renderView($temp, "{{NUMC}}", $element['Num_consecutivo']);
                $temp = $this->renderView($temp, "{{CC}}", $element['CC']);
                $temp = $this->renderView($temp, "{{IDEA}}", $element['Idea']);
                $temp = $this->renderView($temp, "{{FECHA}}", $element['Fecha']);
                $client = $this->planAccionModel->consultarDatosEmprendedor($element['CC']);
                $temp = $this->renderView($temp, "{{NOMBRE}}", $client['cl_nombre']." ".$client['cl_apellido']);
                $option .= $temp;
            }
            $this->view=$this->renderView($this->view, "{{OPTION}}",$option);
        }else{
            if($accion=="agregar")
            $this->view=$this->renderView($this->view, "{{OPTION}}", "<h2>No Existe Ningun Diagnóstico</h2>");
            else
            $this->view=$this->renderView($this->view, "{{OPTION}}", "<h2>No Existe Ningun Plan De Acción Registrado</h2>");
        }
        $this->showView($this->view);
    }
    
    public function ventanaPlanAccionEmpresa($accion){
        
        $array=null;
        $ventana = $this->getTemplate("./app/views/PlanAccion/componentes/ventana-consultar-diag-empresa.html");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        if($accion=="agregar"){
            $this->view = $this->renderView($this->view, "{{TITULO}}","Agregar Plan Acción");
            $ventana = $this->renderView($ventana, "{{TITULO_VENTANA}}", "Agregar Plan Acción Del Diagnostico Empresa");
            $ventana = $this->renderView($ventana, "{{TITULO2}}","Seleccione el diagnostico que desea realizar su plan de accion.");
            $ventana = $this->renderView($ventana, "{{TITULO}}","Agregar Plan Acción");
        }else{
            $this->view = $this->renderView($this->view, "{{TITULO}}","Consultar Plan Acción");
            $ventana = $this->renderView($ventana, "{{TITULO_VENTANA}}", "Consultar Plan Acción Del Diagnostico Empresa");
            $ventana = $this->renderView($ventana, "{{TITULO2}}","Seleccione el diagnostico que desea consultar su plan de accion.");
            $ventana = $this->renderView($ventana, "{{TITULO}}","Consultar Plan Acción");
            
        }
        // especificamos si la url va ser de consultar o agregar plan accion
        $ventana = $this->renderView($ventana, "{{URL}}",$accion);
        $array = $this->planAccionModel->consultarDiagEmpresa($accion);
        //reemplaza el contenido de la pagina dentro de la plantilla
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $ventana);
        //consulta el length del array que llega de la consulta
        $sizeArray = sizeof($array);
        $option = "";
        $elementotabla = $this->getTemplate("./app/views/DiagnosticoEmpresa/componentes/tabla-consulta.html");
        
        if($sizeArray>0){
            foreach ($array as $element){
                $temp = $elementotabla;
                $temp = $this->renderView($temp, "{{NUMC}}", $element['id_diagnostico_emp']);
                $temp = $this->renderView($temp, "{{NIT}}", $element['nit_empresa']);
                $temp = $this->renderView($temp, "{{FECHA}}", $element['fecha']);
                $temp = $this->renderView($temp, "{{SECTOR}}", $element['sector']);
                //ESTOS DATOS SE SACAN DE LA BASE DE DATOS DEL PROYECTO NUMERO UNO
                $empresadata = $this->planAccionModel->consultarDatosEmpresa($element['nit_empresa']);
                $temp = $this->renderView($temp, "{{EMPRESA}}", $empresadata['emp_nombre']);
                $temp = $this->renderView($temp, "{{RAZONSOCIAL}}", $empresadata['emp_razons']);
                $temp = $this->renderView($temp, "{{PRODUCTOS}}", $empresadata['emp_servicios']);
                $contact = $this->planAccionModel->consultarDatosCliente($element['nit_empresa']);
                $temp = $this->renderView($temp, "{{CONTACTO}}", $contact['cl_nombre']." ".$contact['cl_apellido']);
                $option .= $temp;
            }
            $this->view = $this->renderView($this->view, "{{OPTION}}", $option);
        }else{
            if($accion=="agregar")
            $this->view=$this->renderView($this->view, "{{OPTION}}", "<h2>No Existe Ningun Diagnóstico</h2>");
            else
            $this->view=$this->renderView($this->view, "{{OPTION}}", "<h2>No Existe Ningun Plan De Acción Registrado</h2>");
        }
        $this->showView($this->view);
    }
    
    public function seleccionarDiagPlanAccion($numConsecutivo, $tipo){
        $array=null;
        $cont=0;
        $allTablas="";
        $contenido=$this->getTemplate("./app/views/PlanAccion/planAccionModelo.html");
        $tablasProblemas=$this->getTemplate("./app/views/PlanAccion/componentes/tablas-problemas.html");
        $this->view = $this->renderView($this->view, "{{TITULO}}","Agregar Plan De Acción");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        //PRUEBAS
        if($tipo=="idea"){
            $array=$this->planAccionModel->consultarProblemasDiagIdea($numConsecutivo);
        }else{
            $array=$this->planAccionModel->consultarProblemasDiagEmpresa($numConsecutivo);
        }
        foreach ($array as $element) {
            $cont++;
            $temp=$this->renderView($tablasProblemas, "{{NUM_PROBLEMA}}",$cont);
            $temp=$this->renderView($temp, "{{NOM_PROBLEMA}}", $element);
            $temp=$this->renderView($temp, "{{CAUSAS}}", "");
            $temp=$this->renderView($temp, "{{EFECTOS}}", "");
            $temp=$this->renderView($temp, "{{SOLUCIONES}}", "");
            $allTablas.=$temp;
        }
        $contenido=$this->renderView($contenido, "{{CANT_PROBLEMAS}}",$cont);
        $contenido=$this->renderView($contenido, "{{TABLAS_PROBLEMAS}}",$allTablas);
        //
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $contenido);
        $this->view = $this->renderView($this->view, "{{ASESOR}}", $this->planAccionModel->consultarNombreAsesor());
        $this->view = $this->renderView($this->view, "{{NUM_CONSECUTIVO}}", $numConsecutivo);
        $this->view = $this->renderView($this->view, "{{TIPO_DIAG}}", $tipo);
        $this->showView($this->view);
    }
    
    public function agregarPlanAccion($form){
        
        //aqui se inserta el plan de accion retorna el id de ese plan de accion que se registro
        $id_plan_accion=$this->planAccionModel->insertarPlanAccion($form['num-consecutivo'], $form['obs_adicionales'], $form['que_sucedio'], $form['cumplio'], $form['alcanzaron_obj'], $form['tipo'], $form['asesor']);
        
        //aqui registra los problemas del plan de accion y retorna un array con el id de todos los problemas insertados
        $ids_problemas=$this->planAccionModel->insertarProblemas($form, $id_plan_accion);
        //aqui se inserta todas la tareas de cada uno de las soluciones del plan de accion
        $this->planAccionModel->insertarTareas($form, $id_plan_accion, $ids_problemas);
        //aqui  se insertan todas las soluciones del plan de accion
        $this->planAccionModel->insertarResultados($form, $id_plan_accion);
        //enviamos un msj de registro exitoso y redirigimos...
        echo "<script>alert('Se ha registrado con exito el plan de accion del diagnostico de la ".$form['tipo']."\\n '); window.location='index.php?mode=agregar-plan-accion';</script>";
    }


    public function seguimientoPlanAccion($numConsecutivo, $tipo){
        $contenidoProblemas="";
        $tablasObj="";
        
        $contenido=$this->getTemplate("./app/views/SeguimientoPlanAccion/seguimientoPlanAccion.html");
        $plantillaProblemas=$this->getTemplate("./app/views/SeguimientoPlanAccion/tabla-problemas.html");
        $plantillaObj=$this->getTemplate("./app/views/SeguimientoPlanAccion/tabla-objetivos.html");
        $plantillaTarea=$this->getTemplate("./app/views/SeguimientoPlanAccion/tabla-tarea.html");      
        $plantillaFormTarea=$this->getTemplate("./app/views/SeguimientoPlanAccion/form-tarea.html");
        $plantillaVerTarea=$this->getTemplate("./app/views/SeguimientoPlanAccion/form-ver-tarea.html");
        $this->view = $this->renderView($this->view, "{{TITULO}}","Segumiento Plan De Acción");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);

        $filaPlan=$this->planAccionModel->consultarPlanAccion($tipo,$numConsecutivo);
        $contenido=$this->renderView($contenido, "{{ASESOR}}",$filaPlan['asesor']);

         $arrayProblemas=$this->planAccionModel->consultarProblema ($tipo, $numConsecutivo);
        $cont=0;
        $completos=0;
        foreach ($arrayProblemas as $value) {
            $cont++;
            $temp=$this->renderView($plantillaProblemas, "{{NUM_PROBLEMA}}",$cont);
            $temp=$this->renderView($temp, "{{NOM_PROBLEMA}}",$value['problema']);
            $contenidoProblemas.=$temp;
            
            $temp=$this->renderView($plantillaObj, "{{NUMERO_OBJETIVO}}",$cont);
            $temp=$this->renderView($temp, "{{OBJETIVO}}",$value['solucion_obj']);
            $temp=$this->renderView($temp, "{{FECHA_REUNION}}",$value['fecha_reunion']);
            $temp=$this->renderView($temp, "{{FECHA_PROX_REUNION}}",$value['fecha_prox_reunion']);

            $arrayTareas=$this->planAccionModel->consultarTarea($tipo, $numConsecutivo, $value['id_problema']);
            $tareas="";
            $cont2=0;
            $estado="verde";
            
            foreach ($arrayTareas as $value2) {
             $temp2="";
             $cont2++;
              if(!isset($value2['url_archivo'])){
                $temp2=$this->renderView($plantillaTarea, "{{FORMULARIO_TAREA}}",$plantillaFormTarea);
             }else{
                 $temp2=$this->renderView($plantillaVerTarea, "{{URL_ARCHIVO}}",$value2['url_archivo']);
                 $temp2=$this->renderView($temp2, "{{NOM_TAREA}}",$value2['tarea']);
                 $temp2=$this->renderView($plantillaTarea, "{{FORMULARIO_TAREA}}",$temp2);
             }
             $temp2=$this->renderView($temp2, "{{NUMERO_TAREA}}",$cont2);
             $temp2=$this->renderView($temp2, "{{NOMBRE_TAREA}}",$value2['tarea']);
             $temp2=$this->renderView($temp2, "{{FECHA_TAREA}}",$value2['fecha_entrega']);
             $temp2=$this->renderView($temp2, "{{ESTADO_TAREA}}",$value2['estado']);
             $temp2=$this->renderView($temp2, "{{NUM_CONSECUTIVO}}",$numConsecutivo);
             $temp2=$this->renderView($temp2, "{{ID_PROBLEMA}}",$value2['id_problema']);
             $temp2=$this->renderView($temp2, "{{ID_TAREA}}",$value2['id_tarea']);
             $temp2=$this->renderView($temp2, "{{TIPO}}",$tipo);
             $tareas.=$temp2;

             if(($estado!="rojo" && $value2['estado']!="verde") || ($estado=="amarillo" && $value2['estado']=="rojo")){
                $estado=$value2['estado'];
                }
                
            }
            
            if($estado=="amarillo" || $estado=="verde"){
                $completos++;
            }
            //colocamos el estado a las tablas objetivos y a la tabla problemas 
            $temp=$this->renderView($temp, "{{ESTADO_PROBLEMA}}",$estado);
            $contenidoProblemas=$this->renderView($contenidoProblemas, "{{ESTADO_PROBLEMA}}",$estado);
            $temp=$this->renderView($temp, "{{TABLA_TAREA}}",$tareas);
            $tablasObj.=$temp;
        }
        
        $porcentaje=round((($completos*100)/$cont),2);
        $contenido=$this->renderView($contenido, "{{PORCENTAJE_OBJETIVO}}",$porcentaje);
        $contenido=$this->renderView($contenido, "{{CONTENIDO_PROBLEMAS}}",$contenidoProblemas);
        $contenido=$this->renderView($contenido, "{{TABLA_OBJETIVOS}}",$tablasObj);
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $contenido);
        $this->showView($this->view);

    }

    public function subirEvidencia($numConsecutivo, $idObjetivo, $idTarea, $tipo){
        $urlArchivo= $this->agregarArchivo();
        $this->planAccionModel->actualizarUrlEvidenciaTarea($numConsecutivo, $idObjetivo, $idTarea, $tipo, $urlArchivo);
        $json=$this->recargarPlanAccion($numConsecutivo, $tipo);
        $this->showView($json);
    }

    public function eliminarEvidencia($numConsecutivo, $idObjetivo, $idTarea, $tipo){
        $this->planAccionModel->eliminarEvidenciaTarea($numConsecutivo, $idObjetivo, $idTarea, $tipo);
         $json=$this->recargarPlanAccion($numConsecutivo, $tipo);
         $this->showView($json);
    }

    public function recargarPlanAccion($numConsecutivo, $tipo){

        $contenidoProblemas="";
        $tablasObj="";
        $jsonArray= array();
        
        $plantillaProblemas=$this->getTemplate("./app/views/SeguimientoPlanAccion/tabla-problemas.html");
        $plantillaObj=$this->getTemplate("./app/views/SeguimientoPlanAccion/tabla-objetivos.html");
        $plantillaTarea=$this->getTemplate("./app/views/SeguimientoPlanAccion/tabla-tarea.html");
        $plantillaFormTarea=$this->getTemplate("./app/views/SeguimientoPlanAccion/form-tarea.html");
        $plantillaVerTarea=$this->getTemplate("./app/views/SeguimientoPlanAccion/form-ver-tarea.html");
       
        $filaPlan=$this->planAccionModel->consultarPlanAccion($tipo,$numConsecutivo);
        $arrayProblemas=$this->planAccionModel->consultarProblema ($tipo, $numConsecutivo);

        $cont=0;
        $completos=0;
        foreach ($arrayProblemas as $value) {
            $cont++;
            $temp=$this->renderView($plantillaProblemas, "{{NUM_PROBLEMA}}",$cont);
            $temp=$this->renderView($temp, "{{NOM_PROBLEMA}}",$value['problema']);
            $contenidoProblemas.=$temp;
            
            $temp=$this->renderView($plantillaObj, "{{NUMERO_OBJETIVO}}",$cont);
            $temp=$this->renderView($temp, "{{OBJETIVO}}",$value['solucion_obj']);
            $temp=$this->renderView($temp, "{{FECHA_REUNION}}",$value['fecha_reunion']);
            $temp=$this->renderView($temp, "{{FECHA_PROX_REUNION}}",$value['fecha_prox_reunion']);

            $arrayTareas=$this->planAccionModel->consultarTarea($tipo, $numConsecutivo, $value['id_problema']);
            $tareas="";
            $cont2=0;
            $estado="verde";

            foreach ($arrayTareas as $value2) {
             $cont2++;
             $temp2="";
              if(!isset($value2['url_archivo'])){
                $temp2=$this->renderView($plantillaTarea, "{{FORMULARIO_TAREA}}",$plantillaFormTarea);
             }else{
                 $temp2=$this->renderView($plantillaVerTarea, "{{URL_ARCHIVO}}",$value2['url_archivo']);
                 $temp2=$this->renderView($temp2, "{{NOM_TAREA}}",$value2['tarea']);
                 $temp2=$this->renderView($plantillaTarea, "{{FORMULARIO_TAREA}}",$temp2);
             }

             $temp2=$this->renderView($temp2, "{{NUMERO_TAREA}}",$cont2);
             $temp2=$this->renderView($temp2, "{{NOMBRE_TAREA}}",$value2['tarea']);
             $temp2=$this->renderView($temp2, "{{FECHA_TAREA}}",$value2['fecha_entrega']);
             $temp2=$this->renderView($temp2, "{{ESTADO_TAREA}}",$value2['estado']);
             $temp2=$this->renderView($temp2, "{{NUM_CONSECUTIVO}}",$numConsecutivo);
             $temp2=$this->renderView($temp2, "{{ID_PROBLEMA}}",$value2['id_problema']);
             $temp2=$this->renderView($temp2, "{{ID_TAREA}}",$value2['id_tarea']);
             $temp2=$this->renderView($temp2, "{{TIPO}}",$tipo);
             $tareas.=$temp2;

             if(($estado!="rojo" && $value2['estado']!="verde") || ($estado=="amarillo" && $value2['estado']=="rojo")){
                $estado=$value2['estado'];
                }
                
            }
            
            if($estado=="amarillo" || $estado=="verde"){
                $completos++;
            }
            //colocamos el estado a las tablas objetivos y a la tabla problemas 
            $temp=$this->renderView($temp, "{{ESTADO_PROBLEMA}}",$estado);
            $contenidoProblemas=$this->renderView($contenidoProblemas, "{{ESTADO_PROBLEMA}}",$estado);
            $temp=$this->renderView($temp, "{{TABLA_TAREA}}",$tareas);
            $tablasObj.=$temp;
        }
        
        $porcentaje=round((($completos*100)/$cont),2);
        
        $jsonArray['problemas']=$contenidoProblemas;
        $jsonArray['objetivos']=$tablasObj;
        $jsonArray['porcentaje']=$porcentaje;

        return json_encode($jsonArray);
    }

    //metodo para mover un archivo traido del formulario a la carpeta upload
  private function agregarArchivo(){
    $urlArchivo="";
    if (is_uploaded_file($_FILES['evidencia']['tmp_name'])){
        $nombreDirectorio = "public/upload/";
        $nombreFichero = $_FILES['evidencia']['name'];
        //opcional
        $tipoArchivo=$_FILES['evidencia']['type'];
        $extencionFichero= ".". substr(strrchr($tipoArchivo, "/"), 1);
        //
        //id unico de tiempo
        $idUnico=time();
        
        $urlArchivo = $nombreDirectorio . $idUnico . "_" . $nombreFichero;
        move_uploaded_file($_FILES['evidencia']['tmp_name'], $urlArchivo);
        
            return $urlArchivo;
        }else{
            return false;
            }
    }
    
    
    public function consultarPlanAccion($numConsecutivo, $tipo){
        $tablasProblemas="";
        $tablasObj="";
        $tablasResultados="";
        
        $contenido=$this->getTemplate("./app/views/PlanAccion/consultarPlanAccion.html");
        $plantillaProblemas=$this->getTemplate("./app/views/PlanAccion/componentes/consultas/tabla-problemas.html");
        $plantillaObj=$this->getTemplate("./app/views/PlanAccion/componentes/consultas/tabla-objetivos.html");
        $plantillaTarea=$this->getTemplate("./app/views/PlanAccion/componentes/consultas/tabla-tareas.html");
        $plantillaResultado=$this->getTemplate("./app/views/PlanAccion/componentes/consultas/tabla-resultados.html");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        $this->view = $this->renderView($this->view, "{{TITULO}}","Consultar Plan De Acción");
        $contenido=$this->renderView($contenido, "{{NUM_CONSECUTIVO}}",$numConsecutivo);
        $contenido=$this->renderView($contenido, "{{TIPO}}", $tipo);
        
        $filaPlan=$this->planAccionModel->consultarPlanAccion($tipo,$numConsecutivo);
        $contenido=$this->renderView($contenido, "{{ASESOR}}",$filaPlan['asesor']);
        $contenido=$this->renderView($contenido, "{{FECHA_REGISTRO}}",$filaPlan['fecha_registro']);
        $contenido=$this->renderView($contenido, "{{CUMPLIO}}",$filaPlan['cumplio']);
        $contenido=$this->renderView($contenido, "{{ALCANZARON_OBJ}}",$filaPlan['alcanzaron_obj']);
        $contenido=$this->renderView($contenido, "{{QUE_SUCEDIO}}",$filaPlan['que_sucedio']);
        $contenido=$this->renderView($contenido, "{{OBS_ADICIONALES}}",$filaPlan['obs_adicionales']);
        
        
        $arrayProblemas=$this->planAccionModel->consultarProblema ($tipo, $numConsecutivo);
        $cont=0;
        foreach ($arrayProblemas as $value) {
            $cont++;
            $temp=$this->renderView($plantillaProblemas, "{{NUM_PROBLEMA}}",$cont);
            $temp=$this->renderView($temp, "{{PROBLEMAS}}",$value['problema']);
            $temp=$this->renderView($temp, "{{CAUSAS}}",$value['causa']);
            $temp=$this->renderView($temp, "{{EFECTOS}}",$value['efecto']);
            $temp=$this->renderView($temp, "{{SOLUCIONES}}",$value['solucion_obj']);
            $tablasProblemas.=$temp;
            
            $temp=$this->renderView($plantillaObj, "{{NUMERO_OBJETIVO}}",$cont);
            $temp=$this->renderView($temp, "{{OBJETIVO}}",$value['solucion_obj']);
            $temp=$this->renderView($temp, "{{FECHA_REUNION}}",$value['fecha_reunion']);
            $temp=$this->renderView($temp, "{{FECHA_PROX_REUNION}}",$value['fecha_prox_reunion']);

            $arrayTareas=$this->planAccionModel->consultarTarea($tipo, $numConsecutivo, $value['id_problema']);
            $tareas="";
            $cont2=0;
            foreach ($arrayTareas as $value2) {
             $cont2++;
             $temp2=$this->renderView($plantillaTarea, "{{NUMERO_TAREA}}",$cont2);
             $temp2=$this->renderView($temp2, "{{TAREA}}",$value2['tarea']);
             $temp2=$this->renderView($temp2, "{{FECHA_TAREA}}",$value2['fecha_entrega']);
             $tareas.=$temp2;
            }
            $temp=$this->renderView($temp, "{{TABLA_TAREA}}",$tareas);
            $tablasObj.=$temp;
        }

        $arrayResultado=$this->planAccionModel->consultarResultado($tipo, $numConsecutivo);

        $cont=0;
        foreach ($arrayResultado as  $value) {
            $cont++;
            $tempResultados=$this->renderView($plantillaResultado, "{{NUM_RESULTADO}}",$cont);
            $tempResultados=$this->renderView($tempResultados, "{{RESULTADO}}",$value);
            $tablasResultados.=$tempResultados;
        }
        
        $contenido=$this->renderView($contenido, "{{TABLAS_PROBLEMAS}}",$tablasProblemas);
        $contenido=$this->renderView($contenido, "{{TABLAS_OBJETIVOS_PROBLEMAS}}",$tablasObj);
        $contenido=$this->renderView($contenido, "{{FILAS_RESULTADOS}}",$tablasResultados);
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $contenido);
        $this->showView($this->view);
    }
    
}
?>