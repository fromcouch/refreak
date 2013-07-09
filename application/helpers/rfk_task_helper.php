<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Task Helper
 *
 * @package	Refreak
 * @subpackage	helper
 * @category	task
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class rfk_task_helper {
    
    public static function calculate_deadline($deadline, $status_key) {
        
        $ci                                 =& get_instance();        
        $ret                                = "";
        $ci->lang->load('tasks');
        
        $ci->config->load('refreak', true);
        $sht_date                           = $ci->config->item('rfk_short_date');
        $dd_mode                            = $ci->config->item('rfk_datediff_mode');
        $dd_tomorrow                        = $ci->config->item('rfk_datediff_tomorrow');
        
        $lang_date                          = $ci->lang->line('task_date');
        
        if (preg_match('/(9999|0000)/',$deadline)) 
        {
        	$ret                        = '-';
        } 
        else 
        {
                $dead                       = strtotime($deadline);
                $diff                       = $dead - intval(strtotime(date('Y-m-d',time()))) ;
                if ($diff < 0) 
                {
                        if ($status_key < 5) {
                                $ret        = '<span class="dlate">' . strftime($sht_date, $dead) . '</span>';
                        } else {
                                $ret        = '<span class="ddone">' . strftime($sht_date, $dead) . '</span>';
                        }
                } 
                else if ($diff == 0) 
                {
                        if ($dd_mode === 'date') {
                                $ret        = '<span class="dday">' . strftime($sht_date, $dead) . '</span>';
                        } else {                        
                                $ret        = '<span class="dday">' . $lang_date['today'] . '</span>';
                        }

                } 
                else 
                {
                        $diff = $diff / 3600 / 24;
                        
                        switch ($dd_mode) {
                            case 'day':
                                if ($dd_tomorrow && $diff == 1) 
                                {
                                    $ret    = $lang_date['tomorrow'];
                                } 
                                else if ($diff < 7) 
                                {
                                    $day    = strtolower(date('l',$dead));

                                    if (array_key_exists($day, $lang_date)) 
                                    {
                                       $day = ucfirst($lang_date[$day]);
                                    }

                                    $ret    = '<span class="small">'.ucFirst($day).'</span>';
                                } 
                                else 
                                {
                                    $ret    = '<span class="small">' . strftime($sht_date, $dead) . '</span>';
                                }

                                break;
                            
                            case 'diff':
                                switch($diff) {
                                        case '1':
                                                if ($dd_tomorrow) {
                                                        return $lang_date['tomorrow'];
                                                } else {
                                                        return '1 ' . $lang_date['day'];
                                                }
                                                break;
                                        case '2':
                                        case '3':
                                        case '4':
                                        case '5':
                                        case '6':
                                                return $diff . ' ' . $lang_date['days'];
                                                break;
                                        default:
                                                return '<span class="small">' . strftime($sht_date, $dead) . '</span>';
                                                break;
                                }
                                break;
                            default:
                                return '<span class="small">' . strftime($sht_date, $dead) . '</span>';
                                break;
                        }
                } 
        }
        
        return $ret;
    }
    
    public static function can_do($task_id, $user_id, $position, $author_id, $level = 1) {
        
        $ci =& get_instance();
        $ci->load->model('task_model');
        
        //if ($ci->task_model->get_user_position((int)$task_id, $user_id) >= $level || 
        if ($position >= $level || 
             $ci->ion_auth->in_group(array(1,2)) ||
             $author_id === $user_id)
                return true;
        else 
                return false;
        
    }
}
/* End of file rfk_task_helper.php */
/* Location: ./application/helpers/rfk_task_helper.php */
?>
