<table   width="100%" style="width: 100%; text-align: center ;"  border="0" cellspacing="0"  cellpadding="2">
    <tr >
        <td  style="width: 20%; " >
            <img  style=" height: auto;" src="http://<?=  $this->host ?>/sis_seguridad/control/foto_persona/ActionObtenerFoto.php?file=<?= $this->datos_persona[0]['nombre_archivo_foto'];?>" alt="Logo">

        </td>
        <td style="text-align:left;" width="80%" style=" background-color: #34495E; color: white;  " >
            <?php
            $resultado = str_replace ( "{", '', $this->datos_estructura['v_estructura']);
            $resultado = str_replace ( "}", '', $resultado);
            $text = str_replace('"', "", $resultado);
            ?>
            <div style="text-align:left;">
                <b align="left"><?= trim($this->datos_persona[0]['desc_person']);?> </b><br/>
                <b align="left">&nbsp;&nbsp;<?= $this->datos_persona[0]['email_empresa'];?></b><br/>
                <br/>
                <b align="left" style="font-size: 11px;">&nbsp;&nbsp;<?= $text; ?></b>
            </div>
        </td>
    </tr>
</table>
<br/>
<br/>
<font size="11">
<table  width="100%"  style="padding-left: 0px;"  >

        <tr>
            <td style=" border-right: 5px solid #34495E; padding: 0px;" width="40%" >
                <table>
                    <tr>
                        <td>
                            <table width="100%" align="left" cellpadding="2px">
                                <tr>
                                    <td style="border-bottom: 3px solid #e9b108;">
                                        <b>Datos Personales</b>
                                    </td>
                                </tr>
                            </table>
                            <p>
                            <table style="font-size: 11px;">
                                <tr>
                                    <td  width="40%"><b>CI:</b>
                                    </td>
                                    <td  width="60%">
                                        <?= $this->datos_persona[0]['ci'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Telefono/Celular:</b>
                                    </td>
                                    <td>
                                        <?= $this->datos_persona[0]['telefono1'].' '.$this->datos_persona[0]['celular1'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Estado Civil:</b>
                                    </td>
                                    <td>
                                        <?= $this->datos_persona[0]['estado_civil'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td ><b>Profesión:</b>
                                    </td>
                                    <td >
                                        <?= $this->datos_persona[0]['profesion'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td ><b>Codigo:</b>
                                    </td>
                                    <td >
                                        <?= $this->datos_persona[0]['codigo'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td ><b>Nacimiento:</b>
                                    </td>
                                    <td >
                                        <?= $this->datos_persona[0]['fecha_nacimiento'];?>
                                    </td>
                                </tr>
                            </table>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table width="100%" align="left" cellpadding="2px">
                                <tr>
                                    <td style="border-bottom: 3px solid #e9b108;">
                                        <b>Competencias</b>
                                    </td>
                                </tr>
                            </table>
                            <p align="left" style="font-size: 11px; text-align: left;">
                            <table cellspacing="5">
                                <?php
                                $i = 1;
                                foreach ($this->datos_competencia as $datos) {
                                    echo '<tr><td> - &nbsp;'.$datos['nombre_competencia'].' - Nivel ('.$datos['nivel'].')</td></tr>';
                                    $i++;
                                }
                                ?>
                            </table>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <table width="100%" align="left" cellpadding="2px">
                            <tr>
                                <td style="border-bottom: 3px solid #e9b108;">
                                    <b>Residencias</b>
                                </td>
                            </tr>
                        </table>
                        <p>
                        <table  style="font-size: 11px;" cellspacing="5"
                            >
                            <?php
                            $i = 1;
                            foreach ($this->datos_residencia as $datos) {
                                echo '<tr><td> - &nbsp;'.$datos['ciudad'].', '.$datos['direccion'].' Telefono: '.$datos['telefono'].'</td></tr>';
                                $i++;
                            }
                            ?>
                        </table>
                        </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <table width="100%" align="left" cellpadding="2px">
                            <tr>
                                <td style="border-bottom: 3px solid #e9b108;">
                                    <b>Numeros de Emergencia</b>
                                </td>
                            </tr>
                        </table>
                        <p>
                            <table style="font-size: 11px;" cellspacing="5">
                                <?php
                                    $i = 1;
                                    foreach ($this->datos_allegado as $datos) {
                                       if($datos['tipo_relacion'] == 'emergencia'){
                                           echo  '<tr><td>-&nbsp;'.$datos['nombre_completo1'].', '.$datos['direccion'].' Telf:  &nbsp;'.$datos['celular1'].'&nbsp;'.$datos['telefono1'].'</td></tr>';
                                       }
                                       $i++;
                                    }
                                ?>
                            </table>
                        </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" align="left" cellpadding="2px">
                                <tr>
                                    <td style="border-bottom: 3px solid #e9b108;">
                                        <b>Familiares</b>
                                    </td>
                                </tr>
                            </table>
                            <p>
                            <table style="font-size: 11px;" cellspacing="5">
                                <?php
                                $i = 1;
                                foreach ($this->datos_allegado as $datos) {
                                    if($datos['tipo_relacion'] == 'familiar'){
                                        echo  '<tr style="padding-bottom: 25px;"><td style="padding-bottom: 25px;">&nbsp;'.$datos['nombre_completo1'].', '.$datos['direccion'].' Telf:  &nbsp;'.$datos['celular1'].'&nbsp;'.$datos['telefono1'].'</td></tr>';
                                    }
                                    $i++;
                                }
                                ?>
                            </table>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" align="left" cellpadding="2px">
                                <tr>
                                    <td style="border-bottom: 3px solid #e9b108;">
                                        <b>Idiomas</b>
                                    </td>
                                </tr>
                            </table>
                            <p>
                                <table style="font-size: 11px;" cellspacing="5">
                                    <?php
                                    $i = 1;
                                    foreach ($this->datos_idiomas as $datos) {
                                        echo '<tr><td width="30%">&nbsp;'.$datos['idioma'].'</td><td width="70%"><b>Habla:</b> '.$datos['habla'].', <b>Lee:</b>&nbsp;'.$datos['lee'].', <b>Escribe:</b>&nbsp;'.$datos['escribe'].', <b>Entiende:</b>&nbsp;'.$datos['entiende'].'</td></tr>';
                                        $i++;
                                    }
                                    ?>
                                </table>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="text-align:justify" width="60%">
                <table>

                    <tr>
                        <td>
                        <table width="100%" align="left" cellspacing="5">
                            <tr>
                                <td style="border-bottom: 3px solid #e9b108;">
                                    <b>Educacion</b>
                                </td>
                            </tr>
                        </table>
                        <p style="align-items: center;">
                            <table style="font-size: 11px;" cellpadding="8">
                                    <?php
                                        $i = 1;
                                        foreach ($this->datos_estudio as $datos) {
                                            if ($i % 2 != 0) {
                                                echo '<tr style="background-color: #34495E; color: white;"><td width="35%"><table><tr><td><b>'.$datos['nivel'].'</b></td></tr><tr><td style="font-size: 10px;">'.$datos['fecha_inicio'].' - '.$datos['fecha_fin'].'</td></tr><tr><td>'.$datos['localidad'].'</td></tr></table></td><td style="background-color: #2C3E50; color: white;" width="60%"><table><tr><td><b>Titulo '.$datos['titulo'].'</b></td></tr><tr><td>'.$datos['institucion'].'</td></tr></table></td></tr>';
                                            }else{
                                                echo '<tr style="background-color: #5D6D7E; color: white;"><td width="35%"><table><tr><td><b>'.$datos['nivel'].'</b></td></tr><tr><td style="font-size: 10px;">'.$datos['fecha_inicio'].' - '.$datos['fecha_fin'].'</td></tr><tr><td>'.$datos['localidad'].'</td></tr></table></td><td style="background-color: #566573; color: white;" width="60%"><table><tr><td><b>Titulo '.$datos['titulo'].'</b></td></tr><tr><td>'.$datos['institucion'].'</td></tr></table></td></tr>';
                                            }
                                            $i++;

                                        }
                                    ?>
                            </table>
                        </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <table width="100%" align="left" cellpadding="2px">
                            <tr>
                                <td style="border-bottom: 3px solid #e9b108;">
                                    <b>Experiencia Laboral</b>
                                </td>
                            </tr>
                        </table>
                        <p>
                            <table cellpadding="8" style="font-size: 11px;" >
                                <?php
                                $i = 1;
                                foreach ($this->datos_experiencia as $datos) {
                                    if ($i % 2 != 0) {
                                        echo '<tr style="background-color: #34495E; color: white;"><td><b>Empresa: </b> '.$datos['empresa'].'</td><td ><table><tr><td><b>Cargo: </b>'.$datos['cargo'].'</td></tr><tr><td>'.$datos['fecha_inicio'].' - '.$datos['fecha_fin'].'</td></tr></table></td></tr>';
                                    }else{
                                        echo '<tr style="background-color: #5D6D7E; color: white;"><td><b>Empresa: </b> '.$datos['empresa'].'</td><td ><table><tr><td><b>Cargo: </b>'.$datos['cargo'].'</td></tr><tr><td>'.$datos['fecha_inicio'].' - '.$datos['fecha_fin'].'</td></tr></table></td></tr>';
                                    }

                                    $i++;
                                }
                                ?>
                            </table>
                         </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
</table></font>




