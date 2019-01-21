<?php

class Helpers
{
    public static function isPast($time)
    {
        $today = date("Y-m-d H:i:s");
        $date = $time;

        if ($today > $date)
        {
            $color = 'style="background-color: #FF6347;"';
        } else
        {
            $color = 'style="background-color: #9ACD32;"';
        }
        return $color;
    }
}