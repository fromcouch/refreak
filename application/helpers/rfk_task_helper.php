<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Description of rfk_task_helper
 *
 * @author victor
 */
class RFK_Task_Helper {
    
    public static function calculate_deadline($deadline, $status_key) {
        
        $ci =& get_instance();        
        $ret = "";
        
        if (preg_match('/(9999|0000)/',$deadline)) 
        {
        	$ret = '-';
        } 
        else 
        {
                $dead = strtotime($deadline);
                $diff = $dead - intval(strtotime(date('Y-m-d',time()))) ;
                if ($diff < 0) 
                {
                        if ($status_key < 5) {
                                $ret = '<span class="dlate">' . strftime('%d %b %y', $dead) . '</span>';
                        } else {
                                $ret = '<span class="ddone">' . strftime('%d %b %y', $dead) . '</span>';
                        }
                } 
                else if ($diff == 0) 
                {
                        $ret = '<span class="dday">'.$ci->lang->line['task_date']['today'].'</span>';

                } 
                else 
                {
                        $diff = $diff / 3600 / 24;

                        if ($diff == 1) 
                        {
                            $ret = $ci->lang->line['task_date']['tomorrow'];
                        } 
                        else if ($diff < 7) 
                        {
                            $day = strtolower(date('l',$dead));
                            
                            if (array_key_exists($day, $ci->lang->line['task_date'])) 
                            {
                               $day = ucfirst($ci->lang->line['task_date'][$day]);
                            }
                            
                            $ret = '<span class="small">'.ucFirst($day).'</span>';
                        } 
                        else 
                        {
                            $ret = '<span class="small">' . strftime('%d %b %y', $dead) . '</span>';
                        }
                } 
        }
        
        return $ret;
    }
    
}
/* End of file rfk_task_helper.php */
/* Location: ./application/helpers/rfk_task_helper.php */
?>
