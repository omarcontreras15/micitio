<?php

include_once "./app/controller/controller.php";
include_once "./app/model/diagnosticoEmpresa.php";
include_once "./app/model/DTO/diagnosticoEmpresaDTO.php";

class DiagnosticoEmpresa extends Controller {
    
    private $diagnosticoEmpresaModel;
    private $view;
    private $menu;
    
    
    public function __construct() {
        $this->diagnosticoEmpresaModel= new diagnosticoEmpresaModel();
        $this->view = $this->getTemplate("./app/views/index.html");
        $this->menu = $this->getTemplate("./app/views/components/menu-login.html");
        
    }
    
    public function agregarDiagnosticoEmpresa($nit){
        $form = $this->getTemplate("./app/views/DiagnosticoEmpresa/diagnosticoEmpresa.html");
        $this->view = $this->renderView($this->view, "{{TITULO}}","Agregar Diagnostico Empresa");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $form);
        $this->view = $this->renderView($this->view, "{{ASESOR}}", $this->diagnosticoEmpresaModel->consultarNombreAsesor());
        $this->view = $this->renderView($this->view, "{{nit_empresa}}", $nit);
        $array = $this->diagnosticoEmpresaModel->consultarDatosEmpresa($nit);
        foreach($array as $clave=>$valor){
            $this->view = $this->renderView($this->view, "{{".$clave."}}", $valor);
            
        }
        
        
        $this->showView($this->view);
    }
    
    
    public function mostrarConsulta(){
        $form = $this->getTemplate("./app/views/DiagnosticoEmpresa/consultarDEmpresa.html");
        $this->view = $this->renderView($this->view, "{{TITULO}}","Agregar Diagnostico Empresa");
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        $this->view = $this->renderView($this->view, "{{CONTENT}}", $form);
        $this->showView($this->view);
        
    }
    
    public function agregarFormDiagnosticoEmpresa($form){
        
        $id=$this->diagnosticoEmpresaModel->agregarForm($form);
        if($id!=""){
            echo "<script>alert('Registro éxitoso. Su numero consecutivo del diagnostico de la idea es: \\n 01-000".$id."');
            ;window.location='index.php';
            </script>";
        }else{
            echo "<script>alert('Error al registrar el diagnostico de la idea, intente más tarde');</script>";
        }
        
    }
    
    public function editarFormDiagnosticoIdea($form){
        $query= $this->diagnosticoIdeaModel->editarForm($form);
        echo $query;
        echo "<script>alert('Diagnostico de la idea actualizado exitosamente.');window.location='index.php';</script>";
    }
    
    
    public function editarForm($num_consecutivo){
        $form= $this->getTemplate("./app/views/DiagnosticoEmpresa/editarDEmpresa.html");
        $row = $this->diagnosticoEmpresaModel->consultarForm($num_consecutivo);
        $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
        $this->view = $this->renderView($this->view, "{{TITULO}}", "Editar Diagnostico Empresa");
        
        $form = $this->renderView($form, "{{ASESOR}}", $this->diagnosticoEmpresaModel->consultarNombreAsesor());
        $form = $this->renderView($form, "{{nit_empresa}}", $row["nit_empresa"]);
        $array = $this->diagnosticoEmpresaModel->consultarDatosEmpresa($row["nit_empresa"]);
        foreach($array as $clave=>$valor){
            $form = $this->renderView($form, "{{".$clave."}}", $valor);
            
        }
        
        $this->llenarForm($row,$form);
    }
    
    //llena el form para editar y para consultar diagnostico
    public function llenarForm($row, $form){
        
        foreach($row as $clave => $element){
            switch($element){
                case "Si":
                $form = $this->renderView($form,"{{".$clave."_Si}}" , "checked");
                $form = $this->renderView($form,"{{".$clave."_No}}" , "");
                $this->view = $this->renderView($this->view,"{{".$clave."_Masomenos}}" , "");
                break;
            
                case "Mas o Menos":
                $form = $this->renderView($form,"{{".$clave."_Si}}" , "");
                $this->view = $this->renderView($form,"{{".$clave."_No}}" , "");
                $form = $this->renderView($form,"{{".$clave."_Masomenos}}" , "checked");
                
                break;
            
                case "No":
                $form = $this->renderView($form,"{{".$clave."_Si}}" , "");
                $form = $this->renderView($form,"{{".$clave."_No}}" , "checked");
                $form = $this->renderView($form,"{{".$clave."_Masomenos}}" , "");
                
                break;
        }
}

 //agregar los aspectos a mejorar de forma dinamica a editar idea
           $tabla="";
           $plantilla=$this->menu= $this->getTemplate("./app/views/components/aspectos-mejorar.html");
           $dificultades=$this->diagnosticoEmpresaModel->consultarAspectosMejorar($row['id_diagnostico_emp']);
           $cont=0;
           foreach($dificultades as $element){
               $temp=$this->renderView($plantilla,"{{NUM_ASPECTOS_MEJORAR}}",$element['numero']);
               $temp=$this->renderView($temp,"{{DESCRIPCION_ASPECTOS_MEJORAR}}",$element['descripcion']);
               $tabla.=$temp;
               $cont++;
           }
           
            $form=$this->renderView($form,"{{CANT_ASPECTOS_MEJORAR}}",$cont);
            $form=$this->renderView($form,"{{TABLA_ASPECTOS_MEJORAR}}",$tabla);

    //incluir el contenido a la plantilla del index
            $this->view = $this->renderView($this->view, "{{CONTENT}}", $form);
            $this->showView($this->view);
}


