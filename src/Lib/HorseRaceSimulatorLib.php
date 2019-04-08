<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 4/7/19
 * Time: 1:32 PM
 */

namespace App\Lib;


class HorseRaceSimulatorLib
{
    /**
     * credits to: https://www.hashbangcode.com/article/php-function-turn-integer-roman-numerals
     * @param $integer
     * @return string
     */
    static public function integerToRoman($integer)
    {
        // Convert the integer into an integer (just to make sure)
        $integer = intval($integer);
        $result = '';

        // Create a lookup array that contains all of the Roman numerals.
        $lookup = array('M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1);

        foreach($lookup as $roman => $value){
            // Determine the number of matches
            $matches = intval($integer/$value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman,$matches);

            // Set the integer to be the remainder of the integer and the value
            $integer = $integer % $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }

    public static function secondsToTime($seconds) {

        $minutes = floor($seconds/60);
        $seconds = $seconds-($minutes*60);

        $stringSeconds = explode('.',$seconds);
        if( count($stringSeconds)==1 ) {
            $seconds .= '.00';
        }
        $seconds = round($seconds,2);

        if( strlen($stringSeconds[0])==1 ) {
            $seconds = '0'.$seconds;
        }

        return $minutes.':'.$seconds;
    }
}