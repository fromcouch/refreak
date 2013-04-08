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
        $ci->lang->load('tasks');
        
        $lang_date = $ci->lang->line('task_date');
        
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
                        $ret = '<span class="dday">'.$lang_date['today'].'</span>';

                } 
                else 
                {
                        $diff = $diff / 3600 / 24;

                        if ($diff == 1) 
                        {
                            $ret = $lang_date['tomorrow'];
                        } 
                        else if ($diff < 7) 
                        {
                            $day = strtolower(date('l',$dead));
                            
                            if (array_key_exists($day, $lang_date)) 
                            {
                               $day = ucfirst($lang_date[$day]);
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
    
    public function can_do($task_id, $user_id, $level = 1) {
        
        $ci =& get_instance();
        $ci->load->model('task_model');
        
        if ($ci->task_model->get_user_position((int)$task_id, $user_id) >= $level || 
             $ci->ion_auth->in_group(array(1,2)) ||
             $ci->task_model->is_owner((int)$task_id, (int)$user_id))
                return true;
        else 
                return false;
        
    }
}
/* End of file rfk_task_helper.php */
/* Location: ./application/helpers/rfk_task_helper.php */
?>
