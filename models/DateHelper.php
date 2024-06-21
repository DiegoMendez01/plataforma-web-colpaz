<?php
class DateHelper {
    public static function formatDate($dateString) {
        $date = new DateTime($dateString);
        
        // Array para traducir los días de la semana
        $days = [
            'Sunday' => 'domingo',
            'Monday' => 'lunes',
            'Tuesday' => 'martes',
            'Wednesday' => 'miércoles',
            'Thursday' => 'jueves',
            'Friday' => 'viernes',
            'Saturday' => 'sábado'
        ];

        // Array para traducir los meses
        $months = [
            'January' => 'enero',
            'February' => 'febrero',
            'March' => 'marzo',
            'April' => 'abril',
            'May' => 'mayo',
            'June' => 'junio',
            'July' => 'julio',
            'August' => 'agosto',
            'September' => 'septiembre',
            'October' => 'octubre',
            'November' => 'noviembre',
            'December' => 'diciembre'
        ];

        // Obtener el nombre del día y del mes en inglés
        $dayOfWeek = $days[$date->format('l')];
        $day = $date->format('d');
        $month = $months[$date->format('F')];
        $year = $date->format('Y');
        $time = $date->format('H:i');

        if(empty($time)){
            return "{$dayOfWeek}, {$day} de {$month} de {$year}";
        }else{
            return "{$dayOfWeek}, {$day} de {$month} de {$year}, {$time}";
        }
    }
}
?>