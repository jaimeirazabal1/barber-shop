<?php

use \Barber\Repositories\Exceptions\Sort\SortableFieldNotAllowed;
use \Barber\Repositories\Exceptions\Sort\SortableFieldInvalid;

/**
 * Construye un arreglo de los campos a ordenar
 *
 *
 * @param $fields
 * @param array $allowedFields
 * @return array
 * @throws SortableFieldInvalid
 * @throws SortableFieldNotAllowed
 */

function build_sortable_fields($fields, array $allowedFields)
{
    # Retorna un arreglo vacio si $fields es un valor vacio
    if ( empty($fields) or $fields == '')
    {
        return array();
    }

    $fields   = explode(',', $fields);

    $sort  = array();

    foreach($fields as $field)
    {
        # Orden del campo: asc o desc
        $order_desc = starts_with($field, '-');

        # Válida si el campo es válido
        if ( ! $order_desc and ! preg_match('/^[a-z]/i', $field))
        {
            throw new SortableFieldInvalid("The field {$field} specified is not valid.");
        }

        # Elimina el '-' si es que el ordenamiento del campo es desc
        $field = $order_desc ? ltrim ($field, '-') : $field;

        # Verifica si el campo es válido para ordenar
        if ( array_search($field, $allowedFields) === false )
        {
            throw new SortableFieldNotAllowed("The field {$field} is not sortable.");
        }

        $order = $order_desc ? 'desc' : 'asc';

        $sort[] = [
            'field' => $field,
            'order' => $order
        ];
    }

    return $sort;
}


/**
 * Obtiene los datos enviados por el Usuario
 *
 * @return array
 */
function getApiInput()
{
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    return $data;
}


/**
 * @return array
 */
function getDayOptions()
{
    $days = [
        '' => 'Día'
    ];
    for($i = 1; $i <= 31; $i++)
    {
        $days[$i] = $i;
    }

    return $days;
}

/**
 * @return array
 */
function getYearOptions()
{
    $years = [
        '' => 'Año'
    ];
    for($i = date('Y'); $i >= 1920; $i--)
    {
        $years[$i] = $i;
    }

    return $years;
}

/**
 *
 */
function getMonthOptions()
{
    $months = [
        ''  => 'Mes',
        '1' => 'Enero',
        '2' => 'Febrero',
        '3' => 'Marzo',
        '4' => 'Abril',
        '5' => 'Mayo',
        '6' => 'Junio',
        '7' => 'Julio',
        '8' => 'Agosto',
        '9' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
    ];

    return $months;
}

function getMonth($month)
{
    $months = getMonthOptions();

    return $months[$month];
}


/**
 * @param $status
 * @return string
 */
function getAppointmentStatus($status)
{
    $status_text = '';

    switch($status)
    {
        case 'pending':
            $status_text = 'Pendiente';
            break;
        case 'confirmed':
            $status_text = 'Confirmada';
            break;
        case 'canceled':
            $status_text = 'Cancelada';
            break;
        case 'completed':
            $status_text = 'Completada';
            break;
        case 'process':
            $status_text = 'En proceso';
            break;
        default:
            $status_text = 'No definido';
            break;
    }

    return $status_text;
}


/**
 * Convierte una cantidad monetaria en entero
 *
 * @param $amount
 * @return float
 */
function convertMoneyToInteger($amount)
{
    $amount = (float) str_replace(',', '', $amount); # Elimina las comas
    return ($amount * 100);
}

/**
 * Convierte un número entero a su representación monetaria
 *
 * @param $amount
 * @return string
 */
function convertIntegerToMoney($amount)
{
    return number_format($amount / 100, 2);
}


/**
 * Convierte un valor númerico a formato en efectivo
 *
 * @param $amount
 * @return string
 */
function formatToMoney($amount)
{
    $amount = (float) str_replace(',', '', $amount); # Elimina las comas
    return number_format($amount, 2);
}


/**
 * @return array
 */
function getScheduleDays()
{
    return [
        'MONDAY' => 'Lunes',
        'TUESDAY' => 'Martes',
        'WEDNESDAY' => 'Miercoles',
        'THURSDAY' => 'Jueves',
        'FRIDAY' => 'Viernes',
        'SATURDAY' => 'Sábado',
        'SUNDAY' => 'Domingo'
    ];
}


/**
 * @return array
 */
function getDay($dayOfWeek)
{
    $days = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miercoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado'
    ];

    return $days[$dayOfWeek];
}

/**
 * @param $day
 * @return mixed
 */
function getDayOfWeek($day)
{
    $days = [
        0 => 'SUNDAY',
        1 => 'MONDAY',
        2 => 'TUESDAY',
        3 => 'WEDNESDAY',
        4 => 'THURSDAY',
        5 => 'FRIDAY',
        6 => 'SATURDAY'
    ];

    return $days[$day];
}


/**
 *
 * Determina el día de la semana (Dom - Sáb) y obtiene la jornada laboral de Lun - Sáb
 *
 * @param $timestamp
 * @return array
 */
function getWorkDays($timestamp)
{
    $date_start = Carbon\Carbon::createFromTimestamp($timestamp);
    $date_end   = Carbon\Carbon::createFromTimestamp($timestamp);

    switch($date_start->dayOfWeek)
    {
        case 0: // Domingo
            $date_start->subDays(6);
            $date_end->subDays(1);
            break;
        case 1: // Lunes
            $date_end->addDays(5);
            break;
        case 2: // Martes
            $date_start->subDay();
            $date_end->addDays(4);
            break;
        case 3: // Miercoles
            $date_start->subDays(2);
            $date_end->addDays(3);
            break;
        case 4: // Jueves
            $date_start->subDays(3);
            $date_end->addDays(2);
            break;
        case 5: // Viernes
            $date_start->subDays(4);
            $date_end->addDays(1);
            break;
        case 6: // Sábado
            $date_start->subDays(5);
            break;
    }

    return [
        'start' => $date_start, // Lunes - Inicio de jornada laboral
        'end'   => $date_end // Sábado - Fin de jornada laboral
    ];
}

/**
 * Obtiene el estatus del checkin
 *
 * @param $status
 * @return string
 */
function getCheckinStatus($status)
{
    $text_status = '';

    switch($status)
    {
        case 'present':
            $text_status = 'Asistencia';
            break;
        case 'absence':
            $text_status = 'Falta';
            break;
        case 'retardment':
            $text_status = 'Retardo';
            break;
        case 'excused_absence':
            $text_status = 'Falta Justificada';
            break;
        case 'vacation':
            $text_status = 'Vacaciones';
            break;
    }

    return $text_status;
}

/**
 * Opciones para los tipos de asistencia (checkins)
 *
 *
 * @return array
 */
function getCheckinsOptions()
{
    return [
        'present' => 'Asistencia',
        'absence' => 'Falta',
        'retardment' => 'Retardo',
        'excused_absence' => 'Falta Justificada',
        'vacation' => 'Vacaciones',
    ];
}

/**
 * Calcula el total de las comisiones de acuerdo a las ventas y el porcentaje
 *
 * @param $percent
 * @param $sales
 * @return float|int
 */
function calculateTotalCommissions($percent, $sales)
{
    if ($percent == 0 or $sales == 0)
    {
        return 0;
    }

    return (($sales * $percent) / 100);
}

/**
 * Calcula el salario de acuerdo a los dias laborados y el salario del barbero
 *
 * @param $salary
 * @param $journeyDays
 * @param $absenceDays
 * @return float
 */
function calculateSalaryBarber($salary, $journeyDays, $absenceDays)
{
    return (($salary / $journeyDays) * ($journeyDays - $absenceDays));
}