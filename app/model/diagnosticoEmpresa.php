<?php
require_once "./app/model/model.php";

class DiagnosticoEmpresaModel extends Model {
    
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
        $update= "UPDATE diagnostico_empresa SET nit_empresa='".$form['nit_empresa']."',asesor='".$form['asesor']."',posicion_empresa='".$form['posicion_empresa']."',tiempo_operacion='".$form['tiempo_operacion']."',sector='".$form['sector']."',planes_largoplazo='".$form['planes_largoplazo']."',mision='".$form['mision']."',vision='".$form['vision']."',objetivos='".$form['objetivos']."',estrategias='".$form['estrategias']."',plan_accion='".$form['plan_accion']."',valores='".$form['valores']."',nombre_objetivos='".$form['nombre_objetivos']."',recursos='".$form['recursos']."',debilidades='".$form['debilidades']."',oportunidades='".$form['oportunidades']."',obstaculos='".$form['obstaculos']."',ventaja_cliente='".$form['ventaja_cliente']."',ventaja_empresa='".$form['ventaja_empresa']."',tipo_planes='".$form['tipo_planes']."',tiempo_planeacion='".$form['tiempo_planeacion']."',participacion_empleados='".$form['participacion_empleados']."',empleados_conocen='".$form['empleados_conocen']."',estrategias_crecimiento='".$form['estrategias_crecimiento']."',organigrama='".$form['organigrama']."',procesos_documentados='".$form['procesos_documentados']."',procesos_evaluacion='".$form['procesos_evaluacion']."',procesos_automatizar='".$form['procesos_automatizar']."',max_colaboradores='".$form['max_colaboradores']."',clima_laboral='".$form['clima_laboral']."',motivacion_empleados='".$form['motivacion_empleados']."',toma_desiciones='".$form['toma_desiciones']."',en_concenso='".$form['en_concenso']."',define_acciones='".$form['define_acciones']."',sistema_control='".$form['sistema_control']."',comparar_planeado_eje='".$form['comparar_planeado_eje']."',clave_desempenio='".$form['clave_desempenio']."',seguimiento_indicadores='".$form['seguimiento_indicadores']."',contrata_direc_personal='".$form['contrata_direc_personal']."',combina_forma_contratar='".$form['combina_forma_contratar']."',procesos_establecidos='".$form['procesos_establecidos']."',recompensas_establecidas='".$form['recompensas_establecidas']."',num_empleados='".$form['num_empleados']."',empleados_necesarios='".$form['empleados_necesarios']."',depto_mercadeo_ventas='".$form['depto_mercadeo_ventas']."',msj_marketing_claro='".$form['msj_marketing_claro']."',dedica_tiempo_marketing='".$form['dedica_tiempo_marketing']."',delega_tiempo='".$form['delega_tiempo']."',plan_mercadeo='".$form['plan_mercadeo']."',implementa_plan='".$form['implementa_plan']."',cronograma_marketing='".$form['cronograma_marketing']."',perfil_cliente='".$form['perfil_cliente']."',clasificacion_cliente='".$form['clasificacion_cliente']."',web_ventas='".$form['web_ventas']."',tecnologia_seguimiento='".$form['tecnologia_seguimiento']."',sistema_compatibilidad='".$form['sistema_compatibilidad']."',contabilidad_aldia='".$form['contabilidad_aldia']."',aplica_normas_contabilidad='".$form['aplica_normas_contabilidad']."',facturacion_ultimoanio='".$form['facturacion_ultimoanio']."',planificacion_financiera_formal='".$form['planificacion_financiera_formal']."',margen_rentabilidad='".$form['margen_rentabilidad']."',margen_rentabilidad_pos='".$form['margen_rentabilidad_pos']."',nivel_endeudamiento='".$form['nivel_endeudamiento']."',ingresos_cumplen_objetivos='".$form['ingresos_cumplen_objetivos']."',suficiente_capital='".$form['suficiente_capital']."',flujo_caja_positivo='".$form['flujo_caja_positivo']."',costo_producto='".$form['costo_producto']."',presupuesto_estable='".$form['presupuesto_estable']."',desiciones_analisis='".$form['desiciones_analisis']."',porcentaje_capacidad='".$form['porcentaje_capacidad']."',normas_tecnicas_sector='".$form['normas_tecnicas_sector']."',estado_maquinaria='".$form['estado_maquinaria']."',programa_produccion='".$form['programa_produccion']."',corresponde_demanda_mercado='".$form['corresponde_demanda_mercado']."',produccion_planes='".$form['produccion_planes']."',pontrola_calidad_producto='".$form['pontrola_calidad_producto']."',problemas_abastecimiento='".$form['problemas_abastecimiento']."',Adquisicion_maquinaria='".$form['Adquisicion_maquinaria']."',Planes_contingencia_maprima='".$form['Planes_contingencia_maprima']."',Inventarios_periodicos='".$form['Inventarios_periodicos']."',Seguimiento_inventarios='".$form['Seguimiento_inventarios']."',eficiente_dist_trabajo='".$form['eficiente_dist_trabajo']."',paises_importado_expor='".$form['paises_importado_expor']."',mercados_importado_expor='".$form['mercados_importado_expor']."',metas_importado_expor='".$form['metas_importado_expor']."',estrategia_marketing='".$form['estrategia_marketing']."',ventas_esperadas='".$form['ventas_esperadas']."',margen_ventas='".$form['margen_ventas']."',capital_presupuestado='".$form['capital_presupuestado']."',aspectos_adicionales='".$form['aspectos_adicionales']."' WHERE id_diagnostico_emp=".$form['id_diagnostico_emp'];
        
