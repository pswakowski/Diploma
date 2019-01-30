<?php

class Helpers
{
    public static function project_is_past($time)
    {
        $today = new DateTime();
        $date = new DateTime($time);

        $interval = $today->diff($date);

        if ($interval->days < 7)
        {
            $color = 'style="background-color: #f8d7da"';
        } else if ($today > $date)
        {
            $color = 'style="background-color: #e2e3e5;"';
        } else
        {
            $color = 'style="background-color: #d4edda;"';
        }
        return $color;
    }

    public static function task_is_past($time)
    {
        $today = new DateTime();
        $date = new DateTime($time);

        if ($today > $date)
        {
            $color = 'style="background-color: #e2e3e5;"';
        } else
        {
            $color = 'style="background-color: #d4edda;"';
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
        $date_now = new DateTime();
        $date_from_base = new DateTime($time);
        $start_working_day = new DateTime("07:00:00");
        $end_working_day = new DateTime("18:00:00");

        $interval = $date_now->diff($date_from_base);

        if ($interval->days == 0)
        {
            if ($date_now > $end_working_day) {
                return $end_working_day->diff($date_from_base)->format("%d%h godz. %i min.");
            }
            else if ($date_now < $start_working_day)
            {
                $zero_hours = new DateTime("00:00:00");
                return $zero_hours->format("H:i:s");
            }  else
            {
                return $date_from_base->diff($date_now)->format("%h godz. %i min.");
            }
        } else
        {
            $zero_hours = new DateTime("00:00:00");
            return $zero_hours->format("H:i:s");
        }
    }
}