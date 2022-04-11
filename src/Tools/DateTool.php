<?php

namespace System\Tools;

/**
 * Date's convertissor
 */

class DateTool
{
    /**
     * @param string $date
     * @param string $type since | d/m/y | full | day | month | year | :time | time | sql | timestamp | datetime | tomorrow
     * @return string
     */
    public static function dateFormat ($date, $type = null)
    {
        $time = (is_int($date))? $date : strtotime($date);

        switch($type)
        {
            case 'since':
                return self::dateSince($date);
            case 'd/m/y':
                return date('d/m/Y', $time);
            case 'full':
                return date('l d F Y', $time);
            case 'day':
                return date('l', $time);
            case 'month':
                return date('F', $time);
            case 'year':
                return date('Y', $time);
            case ':time':
                return date('H:i:s', $time); 
            case 'time':
                return date('H', $time). 'h' .date('i', $time); 
            case 'sql':
                return date('Y-m-d H:i:s', $time);
            case 'timestamp':
                return strtotime($date);
            case 'datetime':
                return date('Y-m-d', $time). 'T' .date('H:i', $time);
            case 'tomorrow':
                return self::addDay($time, 1);
            default:
                return date('Y-m-d', $time);
        }
    }

    /**
     * Convert dates by temporality of existance
     * @param string $date
     * @return string
     */
    private static function dateSince ($date)
    {
        $now = new \DateTime;
        $ago = new \DateTime($date);
        $diff = $now->diff($ago);
        
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'an',
            'm' => 'mois',
            'w' => 'semaine',
            'd' => 'jour',
            'h' => 'heure',
            'i' => 'minute',
            // 's' => 'seconde'
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 && $k !== 'm' ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (isset($string['y'])) {
            return $string['y'];
        } elseif (isset($string['m'])) {
            return $string['m'];
        } elseif (isset($string['w'])) {
            return $string['w'];
        } elseif (isset($string['d'])) {
            return $string['d'];
        } else {
            return $string ? implode(', ', $string) : 'maintenant';
        }
    }

    /**
     * @param string $date
     * @param int $days
     * @return string
     */
    private static function addDay ($date, $days)
    {
        $add = '+' .$days. ' day';
        return self::dateFormat(strtotime($add, $date));
    }
}