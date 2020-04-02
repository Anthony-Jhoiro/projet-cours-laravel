<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class DateController extends Controller
{
    public static $monthFrenchList = [ "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre" ];

    public function getFormatDate($dateToFormat) {
        $date = DateTime ::createFromFormat ( 'Y-m-d H:i:s', $dateToFormat );
        $monthIndex = (int)$dateToFormat -> format ( 'm' ) - 1;
        $month = self::$monthFrenchList[$monthIndex] . " ";
        $day = $date -> format ( "d" ) . " ";
        $yearAndTime = $date -> format ( 'Y à H:i' );
        return $day . $month . $yearAndTime;
    }
}
