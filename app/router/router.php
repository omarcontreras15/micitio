<?php

    class Router {

        public $user;
        public $diagnosticoIdea;
        public $diagnosticoEmpresa;
        public $planAccion;

        public function __construct() {
            $this->user = new User();
            $this->diagnosticoIdea =new DiagnosticoIdea();
            $this->diagnosticoEmpresa =new DiagnosticoEmpresa();
            $this->planAccion= new PlanAccion();

        }

        public function router() {
            
            if(isset($_GET["mode"])) {
              switch ($_GET["mode"]) {
                    case "iniciarSesion":
                       $this->user->inicioSesion();
                        break;
                    case "cerrarSesion":
                        session_destroy();
                        header("Location:index.php");
                        break;
                 case "agregar-diagnostico-idea":
                        if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();  
                        }else{
                            $this->diagnosticoIdea->seleccionarEmprendedor();        
                        } 
                      break;

                 case "editar-diagnostico-idea":
                        if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();
                        }else{
                            $this->diagnosticoIdea->editarForm($_GET["Num_consecutivo"]);
                        }
                        break;

                    case "consultar-diagnostico-idea":
                        if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();
                        }else{
                            $this->diagnosticoIdea->ventanaConsultarDiag();
                        }
                        break;

                        case "consultar-diagnostico-empresa":
                        if (!isset($_SESSION['user_id'])) {
                            $this->user->inicioSesion();
                        }else{
                            $this->diagnosticoEmpresa->ventanaConsultarDiag();
                        }
                        break;

                          case "agregar-diagnostico-empresa":
                        if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();
                        }else{
                            $this->diagnosticoEmpresa->seleccionarEmpresa();        
                        } 
                        break;

                        case "agregar-plan-accion":
                             if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();
                        }else{
                         $this->planAccion->indexPlanAccion();   
                        }       
                        break;
                        
                        case "seleccionar-consultar-diagnostico-idea":
                        if($_GET["id"]==="0"){
                            $this->diagnosticoIdea->ventanaConsultarDiag();
                        }else{
                            $this->diagnosticoIdea->consultarForm($_GET["id"]);
                        }                        
                        break;

                        case "seleccionar-consultar-diagnostico-empresa":
                        if($_GET['id']=="0"){
                            $this->diagnosticoEmpresa->ventanaConsultarDiag();
                        }else{
                            $this->diagnosticoEmpresa->consultarForm($_GET['id']);
                        }
                        break;
                        
                        case "agregar-plan-accion-idea":
                          if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();
                        }else{
                         $this->planAccion->ventanaAgregarPlanAccionIdea();   
                        }       
                        break;

                        case "agregar-plan-accion-empresa":
                          if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();
                        }else{
                         $this->planAccion->ventanaAgregarPlanAccionEmpresa();   
                        }       
                        break;

                        case "seleccionar-consultar-diagnostico-idea-plan-accion":
                        if($_GET["id"]==="0"){
                            $this->planAccion->ventanaAgregarPlanAccionIdea();   
                        }else{
                             $this->planAccion->seleccionarDiagPlanAccion($_GET['id'], $_GET['tipo']);
                        }                        
                        break;

                        case "seleccionar-consultar-diagnostico-empresa-plan-accion":
                        if($_GET['id']=="0"){
                            $this->planAccion->ventanaAgregarPlanAccionEmpresa();
                        }else{    
                             $this->planAccion->seleccionarDiagPlanAccion($_GET['id'],$_GET['tipo']);
                        }
                        break;

                        case "seleccionar-emprendedor":
                        if($_GET["id"]==="0"){
                            $this->diagnosticoIdea->seleccionarEmprendedor();
                        }else{
                            $this->diagnosticoIdea->agregarDiagnosticoIdea($_GET["id"]);
                        }
                        break;

                        case "seleccionar-empresa":
                        if($_GET["id"]==="0"){
                            $this->diagnosticoEmpresa->seleccionarEmpresa();
                        }else{
                            $this->diagnosticoEmpresa->agregarDiagnosticoEmpresa($_GET["id"]);
                        }
                        break; 

                        case "consultarDEmpresa":
                            if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();
                        }else{
                            $this->diagnosticoEmpresa->mostrarConsulta();
                        }
                            break; 

                       case "editar-diagnostico-empresa":
                        if(!isset($_SESSION["user_id"])){
                            $this->user->inicioSesion();
                        }else{
                            $this->diagnosticoEmpresa->editarForm($_GET["Num_consecutivo"]);
                        }
                        break;                      
                                      
                default:
                      header("Location:index.php");
                      break;
        }
            } else if(isset($_POST["mode"])) {
                  switch ($_POST["mode"]) {
                    case "login":
                       $this->user->login($_POST["username"], $_POST["password"]);
                        break;
                    
                    case "consultar-cc-diag-idea":
                     $this->diagnosticoIdea->consultarCcDiagIdea($_POST["cc"]);
                        break;

                    case "procesar-edit-diag-idea":
                    $this->diagnosticoIdea->editarFormDiagnosticoIdea($_POST);
                        break;

                    case "paso1-idea":
                    $this->diagnosticoIdea->guardarPaso1Idea($_POST);
                    break;

                    case "paso2-idea":
                    $this->diagnosticoIdea->guardarPaso2Idea($_POST);
                    break;

                    case "paso3-idea":
                    $this->diagnosticoIdea->guardarPaso3Idea($_POST);
                    break;

                    case "paso4-idea":
                    $this->diagnosticoIdea->guardarPaso4Idea($_POST);
                    break;

                    case "paso5-idea":
                    $this->diagnosticoIdea->guardarPaso5Idea($_POST);
                    break;

                    case "paso6-idea":
                    $this->diagnosticoIdea->guardarPaso6Idea($_POST);
                    break;

                    case "paso7-idea":
                    $this->diagnosticoIdea->guardarPaso7Idea($_POST);
                    break;

                    case "paso8-idea":
                    $this->diagnosticoIdea->guardarPaso8Idea($_POST);
                    break;

                    case "paso9-idea":
                    $this->diagnosticoIdea->agregarFormDiagnosticoIdea($_POST);
                    break;

                    case "procesar-add-diag-empresa":
                    $this->diagnosticoEmpresa->agregarFormDiagnosticoEmpresa($_POST);
                    break;

                    case "procesar-edit-diag-empresa":
                    $this->diagnosticoEmpresa->editarFormDiagnosticoEmpresa($_POST);
                    break;

                    case "agregar-plan-accion":
                            $this->planAccion->agregarPlanAccion($_POST);             
                    break;

                default:
                          
                      header("Location:index.php");
                      break;
                      }  
            } else {
              $this->user->index();  
            }
        }

      
    }

?>