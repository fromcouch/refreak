<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/***
 * @todo calculate timezone for clock
 */

function actual_text_date() {

        $CI =& get_instance();
        
        setlocale(LC_ALL, $CI->config->item('rfk_locale').'UTF-8', $CI->config->item('rfk_locale'));
        
        $datetime = time() - intval(date('Z')) + 7200;        
        $format = "%A %d %B %Y, %H:%M";
        
        $date = strftime($format, $datetime);

        return $date;

}

/* End of file rfk_date_helper.php */
/* Location: ./system/helpers/rfk_date_helper.php */