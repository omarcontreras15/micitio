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
            $ventana = $this->renderView($ventana, "{{TITULO2}}","Seleccione el diagnostico que desea realizar el plan de accion.");
            $ventana = $this->renderView($ventana, "{{TITULO}}","Agregar Plan Acción");
        }else{
            $this->view = $this->renderView($this->view, "{{TITULO}}","Consultar Plan Acción");
            $ventana = $this->renderView($ventana, "{{TITULO_VENTANA}}", "Consultar Plan Acción Del Diagnostico Idea");
            $ventana = $this->renderView($ventana, "{{TITULO2}}","Seleccione el diagnostico que desea consultar el plan de accion.");
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
            $ventana = $this->renderView($ventana, "{{TITULO2}}","Seleccione el diagnostico que desea realizar el plan de accion.");
            $ventana = $this->renderView($ventana, "{{TITULO}}","Agregar Plan Acción");
        }else{
            $this->view = $this->renderView($this->view, "{{TITULO}}","Consultar Plan Acción");
            $ventana = $this->renderView($ventana, "{{TITULO_VENTANA}}", "Consultar Plan Acción Del Diagnostico Empresa");
            $ventana = $this->renderView($ventana, "{{TITULO2}}","Seleccione el diagnostico que desea consultar el plan de accion.");
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
    
    
}
?>