        $query = $this->query($update);
        //borra los aspectos a mejorar del diagnostico
        $delete="DELETE FROM `lista_dificultades_e` WHERE `lista_dificultades_e`.`id_diagnostico_emp`=".$form['id_diagnostico_emp'];
        $this->query($delete);
        //borra los puntos problematicos del diagnostico 
        $delete="DELETE FROM `diagxpuntos` WHERE `diagxpuntos`.`id_diag_empresa`=".$form['id_diagnostico_emp'];
        $this->query($delete);
        //agregar de nuevo los aspectos a mejorar y los puntos problematicos
        $insert2 = "INSERT INTO diagxpuntos (id_diag_empresa, Codigo_puntos) VALUES ";
        $id= $form["id_diagnostico_emp"];
        for($i=1 ; $i<=34 ; $i++){
            
            if(isset($form["$i"])){
                $insert2.= " ('".$id."',".$form["$i"]."),";
            }
        }
        $insert2 = trim($insert2,',');
        $insert2 = $insert2.";";
        $this->query($insert2);
        $insert4 ="INSERT INTO lista_dificultades_e (id_diagnostico_emp,numero,descripcion) VALUES ";
        $cant_aspectos = $form['cant-aspectos-mejorar'];
        for($j=1; $j<= $cant_aspectos ; $j++){   

            //modificar para que no agregue espacios vacios
            $insert4.="(".$id.",'".$j."','".$form['aspectos-mejorar-'.$j]."'),";   
        }
        $insert4 = trim($insert4,',');
        $this->query($insert4);
        $this->terminate();
        return $query;
    }
    
    public function agregarForm($form){
        $cant_aspectos = $form['cant-aspectos-mejorar'];
        foreach($form as $clave => $valor){
            if($valor==""){
                $form[$clave]="NULL";
            }
            else{
                $form[$clave]="'".$valor."'";
            }
        }
        
        $this->connect();
        
        $insert = "INSERT INTO diagnostico_empresa (
        nit_empresa,
        asesor,
        posicion_empresa,
        tiempo_operacion,
        sector,
        planes_largoplazo,
        mision,
        vision,
        objetivos,
        estrategias,
        plan_accion,
        valores,
        nombre_objetivos,
        recursos,
        debilidades,
        oportunidades,
        obstaculos,
        ventaja_cliente,
        ventaja_empresa,
        tipo_planes,
        tiempo_planeacion,
        participacion_empleados,
        empleados_conocen,
        estrategias_crecimiento,
        organigrama,
        procesos_documentados,
        procesos_evaluacion,
        procesos_automatizar,
        max_colaboradores,
        clima_laboral,
        motivacion_empleados,
        toma_desiciones,
        en_concenso,
        define_acciones,
        sistema_control,
        comparar_planeado_eje,
        clave_desempenio,
        seguimiento_indicadores,
        contrata_direc_personal,
        combina_forma_contratar,
        procesos_establecidos,
        recompensas_establecidas,
        num_empleados,
        empleados_necesarios,
        depto_mercadeo_ventas,
        msj_marketing_claro,
        dedica_tiempo_marketing,
        delega_tiempo,
        plan_mercadeo,
        implementa_plan,
        cronograma_marketing,
        perfil_cliente,
        clasificacion_cliente,
        web_ventas,
        tecnologia_seguimiento,
        sistema_compatibilidad,
        contabilidad_aldia,
        aplica_normas_contabilidad,
        facturacion_ultimoanio,
        planificacion_financiera_formal,
        margen_rentabilidad,
        margen_rentabilidad_pos,
        nivel_endeudamiento,
        ingresos_cumplen_objetivos,
        suficiente_capital,
        flujo_caja_positivo,
        costo_producto,
        presupuesto_estable,
        desiciones_analisis,
        porcentaje_capacidad,
        normas_tecnicas_sector,
        estado_maquinaria,
        programa_produccion,
        corresponde_demanda_mercado,
        produccion_planes,
        pontrola_calidad_producto,
        problemas_abastecimiento,
        Adquisicion_maquinaria,
        Planes_contingencia_maprima,
        Inventarios_periodicos,
        Seguimiento_inventarios,
        eficiente_dist_trabajo,
        paises_importado_expor,
        mercados_importado_expor,
        metas_importado_expor,
        estrategia_marketing,
        ventas_esperadas,
        margen_ventas,
        capital_presupuestado,
        aspectos_adicionales)  VALUES (
        ".$form['nit_empresa'].",
        ".$form['asesor'].",
        ".$form['posicion_empresa'].",
        ".$form['tiempo_operacion'].",
        ".$form['sector'].",
        ".$form['planes_largoplazo'].",
        ".$form['mision'].",
        ".$form['vision'].",
        ".$form['objetivos'].",
        ".$form['estrategias'].",
        ".$form['plan_accion'].",
        ".$form['valores'].",
        ".$form['nombre_objetivos'].",
        ".$form['recursos'].",
        ".$form['debilidades'].",
        ".$form['oportunidades'].",
        ".$form['obstaculos'].",
        ".$form['ventaja_cliente'].",
        ".$form['ventaja_empresa'].",
        ".$form['tipo_planes'].",
        ".$form['tiempo_planeacion'].",
        ".$form['participacion_empleados'].",
        ".$form['empleados_conocen'].",
        ".$form['estrategias_crecimiento'].",
        ".$form['organigrama'].",
        ".$form['procesos_documentados'].",
        ".$form['procesos_evaluacion'].",
        ".$form['procesos_automatizar'].",
        ".$form['max_colaboradores'].",
        ".$form['clima_laboral'].",
        ".$form['motivacion_empleados'].",
        ".$form['toma_desiciones'].",
        ".$form['en_concenso'].",
        ".$form['define_acciones'].",
        ".$form['sistema_control'].",
        ".$form['comparar_planeado_eje'].",
        ".$form['clave_desempenio'].",
        ".$form['seguimiento_indicadores'].",
        ".$form['contrata_direc_personal'].",
        ".$form['combina_forma_contratar'].",
        ".$form['procesos_establecidos'].",
        ".$form['recompensas_establecidas'].",
        ".$form['num_empleados'].",
        ".$form['empleados_necesarios'].",
        ".$form['depto_mercadeo_ventas'].",
        ".$form['msj_marketing_claro'].",
        ".$form['dedica_tiempo_marketing'].",
        ".$form['delega_tiempo'].",
        ".$form['plan_mercadeo'].",
        ".$form['implementa_plan'].",
        ".$form['cronograma_marketing'].",
        ".$form['perfil_cliente'].",
        ".$form['clasificacion_cliente'].",
        ".$form['web_ventas'].",
        ".$form['tecnologia_seguimiento'].",
        ".$form['sistema_compatibilidad'].",
        ".$form['contabilidad_aldia'].",
        ".$form['aplica_normas_contabilidad'].",
        ".$form['facturacion_ultimoanio'].",
        ".$form['planificacion_financiera_formal'].",
        ".$form['margen_rentabilidad'].",
        ".$form['margen_rentabilidad_pos'].",
        ".$form['nivel_endeudamiento'].",
        ".$form['ingresos_cumplen_objetivos'].",
        ".$form['suficiente_capital'].",
        ".$form['flujo_caja_positivo'].",
        ".$form['costo_producto'].",
        ".$form['presupuesto_estable'].",
        ".$form['desiciones_analisis'].",
        ".$form['porcentaje_capacidad'].",
        ".$form['normas_tecnicas_sector'].",
        ".$form['estado_maquinaria'].",
        ".$form['programa_produccion'].",
        ".$form['corresponde_demanda_mercado'].",
        ".$form['produccion_planes'].",
        ".$form['pontrola_calidad_producto'].",
        ".$form['problemas_abastecimiento'].",
        ".$form['Adquisicion_maquinaria'].",
        ".$form['Planes_contingencia_maprima'].",
        ".$form['Inventarios_periodicos'].",
        ".$form['Seguimiento_inventarios'].",
        ".$form['eficiente_dist_trabajo'].",
        ".$form['paises_importado_expor'].",
        ".$form['mercados_importado_expor'].",
        ".$form['metas_importado_expor'].",
        ".$form['estrategia_marketing'].",
        ".$form['ventas_esperadas'].",
        ".$form['margen_ventas'].",
        ".$form['capital_presupuestado'].",
        ".$form['aspectos_adicionales'].")";
        $this->query($insert);
        
        $consulta="SELECT * FROM diagnostico_empresa order by id_diagnostico_emp desc LIMIT 1";
        $row=mysqli_fetch_array($this->query($consulta));
        $id= $row["id_diagnostico_emp"];
        $insert2 = "INSERT INTO diagxpuntos (id_diag_empresa, Codigo_puntos) VALUES ";
        for($i=1 ; $i<=34 ; $i++){
            
            if(isset($form["$i"])){
                $insert2.= " ('".$id."',".$form["$i"]."),";
            }
        }
        $insert2 = trim($insert2,',');
        $insert2 = $insert2.";";
        $this->query($insert2);
        $insert4 ="INSERT INTO lista_dificultades_e (id_diagnostico_emp,numero,descripcion) VALUES ";
        for($j=1; $j<= $cant_aspectos ; $j++){   
            $insert4.="(".$id.",'".$j."',".$form['aspectos-mejorar-'.$j]."),";   
        }
        $insert4 = trim($insert4,',');
        $this->query($insert4);
        $this->terminate();
        return $id;  
    }
    public function insertarAdicionalesDiagnostico($form,$id,$cant_aspectos){
        $insert2 = "INSERT INTO diagxpuntos (id_diag_empresa, Codigo_puntos) VALUES ";
        for($i=1 ; $i<=34 ; $i++){
            
            if(isset($form["$i"])){
                $insert2.= " ('".$id."',".$form["$i"]."),";
            }
        }
        $insert2 = trim($insert2,',');
        $insert2 = $insert2.";";
        $this->query($insert2);
        $insert4 ="INSERT INTO lista_dificultades_e (id_diagnostico_emp,numero,descripcion) VALUES ";
        for($j=1; $j<= $cant_aspectos ; $j++){   
            $insert4.="(".$id.",'".$j."','".$form['aspectos-mejorar-'.$j]."'),";   
        }
        $insert4 = trim($insert4,',');
        $this->query($insert4);
    }
    
    public function consultarForm($consecutivo){
        $this->connect();
        $consulta = "SELECT * FROM diagnostico_empresa WHERE id_diagnostico_emp = ".$consecutivo;
        $query = $this->query($consulta);
        $this->terminate();
        $row= mysqli_fetch_array($query);
        return $row;
    }
    
    
    public function consultarDiagEmpresa(){
        $this->connect();
        $consulta = "SELECT id_diagnostico_emp, fecha, sector, nit_empresa FROM diagnostico_empresa";
        $query = $this->query($consulta);
        $this->terminate();
        $array=array();
        while($row = mysqli_fetch_array($query)){
            array_unshift($array,$row);
        }
        return $array;
    }
    //EMPRESA
    public function consultarEmpresa(){
        $this->connect();
        $consulta = "SELECT emp_nit, emp_nombre FROM empresa";
        $query = $this->query($consulta);
        $this->terminate();
        $array = array();
        while($row = mysqli_fetch_array($query)){
            array_unshift($array, $row);
        }
        return $array;
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
    
    public function consultarPuntosProblematicos($id){
        $consulta= "SELECT p.Nombre, p.Codigo
        FROM puntos_problematicos p, diagxpuntos d
        WHERE (d.Codigo_puntos = p.Codigo) AND (d.id_diag_empresa=$id)";
        $this->connect();
        $query = $this->query($consulta);
        $this->terminate();
        return $query;
        
    }
    
    public function consultarAspectosMejorar($id){
        $this->connect();
        $result=$this->query("SELECT descripcion, numero
        from lista_dificultades_e where id_diagnostico_emp=$id ORDER BY numero ASC");
        $this->terminate();
        return $result;
    }
}
?>