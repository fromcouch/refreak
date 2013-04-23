<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/***
 * @todo calculate timezone for clock
 */

function actual_text_date() {

        $ci =& get_instance();
        $ci->config->load('refreak', true);
        $lng_date = $ci->config->item('rfk_long_date');
        
        $datetime = time() - intval(date('Z')) + 7200;        
        
        $date = strftime($lng_date, $datetime);

        return $date;

}

/* End of file rfk_date_helper.php */
/* Location: ./system/helpers/rfk_date_helper.php */