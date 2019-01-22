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

    public static function redirect($page = NULL, $message = NULL, $message_type = NULL)
    {
        if (is_string($page))
        {
            $location = $page;
        } else
        {
            $location = $_SERVER['SCRIPT_NAME'];
        }

        // check for message
        if ($message != NULL)
        {
            $_SESSION['message'] = $message;
        }

        if ($message != NULL)
        {
            $_SESSION['message_type'] = $message_type;
        }

        header('Location: ' . $location);
        exit;
    }

    public static function displayMessage()
    {
        if (!empty($_SESSION['message']))
        {
            $message = $_SESSION['message'];

            if (!empty($_SESSION['message_type']))
            {
                // Assign Message Var
                $message_type = $_SESSION['message_type'];

                // Create output
                if ($message_type == 'error')
                {
                    echo '<div class="alert alert-danger">' . $message . '</div>';
                } else
                {
                    echo '<div class="alert alert-success">' . $message . '</div>';
                }
            }
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
    }

    public static function in_array_r($item , $array)
    {
        return preg_match('/"'.preg_quote($item, '/').'"/i' , json_encode($array));
    }

    public static function get_working_time($time)
    {
        $now = new DateTime();
        $datetime = new DateTime($time);

        // TODO
//        $start_time = new DateTime("08:00:00");
//        $end_time = new DateTime("18:00:00");
//
//        if ($start_time < $datetime)
//        {
//            $datetime = new DateTime("08:00:00");
//        }

        return $datetime->diff($now)->format("%h godz. %i min.");
    }
}