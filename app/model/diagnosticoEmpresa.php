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
        $update = "UPDATE `diagnostico_idea` SET `Asesor`= '".$form['Asesor']."', `Nombres`= '".$form['Nombres']."', `Apellidos`= '".$form['Apellidos']."', `CC`='".$form['CC']."',
             `Posicion`= '".$form['Posicion']."', `Telefono`= '".$form['Telefono']."', `Celular`= '".$form['Celular']."', `Idea`= '".$form['Idea']."',
             `Motivacion`= '".$form['Motivacion']."', `Elecion`= '".$form['Elecion']."', `Productos`= '".$form['Productos']."',
             `Personal_requerido`= '".$form['Personal_requerido']."', `Grupo_empresarial`= '".$form['Grupo_empresarial']."',
             `Equipo_caracteristicas`= '".$form['Equipo_caracteristicas']."', `Criterios_contratacion`= '".$form['Criterios_contratacion']."',
             `Mercado_objetivo`= '".$form['Mercado_objetivo']."', `Mercado_objetivo_ubica`= '".$form['Mercado_objetivo_ubica']."',
             `Competidores`= '".$form['Competidores']."', `Factor_diferenciador`= '".$form['Factor_diferenciador']."',
             `Condiciones_venta`= '".$form['Condiciones_venta']."', `Ubicacion_negocio`= '".$form['Ubicacion_negocio']."',
             `Ubicacion_influencia`= '".$form['Ubicacion_influencia']."', `Estrategia_precios`= '".$form['Estrategia_precios']."',
             `Canales_distribucion`= '".$form['Canales_distribucion']."', `Promocion_negocio`= '".$form['Promocion_negocio']."',
             `Costo_operacion`= '".$form['Costo_operacion']."', `Fuentes_financiacion`= '".$form['Fuentes_financiacion']."',
             `Tiempo_retorno_inversion`= '".$form['Tiempo_retorno_inversion']."', `Como_estimo_precio`= '".$form['Como_estimo_precio']."',
             `Costo_producto`= '".$form['Costo_producto']."', `Asuntos_finanza`= '".$form['Asuntos_finanza']."', `Desarrollo_producto`= '".$form['Desarrollo_producto']."',
             `Tecnologia_requerida`= '".$form['Tecnologia_requerida']."', `Infraestructura_requerida`= '".$form['Infraestructura_requerida']."',
             `Regulaciones_operacion`= '".$form['Regulaciones_operacion']."', `Tipo_persona`= '".$form['Tipo_persona']."',
             `Aspectos_mejorar`= '".$form['Aspectos_mejorar']."' WHERE `Num_consecutivo`=".$form['Num_consecutivo'];

        $query = $this->query($update);
        $this->terminate();
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

        $insert = "INSERT INTO `diagnostico_empresa` (
            `nit_empresa`,
            `asesor`, 
            `posicion_empresa`, 
            `tiempo_operacion`, 
            `sector`, 
            `planes_largoplazo`, 
            `mision`, 
            `vision`, 
            `objetivos`, 
            `estrategias`, 
            `plan_accion`, 
            `valores`, 
            `nombre_objetivos`, 
            `recursos`, 
            `debilidades`, 
            `oportunidades`, 
            `obstaculos`, 
            `ventaja_cliente`, 
            `ventaja_empresa`, 
            `tipo_planes`, 
            `tiempo_planeacion`, 
            `participacion_empleados`, 
            `empleados_conocen`, 
            `estrategias_crecimiento`, 
            `organigrama`, 
            `procesos_documentados`, 
            `procesos_evaluacion`, 
            `procesos_automatizar`, 
            `max_colaboradores`, 
            `clima_laboral`, 
            `motivacion_empleados`, 
            `toma_desiciones`, 
            `en_concenso`, 
            `define_acciones`, 
            `sistema_control`, 
            `comparar_planeado_eje`, 
            `clave_desempenio`, 
            `seguimiento_indicadores`, 
            `contrata_direc_personal`, 
            `combina_forma_contratar`, 
            `procesos_establecidos`, 
            `recompensas_establecidas`, 
            `num_empleados`, 
            `empleados_necesarios`, 
            `depto_mercadeo_ventas`, 
            `msj_marketing_claro`, 
            `dedica_tiempo_marketing`, 
            `delega_tiempo`, 
            `plan_mercadeo`, 
            `implementa_plan`, 
            `cronograma_marketing`, 
            `perfil_cliente`, 
            `clasificacion_cliente`, 
            `web_ventas`, 
            `tecnologia_seguimiento`, 
            `sistema_compatibilidad`, 
            `contabilidad_aldia`, 
            `aplica_normas_contabilidad`, 
            `facturacion_ultimoanio`, 
            `planificacion_financiera_formal`, 
            `margen_rentabilidad`, 
            `margen_rentabilidad_pos`, 
            `nivel_endeudamiento`, 
            `ingresos_cumplen_objetivos`, 
            `suficiente_capital`, 
            `flujo_caja_positivo`, 
            `costo_producto`, 
            `presupuesto_estable`, 
            `desiciones_analisis`, 
            `porcentaje_capacidad`, 
            `normas_tecnicas_sector`, 
            `estado_maquinaria`, 
            `programa_produccion`, 
            `corresponde_demanda_mercado`, 
            `produccion_planes`, 
            `pontrola_calidad_producto`, 
            `problemas_abastecimiento`, 
            `Adquisicion_maquinaria`, 
            `Planes_contingencia_maprima`, 
            `Inventarios_periodicos`, 
            `Seguimiento_inventarios`, 
            `eficiente_dist_trabajo`, 
            `paises_importado_expor`, 
            `mercados_importado_expor`, 
            `metas_importado_expor`, 
            `estrategia_marketing`, 
            `ventas_esperadas`, 
            `margen_ventas`, 
            `capital_presupuestado`, 
            `aspectos_adicionales`)  VALUES (
            ".$form['id_empresa'].",
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

        $insert2 = "INSERT INTO `diagxpuntos` (`Codigo_empresa`, `Codigo_puntos`) VALUES ";

        for($i=1 ; $i<=34 ; $i++){

          if(isset($form["$i"])){
              $insert2.= " ('".$id."',".$form["$i"]."),";
          }
        }
        $insert2 = trim($insert2,',');
        $insert2 = $insert2.";";
        $this->query($insert2);
        $insert4 ="INSERT INTO `lista_dificultades_e` (`id_diagnostico_emp`,`numero`,`descripcion`) VALUES ";
        for($j=1; $j<= $cant_aspectos ; $j++){

            $insert4.="(".$form['id_empresa'].",'".$j."',".$form['aspectos-mejorar-'.$j]."),";

        }
        $insert4 = trim($insert4,',');
        $this->query($insert4);
        $this->terminate();
          return $id;

    }

    public function consultarForm($consecutivo){
        $this->connect();
        $consulta = "SELECT * FROM diagnostico_idea WHERE Num_consecutivo = ".$consecutivo;
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



    

}

?>
