<?php

    include_once 'connect.php';

    if (empty($_POST['centro'])) {
        print '<script type="text/javascript">';
        print 'alert("No hay datos")';
        print '</script>';

        print '<script language="JavaScript">';
        print  'location.href = "PONER LA DIR DE INDEX"';
        print '</script>"';
    }
    else {
		$query = $mysqli->query("SELECT * FROM ... WHERE centro='".$_POST['centro']."' ORDER BY curso, asignatura");

		if($query->num_rows > 0){
		    $delimiter = ";";
		    $filename = "csv_centro". ".csv";
		    
		    //create a file pointer
		    $f = fopen('php://memory', 'w');
		    
		    //set column headers
		    $fields = array('Curso', 'Codigo', 'Asignatura', 'Tipo', 'Curso Academico', 'Fecha');
		    fputcsv($f, $fields, $delimiter);
		    
		    //output each row of the data, format line as csv and write to file pointer
		    while($row = $query->fetch_assoc()){
		        $lineData = array(utf8_decode($row['curso']), utf8_decode($row['codigo']), utf8_decode($row['asignatura']), utf8_decode($row['tipo']), utf8_decode($row['annyo']),utf8_decode($row['fecha']));
		        fputcsv($f, $lineData, $delimiter);
		    }
		    
		//move back to beginning of file
		fseek($f, 0);
		    
		//set headers to download file rather than displayed
		header('Content-Type: application/csv; charset=ISO-8859-1');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		    
		//output all remaining data on a file pointer
		fpassthru($f);
	}
	exit;
}

?>