public function consultarForm($num_consecutivo){
    $row = $this->diagnosticoEmpresaModel->consultarForm($num_consecutivo);
    $form= $this->getTemplate("./app/views/DiagnosticoEmpresa/consultarDEmpresa.html");
    $this->view = $this->renderView($this->view, "{{CONTENT}}", $form);
    $this->view = $this->renderView($this->view, "{{TITULO}}", "Consultar Diagnostico Empresa");
    $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
    $this->view = $this->renderView($this->view, "{{Num_consecutivo}}", $num_consecutivo);
    
    foreach($row as $clave=>$valor){
        $this->view = $this->renderView($this->view, "{{".$clave."}}", $valor);
    }
    
    $arrayPuntos = $this->diagnosticoEmpresaModel->consultarPuntosProblematicos($num_consecutivo);
    $cadenaPuntos ="";
    
    while ($fila = mysqli_fetch_array($arrayPuntos)){
        $cadenaPuntos.="<li><p>".$fila['Nombre']."</p></li>";
    }
    $this->view = $this->renderView($this->view, "{{puntos_problematicos}}", $cadenaPuntos);
    
    $arrayEmpresa = $this->diagnosticoEmpresaModel->consultarDatosEmpresa($row['nit_empresa']);
    
    foreach($arrayEmpresa as $clave=>$valor){
        $this->view = $this->renderView($this->view, "{{".$clave."}}", $valor);
    }
    
    $arrayAspectos = $this->diagnosticoEmpresaModel->consultarAspectosMejorar($num_consecutivo);
    
    $cadenaAspectos ="";
    
    while ($fila2 = mysqli_fetch_array($arrayAspectos)){
        $cadenaAspectos.="<li><p>".$fila2['descripcion']."</p></li>";
    }
    $this->view = $this->renderView($this->view, "{{Aspectos}}", $cadenaAspectos);
    
    $this->showView($this->view);
    
}

public function ventanaEditarDiag(){
    $ventana = $this->getTemplate("./app/views/components/ventana-consultar.html");
    $this->view = $this->renderView($this->view, "{{TITULO}}","Editar Diagnostico Idea");
    $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
    $this->view = $this->renderView($this->view, "{{CONTENT}}", $ventana);
    $this->view = $this->renderView($this->view, "{{TITULO_VENTANA}}", "Editar diagnostico de la idea");
    $this->view = $this->renderView($this->view, "{{PLACEHOLDER}}", "Ingrese el numero de la cedula");
    $this->view = $this->renderView($this->view, "{{TIPO_OPERACION}}", "EDITAR");
    $this->showView($this->view);
    
}
public function ventanaConsultarDiag(){
    $ventana = $this->getTemplate("./app/views/DiagnosticoEmpresa/componentes/consultar-empresa.html");
    $this->view = $this->renderView($this->view, "{{TITULO}}","Consultar Diagnostico Empresa");
    $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
    $this->view = $this->renderView($this->view, "{{CONTENT}}", $ventana);
    $this->view = $this->renderView($this->view, "{{TITULO_VENTANA}}", "Consulta el diagnostico de la empresa");
    $this->view = $this->renderView($this->view, "{{TITULO2}}","Seleccione el diagnostico que desea consultar.");
    $array = $this->diagnosticoEmpresaModel->consultarDiagEmpresa();
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
            $empresadata = $this->diagnosticoEmpresaModel->consultarDatosEmpresa($element['nit_empresa']);
            $temp = $this->renderView($temp, "{{EMPRESA}}", $empresadata['emp_nombre']);
            $temp = $this->renderView($temp, "{{RAZONSOCIAL}}", $empresadata['emp_razons']);
            $temp = $this->renderView($temp, "{{PRODUCTOS}}", $empresadata['emp_servicios']);
            $contact = $this->diagnosticoEmpresaModel->consultarDatosCliente($element['nit_empresa']);
            $temp = $this->renderView($temp, "{{CONTACTO}}", $contact['cl_nombre']." ".$contact['cl_apellido']);
            $option .= $temp;
        }
        $this->view = $this->renderView($this->view, "{{OPTION}}", $option);
    }else{
        echo "<h2>No Existen Diagnósticos</h2>";
    }
    $this->showView($this->view);
}

public function seleccionarEmpresa(){
    $ventana = $this->getTemplate("./app/views/DiagnosticoEmpresa/componentes/tabla-empresas.html");
    $this->view = $this->renderView($this->view, "{{TITULO}}","Consultar Diagnostico Empresa");
    $this->view = $this->renderView($this->view, "{{SESION}}", $this->menu);
    $this->view = $this->renderView($this->view, "{{CONTENT}}", $ventana);
    $this->view = $this->renderView($this->view, "{{TITULO_VENTANA}}", "Consulta el diagnostico de la Empresa");
    $this->view = $this->renderView($this->view, "{{TITULO2}}","Seleccione la empresa a la que va a realizar el diagnóstico.");
    $array = $this->diagnosticoEmpresaModel->consultarEmpresa();
    $sizeArray = sizeof($array);
    $option = "";
    $elementotabla = $this->getTemplate("./app/views/DiagnosticoEmpresa/componentes/empresas-tabla.html");
    
    if($sizeArray>0){
        foreach($array as $element) {
            $temp = $elementotabla;
            $temp = $this->renderView($temp, "{{NIT}}", $element['emp_nit']);
            $temp = $this->renderView($temp, "{{NOMBRE}}", $element['emp_nombre']);
            $option .= $temp;
        }
        $this->view=$this->renderView($this->view, "{{OPTION}}",$option);
    }else{
        $this->view=$this->renderView($this->view, "{{OPTION}}", "<h2>No Existe Ninguna Empresa</h2>");
    }
    $this->showView($this->view);
    
    
    
}





}

?>