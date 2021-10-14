<?php

    error_reporting(0);
    include_once 'connect.php';

    header('Content-Type: text/html; charset=UTF-8');

    if (empty($_POST['centro'])) {
        print '<script type="text/javascript">';
        print 'alert("No hay datos")';
        print '</script>';

        print '<script language="JavaScript">';
        print  'location.href = "PONER DIR DE INDEX"';
        print '</script>"';
    }
    else {

        $sql = "SELECT * FROM ... WHERE centro='".$_POST['centro']."' ORDER BY curso, asignatura";

        $result = mysqli_query($mysqli, $sql);

        // verificamos que no haya error
        if (!$result) {
            echo "La consulta SQL contiene errores.".mysqli_error();
            exit();
        } 
        else {

            require('fpdf182/fpdf.php');
            
            class PDF extends FPDF{

                function Footer(){
                    $this->SetY(-25);
                    $this->SetFont('Arial', 'I', 10);
                    $this->Image('img/cabecera.png', 105, 250, 25, 25, 'PNG');
                }
            }

            $pdf = new FPDF('L', 'mm', 'A3');
            $pdf->AddPage();
            $pdf->SetFont(Arial, 'BU', 10);
            $pdf->Image('img/cabecera.png', 5, 10, 400, 22, 'PNG', 'PONER DIR');
            $pdf->MultiCell(190, 10,'');
            $pdf->MultiCell(190, 10,'');
            $pdf->MultiCell(190, 10,'');
        
            $pdf->Cell(15, 8, utf8_decode("Curso:"), 1);
            $pdf->Cell(20, 8, utf8_decode("Codigo"), 1);
            $pdf->Cell(175, 8, utf8_decode("Asignatura:"), 1);
            $pdf->Cell(80, 8, utf8_decode("Tipo:"), 1);
            $pdf->Cell(32, 8, utf8_decode("Curso Académico"), 1);
            $pdf->Cell(20, 8, utf8_decode("Fecha"), 1);
            $pdf->Ln();
        
            while ($row = mysqli_fetch_array($result)) {
        
                $curso = utf8_decode($row['curso']);
                $asignatura = utf8_decode($row['asignatura']);
                $codigo = utf8_decode($row['codigo']);
                $creditos = utf8_decode($row['creditos']);
                $tipo = utf8_decode($row['tipo']);
                $departamento = utf8_decode($row['departamento']);
                $vigencia = utf8_decode($row['vigencia']);
                $titulacion = utf8_decode($row['titulacion']);
                $centro =  utf8_decode($row['centro']);
                $annyo = utf8_decode($row['annyo']);
                $fecha = utf8_decode($row['fecha']);
        
                $pdf->Cell(15, 8, $curso, 1);
                $pdf->Cell(20, 8, $codigo, 1);
                $pdf->Cell(175, 8, $asignatura, 1);
                $pdf->Cell(80, 8, $tipo, 1);
                $pdf->Cell(32, 8, $annyo, 1);
                $pdf->Cell(20, 8, $fecha, 1);
                $pdf->Ln();
        
            }
            
            $pdf->Output();
            ob_end_flush();
                
        }
    }
    
?>