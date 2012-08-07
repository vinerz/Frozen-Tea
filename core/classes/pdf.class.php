<?php
class pdf {
    function __construct() {
        global $configuration;
        require_once( dirname(__FILE__) . "/../libraries/dompdf/dompdf_config.inc.php");
        
        $this->entities = array('À'=>'&Agrave;', 'à'=>'&agrave;', 'Á'=>'&Aacute;', 'á'=>'&aacute;', 'Â'=>'&Acirc;', 'â'=>'&acirc;', 'Ã'=>'&Atilde;', 'ã'=>'&atilde;', 'Ä'=>'&Auml;', 'ä'=>'&auml;', 'Å'=>'&Aring;', 'å'=>'&aring;', 'Æ'=>'&AElig;', 'æ'=>'&aelig;', 'Ç'=>'&Ccedil;', 'ç'=>'&ccedil;', 'Ð'=>'&ETH;', 'ð'=>'&eth;', 'È'=>'&Egrave;', 'è'=>'&egrave;', 'É'=>'&Eacute;', 'é'=>'&eacute;', 'Ê'=>'&Ecirc;', 'ê'=>'&ecirc;', 'Ë'=>'&Euml;', 'ë'=>'&euml;', 'Ì'=>'&Igrave;', 'ì'=>'&igrave;', 'Í'=>'&Iacute;', 'í'=>'&iacute;', 'Î'=>'&Icirc;', 'î'=>'&icirc;', 'Ï'=>'&Iuml;', 'ï'=>'&iuml;', 'Ñ'=>'&Ntilde;', 'ñ'=>'&ntilde;', 'Ò'=>'&Ograve;', 'ò'=>'&ograve;', 'Ó'=>'&Oacute;', 'ó'=>'&oacute;', 'Ô'=>'&Ocirc;', 'ô'=>'&ocirc;', 'Õ'=>'&Otilde;', 'õ'=>'&otilde;', 'Ö'=>'&Ouml;', 'ö'=>'&ouml;', 'Ø'=>'&Oslash;', 'ø'=>'&oslash;', 'Œ'=>'&OElig;', 'œ'=>'&oelig;', 'ß'=>'&szlig;', 'Þ'=>'&THORN;', 'þ'=>'&thorn;', 'Ù'=>'&Ugrave;', 'ù'=>'&ugrave;', 'Ú'=>'&Uacute;', 'ú'=>'&uacute;', 'Û'=>'&Ucirc;', 'û'=>'&ucirc;', 'Ü'=>'&Uuml;', 'ü'=>'&uuml;', 'Ý'=>'&Yacute;', 'ý'=>'&yacute;', 'Ÿ'=>'&Yuml;', 'ÿ'=>'&yuml;');
        
        $this->PDFHeaderImage = $configuration->get("PDFHeaderImage");
        $this->PDFHeaderText = $configuration->get("PDFHeaderText");
        $this->PDFFooterText = $configuration->get("PDFFooterText");
    }
    
    function render($content, $outputFile = false) {
		$dompdf = new DOMPDF();
		$html = '
			<html>
				<head>
					<style type="text/css">
						@page { margin: 100px 40px; }
					    body { font-family: Helvetica }
						.prodData {
							width: 100%;
							border: 1px solid #D63333;
						}
						
						.prodData td {
							border-bottom: 1px solid #DE5C5C;
						}
						
						.prodData tr.light td {
							background: #EFEFEF;
						}
						
						.prodData tr.dark td {
							background: #DCDCDC;
						}
						
						.prodContent {
							width: 100%;
							border: 1px solid #D63333;
						}
						
						.prodContent .title td {
							background: #F06A6A;
							padding: 6px;
							text-align: center;
						}
						
						.headerTitle {
						    padding-left: 7px;
						    color: #DD0000;
						    font-size: 28px
						}
					</style>
				</head>
				
				<body>
			      <script type="text/php">
                    if ( isset($pdf) ) {

                      // Open the object: all drawing commands will
                      // go to the object instead of the current page
                      $footer = $pdf->open_object();

                      $w = $pdf->get_width();
                      $h = $pdf->get_height();

                      // Draw a line along the bottom
                      $y = $h - 27;
                      $y2 = 70;
                      $pdf->line(30, $y, $w - 30, $y, $color, 1);
                      $pdf->line(30, $y2, $w - 30, $y2, $color, 1);

                      $total = $pdf->get_page_count();
                      $current = $pdf->get_page_number();
                      $font = Font_Metrics::get_font("helvetica", "normal");
                      $text = "'.$this->PDFFooterText.' - Página {PAGE_NUM} de {PAGE_COUNT}";
                      $width = Font_Metrics::get_text_width($text, $font, 10);
                      $pdf->page_text(30, $y+3, $text, $font, 10, array(.5,.5,.5));

                      // Add a logo
                      $pdf->image("'.$this->PDFHeaderImage.'", "png", 0, 0, 65, 40);

                      $pdf->close_object();

                      $pdf->add_object($footer, "all");
                    }

                    </script>
				    <div id="content">
				      '.strtr($content, $this->entities).'
				    </div>
				</body>
			</html>';
		$dompdf->load_html($html);
		$dompdf->set_paper('a4', 'portrait');
		$dompdf->render();
		
		if($outputFile) {
		    $dompdf->stream($outputFile);
		} else {
		    header("Content-type: application/pdf; charset=UTF-8"); 
		    echo $dompdf->output();
		}
	}
}
?>
