<?php

    include_once 'connect.php';

    if (empty($_POST['centro']) || empty($_POST['titulacion'])) {
        print '<script type="text/javascript">';
        print 'alert("No hay datos")';
        print '</script>';

        print '<script language="JavaScript">';
        print  'location.href = "PONER DIR DEL INDEX"';
        print '</script>"';
    }
    else {

        //ejecutamos la consulta
        $query = $mysqli->query("SELECT * FROM ... WHERE centro='" . $_POST['centro'] . "' AND titulacion='" . $_POST['titulacion'] . "' ORDER BY curso, asignatura");
        
		if($query->num_rows > 0){
		    $delimiter = ";";
		    $filename = "csv_titulacion". ".csv";
		    
		    //create a file pointer
		    $f = fopen('php://memory', 'w');
		    
		    //set column headers
		    $fields = array('Curso', 'Codigo', 'Asignatura', 'Tipo', 'Curso Academico', 'Fecha');
		    fputcsv($f, $fields, $delimiter);
		    
		    //output each row of the data, format line as csv and write to file pointer
		    while($row = $query->fetch_assoc()){
		        $lineData = array($row['curso'], $row['codigo'], $row['asignatura'], $row['tipo'], $row['annyo'],$row['fecha']);
		        fputcsv($f, $lineData, $delimiter);
		    }
		    
		//move back to beginning of file
		fseek($f, 0);
		    
		//set headers to download file rather than displayed
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		    
		//output all remaining data on a file pointer
		fpassthru($f);
	}
	exit;
}
?>

