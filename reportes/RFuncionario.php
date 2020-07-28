<?php
// Extend the TCPDF class to create custom MultiRow
class RFuncionario extends  ReportePDF {
	var $cabecera;
	var $detalleCbte;
	var $ancho_hoja;
	var $gerencia;
	var $numeracion;
	var $ancho_sin_totales;
	var $cantidad_columnas_estaticas;
	var $total;
	var $with_col;
	var $datos_proyecto;
	var $datos_idiomas ;
    var $datos_persona ;
    var $datos_estudio ;
    var $datos_allegado ;
    var $datos_experiencia;
    var $datos_competencia;
    var $datos_residencia;
    var $datos_estructura;
    var $imagenes;
    var $host;
	function datosHeader ( $detalle) {

        $this->datos_proyecto = $detalle->getParametro('datos_proyecto');
        $this->datos_idiomas = $detalle->getParametro('datos_idiomas');
        $this->datos_persona = $detalle->getParametro('datos_persona');
        $this->datos_estudio = $detalle->getParametro('datos_estudio');
        $this->datos_allegado = $detalle->getParametro('datos_allegado');
        $this->datos_experiencia = $detalle->getParametro('datos_experiencia');
        $this->datos_competencia = $detalle->getParametro('datos_competencia');
        $this->datos_residencia = $detalle->getParametro('datos_residencia');
        $this->datos_estructura = $detalle->getParametro('datos_estructura');

        //$this->imagenes = 'http://172.18.79.207/ymedinaetr/sis_seguridad/control/foto_persona/ActionObtenerFoto.php?file='.$this->datos_persona[0]['nombre_archivo_foto'];
        ob_start();
        //include_once(dirname(__FILE__).'/../../lib/lib_general/ExcelInput.php');
        header( "Content-type: image/jpeg" );
        include(dirname(__FILE__).'/../../sis_seguridad/control/foto_persona/ActionObtenerFoto.php');
        $this->imagenes = ob_get_clean();
        /*$files = glob(dirname(__DIR__) . '/../../../' . $_SESSION['_FOLDER_FOTOS_PERSONA'] . '/' . $filename . '.*');
        var_dump('datos_ejecucion', $files);*/
        $this->host  = $_SERVER['HTTP_HOST'].'/'.strtok(dirname($_SERVER['PHP_SELF']), "/");
        //var_dump('YAMILLLLLL ',  $this->host);

        $this->SetHeaderMargin(15); //margen top header
		 
	}
	
	function Header() {
                $this->SetHeaderMargin(0);
                //$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		 	    $this->SetMargins(10, 10, 10);
				$newDate = date("d/m/Y", strtotime( $this->cabecera[0]['fecha']));		
				$dataSource = $this->datos_detalle; 
			    ob_start();
				include(dirname(__FILE__).'/../reportes/funcionario/cabecera.php');
		        $content = ob_get_clean();
				$this->writeHTML($content, false, false, false, false, '');

	}

	 function generarReporte1() {
	 	
		$this->AddPage();
		
		$with_col = $this->with_col;
         //adiciona glosa
		ob_start();
		include(dirname(__FILE__).'/../reportes/funcionario/cuerpo.php');
        $content = ob_get_clean();
		
		ob_start();
		include(dirname(__FILE__).'/../reportes/funcionario/detalle.php');
        $content2 = ob_get_clean();
		$this->writeHTML($content.$content2, false, false, false, false, '');
		
		$this->SetFont ('helvetica', '', 5 , '', 'default', true );
		
		//$this->Ln(2);
		//$this->revisarfinPagina($content);

		$this->Ln(2);
		
	} 

   function revisarfinPagina($content){
		$dimensions = $this->getPageDimensions();
		$hasBorder = false; //flag for fringe case
		
		$startY = $this->GetY();
		$test = $this->getNumLines($content, 80);
		
		//if (($startY + 10 * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
		    
		//if ($startY +  $test > 250) {
		$auxiliar = 400;
		//if($this->page==1){
		//	$auxiliar = 250;	
		//}
		if ($startY +  $test > $auxiliar) {
			//$this->Ln();
			//$this->subtotales('Pasa a la siguiente página. '.$startY);
			$this->subtotales('Pasa a la siguiente página');
			$startY = $this->GetY();			
			if($startY < 70){
				//$this->AddPage();
			}
			else{
				$this->AddPage();
			}
			
			
			//$this->writeHTML('<p>text'.$startY.'</p>', false, false, true, false, '');		    
		} 
	}
}
?>