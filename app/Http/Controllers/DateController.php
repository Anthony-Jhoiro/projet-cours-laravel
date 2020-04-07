<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

/**
 * Permet de gérer les formatage des dates
 * Class DateController
 * @package App\Http\Controllers
 */
class DateController extends Controller
{
    public static $monthFrenchList = [ "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre" ];

    /**
     * Formate la date reçu en paramètre sous la forme '<jour> <mois> <année> à <heure>:<minutes>
     * Passer par un fonction nous pert d'utiliser les mois en français
     * @param $dateToFormat
     * @return string
     */
    public function getFormatDate($dateToFormat) {
        $date = DateTime ::createFromFormat ( 'Y-m-d H:i:s', $dateToFormat );
        $monthIndex = $date -> format ( 'm' ) - 1;
        $month = self::$monthFrenchList[$monthIndex] . " ";
        $day = $date -> format ( "d" ) . " ";
        $yearAndTime = $date -> format ( 'Y à H:i' );
        return $day . $month . $yearAndTime;
    }
}
