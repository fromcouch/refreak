<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * General Decorator Helper
 *
 * @package	Refreak
 * @subpackage	helper
 * @category	decorator
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class task_helper {
    
    /**
     * 
     * @param type $content
     * @return string
     */
    public static function table_task_head($content) {
        
        $thead = '<thead>
                    <tr>' 
                        . $content . '
                    </tr>
                  </thead>';
                
        return $thead;
        
    }   
    
    /**
     * 
     * @param type $content
     * @return type
     */
    public static function table_task_head_fields($content) {
        
        $btn_new = '';
        
        if ($this->ion_auth->in_group(array(1,2))) {
        
                $btn_new = '<a href="#" class="btn_task_new">
                                        <img src="' . base_url() . $theme . '/images/b_new.png" 
                                            width="39" height="16" border="0" hspace="3" alt="' . $this->lang->line('task_list_new') . '" />
                                </a>';
        }
        
        $tfields = array(
            '<th width="2%">&nbsp;</th>',
            '<th width="2%">&nbsp;</th>',
            '<th width="15%">' . $this->lang->line('task_list_project') . '</th>',
            '<th width="41%">' . $this->lang->line('task_list_title') . '</th>',
            '<th width="10%">' . $this->lang->line('task_list_user') . '</th>',
            '<th width="10%">' . $this->lang->line('task_list_deadline') . '</th>',
            '<th width="5%">' . $this->lang->line('task_list_comments') . '</th>',
            '<th width="10%" colspan="5">' . $this->lang->line('task_list_status') . '</th>',
            '<th width="5%" class="act">' . $btn_new . '</th>'
        );
        
        
        
        return implode('',$tfields);
        
    }
    
}

?>
