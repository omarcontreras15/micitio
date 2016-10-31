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
    
    public function agregarPlanAccion(){
        $contenido=$this->getTemplate("./app/views/PlanAccion/planAccion.html");
        $tablasProblemas=$this->getTemplate("./app/views/PlanAccion/componentes/tablas-problemas.html");
        $this->view = $this->renderView($this->view, "{{TITULO}}","Agregar Plan De Acción");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        //PRUEBAS
       $contenido=$this->renderView($contenido, "{{CANT_PROBLEMAS}}",1);
       $tablasProblemas=$this->renderView($tablasProblemas, "{{NUM_PROBLEMA}}",1);
       $contenido=$this->renderView($contenido, "{{TABLAS_PROBLEMAS}}",$tablasProblemas);
        //
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $contenido);
        $this->view = $this->renderView($this->view, "{{ASESOR}}", $this->planAccionModel->consultarNombreAsesor());
        $this->showView($this->view);
    }
}
?>