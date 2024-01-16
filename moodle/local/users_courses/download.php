<?php

require_once("../../config.php");
require_once($CFG->dirroot."/local/users_courses/locallib.php");

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Ods;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

// Require login.
require_login();

$context = context_system::instance();
$PAGE->set_context($context);

// check_permissions
if (!has_capability('local/users_courses:view', $context))
{
    print_error('badpermissions');
	return;
}

$type = optional_param('type', 'csv', PARAM_RAW);

// Obtén la lista de todos los usuarios en el sitio
$dataUsers = getAllUsersCourses();

// Generar el archivo según el tipo especificado
switch ($type) {
    case 'excel':
         
        $spreadsheet = prepareExcelUsersCourses($dataUsers);
        // Crea un objeto de escritura para Excel (XLSX)
        $writer = new Xlsx($spreadsheet);
       
        // Configura las cabeceras para la descarga
        // Output
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="users_data_excel.xlsx"');

        ob_end_clean();

        // Envía el archivo al navegador
        $writer->save('php://output');
        break;

    case 'csv':

        $spreadsheet = prepareExcelUsersCourses($dataUsers);

        // Configura las cabeceras para la descarga del archivo CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="users_data_csv.csv"');

        // Crea un objeto de escritura para CSV
        $writer = new Csv($spreadsheet);

        // Envia la salida del CSV al navegador
        $writer->save('php://output');
        break;

    case 'ods':
        $spreadsheet = prepareExcelUsersCourses($dataUsers);
        
        // Configura las cabeceras para la descarga
        // Output
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="users_data_ods.ods"');

        ob_end_clean();

        // Crea un objeto de escritura para ODS
        $writer = new Ods($spreadsheet);
        // Envía el archivo al navegador
        $writer->save('php://output');
        break;

    case 'json':
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="users_data_json.json"');

        echo json_encode($dataUsers, JSON_PRETTY_PRINT);
        break;

    case 'html':
        $spreadsheet = prepareExcelUsersCourses($dataUsers);

        // Configura las cabeceras para la descarga
        header('Content-Type: text/html');
        header('Content-Disposition: attachment;filename="users_data_html.html"');

        // Crea un objeto de escritura para HTML
        $writer = new Html($spreadsheet);

        // Envia la salida del HTML al navegador
        $writer->save('php://output');
        break;

    default:
        throw new Exception('Error on generate file');
        break;
}

