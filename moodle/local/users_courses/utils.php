<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;

function getHTMLSelectOptions($options, $defaultlabel, $selected_value = null) {
    $html = '';

    // Default label
    if($defaultlabel){
        $html .= '<option value="" >';
        $html .= $defaultlabel;
        $html .= '</option>';
    }
   
    // Options
    foreach($options as $key => $val) {

        $value = is_array($val) ? $val['value'] : $key;
        $html .= '<option value="'; $html .= $value; $html .= '"';

        // selected value
        if(is_string($selected_value)) {
           
            if(is_array($selected_value) && count($selected_value) > 0) {
                if(in_array($value, $selected_value)) {
                    $html .= ' selected';
                }
            } else {
                if($value == $selected_value) {
                    $html .= ' selected';
                }
            }
        }

        $html .= ' >';
            $html .= is_array($val) ? $val['name'] : $val;
        $html .= '</option>';
    }
    
    return $html;
}

function getAllUsersCourses(){
    $users = get_users();

    $dataUsers = [];
    foreach ($users as $user) {
        $user_courses = enrol_get_users_courses($user->id, true);
        foreach ($user_courses as $course) {
            $_dataUsers = [
                'username' => $user->username,
                'fullname' => fullname($user),
                'course'   => $course->fullname
            ];
            array_push($dataUsers, $_dataUsers);
        }

    }
    return $dataUsers;
}

function prepareExcelUsersCourses($dataUsers){

    // Crea una instancia de la clase Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Selecciona la hoja activa
    $sheet = $spreadsheet->getActiveSheet();

    // Añade encabezados
    $sheet->setCellValue('A1', get_string('username', 'local_users_courses'));
    $sheet->setCellValue('B1', get_string('fullname', 'local_users_courses'));
    $sheet->setCellValue('C1', get_string('course', 'local_users_courses'));

    // Llena los datos
    $row = 2;
    foreach ($dataUsers as $data) {
        $sheet->setCellValue('A' . $row, $data['username']);
        $sheet->setCellValue('B' . $row, $data['fullname']);
        $sheet->setCellValue('C' . $row, $data['course']);
        $row++;
    }

    // Aplica estilos a los encabezados
    $styleHeader = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'], // Color del texto en blanco
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FF0000'], // Fondo rojo
        ],
    ];

    $sheet->getStyle('A1:C1')->applyFromArray($styleHeader);

    // Autoajusta el ancho de las columnas
    foreach (range('A', 'C') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    return $spreadsheet;
}