<?php
require_once 'application/reports/fpdf.php';
//require('application/reports/fpdf.php');

class ComprobantePago extends FPDF
{
    
    function Header() //Encabezado
    {
        //Define tipo de letra a usar, Arial, Negrita, 15
        $this->SetFont('Arial','B',9);
 
        /* L�neas paralelas
         * Line(x1,y1,x2,y2)
         * El origen es la esquina superior izquierda
         * Cambien los par�metros y chequen las posiciones
         * */
        //$this->Line(10,10,206,10);
        //$this->Line(10,35.5,206,35.5);
 
        /* Explicar� el primer Cell() (Los siguientes son similares)
         * 30 : de ancho
         * 25 : de alto
         * ' ' : sin texto
         * 0 : sin borde
         * 0 : Lo siguiente en el c�digo va a la derecha (en este caso la segunda celda)
         * 'C' : Texto Centrado
         * $this->Image('images/logo.png', 152,12, 19) M�todo para insertar imagen
         *     'images/logo.png' : ruta de la imagen
         *     152 : posici�n X (recordar que el origen es la esquina superior izquierda)
         *     12 : posici�n Y
         *     19 : Ancho de la imagen <span class="wp-smiley emoji emoji-wordpress" title="(w)">(w)</span>
         *     Nota: Al no especificar el alto de la imagen (h), �ste se calcula autom�ticamente
         * */
        
        $this->Image('public/images/spazio.jpg',10,11,33);
        $this->Cell(30,25,'',0,0,'C');
        $this->Cell(111,25,'SPAZIO FITNESS',0,0,'C');
 
    }
    
    function Footer() // Pie de p�gina
    {
        // Posici�n: a 1,5 cm del final
        $this->SetY(-155);
        // Arial italic 8
        $this->SetFont('Arial','I',10);
        /* Cell(ancho, alto, txt, border, ln, alineacion)
         * ancho=0, extiende el ancho de celda hasta el margen de la derecha
         * alto=10, altura de la celda a 10
         * txt= Texto a ser impreso dentro de la celda
         * border=T Pone margen en la posici�n Top (arriba) de la celda
         * ln=0 Indica d�nde sigue el texto despu�s de llamada a Cell(), en este caso con 0, enseguida de nuestro texto
         * alineaci�n=C Texto alineado al centro
         */
        //$this->Cell(0,10,'Nota: Esta empresa no se hace responsable por accidentes o da�os a la salud como consecuencia de enfermedades ya presentes en el individuo. ','',0,'C');
        
        $txt = 'Nota: Esta empresa no se hace responsable por accidentes o da�os a la salud como consecuencia de enfermedades ya presentes en el individuo. ';
        $this->SetLeftMargin(20);
        $this->SetRightMargin(20);
        $this->MultiCell(0,5,$txt,0,'L');
        
    }     
    
    function ImprimirTexto($pago, $persona, $paquete)
    {      
        $this->Rect(10, 10, 196, 130);
        $this->SetFont('Arial','',12);
        
        $horY = 60; //coordenada Y de las lineas horizontales
        $this->SetY($horY - 5);
        
        /*
         * 0 - el ancho se ajusta al margen de la hoja
         * 5 - alto de la celda
         * $txt - Texto a imrpimir.
         * NOTA: Los valores para justificar el texto y celda sin borde
         *       no los pas�, porque son valores por defecto del mismo m�todo
         *
         * Pero quedar�a as�: MutiCell(0, 5, $txt, 0, 'J')
         * No olviden ver y 'jugar' con los par�metros
         **/        
        $txt = "Nombre:   " . utf8_decode($persona->nombre) . " " . utf8_decode($persona->apaterno) . " " . utf8_decode($persona->amaterno);         
        $this->SetX(20);
        $this->MultiCell(0,5,$txt);
        $this->Line(38,$horY,180,$horY);
        $this->Ln();
        $horY += 10;
        
        $txt = "Fecha de Pago:   " . date("d/m/Y", strtotime($pago->fecha));       
        $this->SetX(20);
        $this->MultiCell(0,5,$txt);
        $this->Line(52,$horY,180,$horY);
        $this->Ln();
        $horY += 10;        
        
        $txt = "Mensualidad a Cubrir:   $ $pago->monto M.N."; 
        $this->SetX(20);
        $this->MultiCell(0,5,$txt);
        $this->Line(63,$horY,180,$horY);        
        $this->Ln();
        $horY += 10;
        
        $txt = "Paquete:   " . utf8_decode($paquete->titulo); 
        $this->SetX(20);
        $this->MultiCell(0,5,$txt);
        $this->Line(39,$horY,180,$horY);                
        $this->Ln();        
        $horY += 10;
        
    }    
            
}

    $pdf = new ComprobantePago();  //Crea objeto PDF
    $pdf->AddPage('P', 'Letter'); //Agrega hoja, Vertical, Carta
    
    $pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
    /* Explicaci�n:
        * 0 - La celda se extiende a todo lo ancho de la hoja
        * 10 - Alto de la celda
        * $fecha - la cadena a imprimir
        * 0 - sin borde (cambien a 1 y chequen el cambio)
        * 1 - Lo que sigue a la celda estar� en la siguiente l�nea
        * 'R' - Texto alineado a la derecha
        * */
    $pdf->Ln(20);
    $pdf->Cell(0,10,'MENSUALIDAD',0,1,'C');
    
    /* Se hace un salto de l�nea
        * y se manda llamar el m�todo de imprimir texto,
        * env�ando como par�metro el nombre del archivo
        * que contiene el texto.
    * */
    $pdf->Ln();
    $pdf->ImprimirTexto($pago, $persona, $paquete);    
        
    $pdf->Output();               //Salida al navegador
