<?php
require_once 'application/reports/fpdf.php';
//require('application/reports/fpdf.php');

class Inscripciones extends FPDF
{
    
    function Header() //Encabezado
    {
        //Define tipo de letra a usar, Arial, Negrita, 15
        $this->SetFont('Arial','B',9);
 
        /* Líneas paralelas
         * Line(x1,y1,x2,y2)
         * El origen es la esquina superior izquierda
         * Cambien los parámetros y chequen las posiciones
         * */
        //$this->Line(10,10,206,10);
        //$this->Line(10,35.5,206,35.5);
 
        /* Explicaré el primer Cell() (Los siguientes son similares)
         * 30 : de ancho
         * 25 : de alto
         * ' ' : sin texto
         * 0 : sin borde
         * 0 : Lo siguiente en el código va a la derecha (en este caso la segunda celda)
         * 'C' : Texto Centrado
         * $this->Image('images/logo.png', 152,12, 19) Método para insertar imagen
         *     'images/logo.png' : ruta de la imagen
         *     152 : posición X (recordar que el origen es la esquina superior izquierda)
         *     12 : posición Y
         *     19 : Ancho de la imagen <span class="wp-smiley emoji emoji-wordpress" title="(w)">(w)</span>
         *     Nota: Al no especificar el alto de la imagen (h), éste se calcula automáticamente
         * */
        
        $this->Image('public/images/spazio.jpg',10,11,33);
        $this->Cell(30,25,'',0,0,'C');
        $this->Cell(111,25,'SPAZIO FITNESS',0,0,'C');
 
    }
    
    function Footer() // Pie de página
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',10);
        /* Cell(ancho, alto, txt, border, ln, alineacion)
         * ancho=0, extiende el ancho de celda hasta el margen de la derecha
         * alto=10, altura de la celda a 10
         * txt= Texto a ser impreso dentro de la celda
         * border=T Pone margen en la posición Top (arriba) de la celda
         * ln=0 Indica dónde sigue el texto después de llamada a Cell(), en este caso con 0, enseguida de nuestro texto
         * alineación=C Texto alineado al centro
         */
        //$this->Cell(0,10,'Nota: Esta empresa no se hace responsable por accidentes o daños a la salud como consecuencia de enfermedades ya presentes en el individuo. ','',0,'C');
        
        $txt = 'Concentrado Mensual de Pagos de Clientes por Concepto de Inscripción. ';        
        $this->SetLeftMargin(20);
        $this->SetRightMargin(20);
        $this->MultiCell(0,5,$txt,0,'L');        
    }         
    
    // Tabla simple
    function BasicTable($header, $data)
    {
        // Cabecera
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Datos
        foreach($data as $record)
        {
            //foreach($row as $col)
            //    $this->Cell(40,6,$col,1);
            $this->Cell(40,6,str_pad((int) $record->idpersona,6,"0",STR_PAD_LEFT),1);
            $this->Cell(40,6,"$record->nombre $record->apaterno $record->amaterno",1);
            $this->Cell(40,6,date("d/m/Y", strtotime($record->fecha)),1);
            $this->Cell(40,6,"$ $record->monto",1);
            $this->Ln();
        }
    }       
    
    // Una tabla más completa
    function ImprovedTable($header, $data)
    {
        // Anchuras de las columnas
        $w = array(20, 100, 30, 30);
        // Cabeceras
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C');
        $this->Ln();
        // Datos
        foreach($data as $record)
        {
            $this->Cell($w[0],6,str_pad((int) $record->idpersona,6,"0",STR_PAD_LEFT),'LR');
            $this->Cell($w[1],6,"$record->nombre $record->apaterno $record->amaterno",'LR');
            $this->Cell($w[2],6,date("d/m/Y", strtotime($record->fechainscripcion)),'LR',0,'R');
            $this->Cell($w[3],6,"$ $record->montoinscripcion",'LR',0,'R');
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }

}

    $pdf = new Inscripciones();  //Crea objeto PDF
    $pdf->AddPage('P', 'Letter'); //Agrega hoja, Vertical, Carta
    
    $fecha = "$nombreMes $anho";
    $pdf->SetRightMargin(20);
    $pdf->Cell(0,10,$fecha,0,1,'R');
    
    $pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
    /* Explicación:
        * 0 - La celda se extiende a todo lo ancho de la hoja
        * 10 - Alto de la celda
        * $fecha - la cadena a imprimir
        * 0 - sin borde (cambien a 1 y chequen el cambio)
        * 1 - Lo que sigue a la celda estará en la siguiente línea
        * 'R' - Texto alineado a la derecha
        * */
    $pdf->Ln(30);
    $pdf->Cell(0,10,'CONCENTRADO MENSUAL DE PAGOS DE INSCRIPCIÓN',0,1,'C');
    
    /* Se hace un salto de línea
        * y se manda llamar el método de imprimir tabla,
        * envíando como parámetro la cabecera y los datos.
    * */
    $pdf->Ln();
    
    $pdf->SetLeftMargin(10);
    $header = array('Cliente', 'Nombre', 'Fecha Inscrip.', 'Monto');
    $pdf->ImprovedTable($header, $personaList);
    
    
    $pdf->Output();               //Salida al navegador
