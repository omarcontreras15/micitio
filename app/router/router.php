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
                         $this->planAccion->agregarPlanAccion();   
                        }       
                        break;
                        
                        case "seleccionar-consultar-diagnostico-idea":
                        if($_GET["id"]==="0"){
                            $this->diagnosticoIdea->ventanaConsultarDiag();
                        }else{
                            $this->diagnosticoIdea->consultarForm($_GET["id"]);
                        }                        
                        break;

                        case "seleccionar-emprendedor":
                        if($_GET["id"]==="0"){
                            $this->diagnosticoIdea->seleccionarEmprendedor();
                        }else{
                            $this->diagnosticoIdea->agregarDiagnosticoIdea($_GET["id"]);
                        }

                        case "seleccionar-empresa":
                        if($_GET["id"]==="0"){
                            $this->diagnosticoEmpresa->seleccionarEmpresa();
                        }else{
                            $this->diagnosticoEmpresa->agregarDiagnosticoEmpresa($_GET["id"]);
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
                    case "procesar-add-diag-idea":
                     $this->diagnosticoIdea->agregarFormDiagnosticoIdea($_POST);
                        break;

                    case "consultar-cc-diag-idea":
                     $this->diagnosticoIdea->consultarCcDiagIdea($_POST["cc"]);
                        break;

                    case "procesar-edit-diag-idea":
                    $this->diagnosticoIdea->editarFormDiagnosticoIdea($_POST);
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