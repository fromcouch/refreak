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
     * Decorate table head
     * 
     * @param string $content content to decorate
     * @return string content decorated
     * @static
     * @access public
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
     * Create table head columns
     * 
     * @param string $project header text for project column
     * @param string $title header text for project column
     * @param string $user header text for project column
     * @param string $deadline header text for project column
     * @param string $comments header text for project column
     * @param string $status header text for project column
     * @param string $new header text for project column
     * @param bool $access permission to show new task button
     * @param string $url url for image
     * @return string return columns for task table header
     * @access public
     * @static
     */
    public static function table_task_head_fields($project, $title, $user, $deadline, $comments, $status, $new, $access, $url) {
        
        $btn_new = '';
        
        if ($access) {
        
                $btn_new = '<a href="#" class="btn_task_new">
                                        <img src="' . $url . '/images/b_new.png" 
                                            width="39" height="16" border="0" hspace="3" alt="' . $new . '" />
                                </a>';
        }
        
        $tfields = array(
            '<th width="2%">&nbsp;</th>',
            '<th width="2%">&nbsp;</th>',
            '<th width="15%">' . $project . '</th>',
            '<th width="41%">' . $title . '</th>',
            '<th width="10%">' . $user . '</th>',
            '<th width="10%">' . $deadline . '</th>',
            '<th width="5%">' . $comments . '</th>',
            '<th width="10%" colspan="5">' . $status . '</th>',
            '<th width="5%" class="act">' . $btn_new . '</th>'
        );
        
        
        
        return implode('',$tfields);
        
    }
    
}

?>
