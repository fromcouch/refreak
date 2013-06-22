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
    
    /**
     * Create table task content
     * 
     * @param array $context Context arrays
     * @param array $tasks Task arrays
     * @param string $theme_url Theme url
     * @param bool $access permisions
     * @return string task rows
     * @access public
     * @static
     */
    public static function table_task_body_fields($context, $tasks, $theme_url, $access, $actual_user_id) {
        
        foreach ($tasks as $tf) {
                
                $tcol = array();
                
                //preparing some data
                $context_letter     = substr($context[$tf->context], 0, 1);
        
                //priority 
                $tcol []= '
                    <td class="task_prio">
                            <span class="task_pr' . $tf->priority . '">' . $tf->priority . '</span>
                    </td>
                ';
                
                //context
                $tcol []= '
                    <td class="task_ctsh">
                            <span class="task_ctx' . $context_letter . '">' . $context_letter . '</span>
                    </td>
                ';
                
                //project name
                $tcol []= '
                    <td>' . $tf->project_name . '</td>
                ';
                
                //title
                $title = $tf->title;
                
                if (!empty($tf->description)) { //icon description
                        $title .= '
                            <img src="' . $theme_url . '/images/desc.png" width="16" height="16" 
                                align="absmiddle" border="0" alt="" />
                        ';
                }
                
                if ($tf->private > 0) { // private icon
                        $title .= '
                            <img src="' . $theme_url . '/images/priv' . $tf->private . '.png" 
                                width="12" height="16" align="absmiddle" border="0" alt="" />
                        ';
                }

                $tcol []= '<td>' . $title . '</td>';

                // first name
                $tcol []= '<td>' . $tf->first_name . '</td>';
                
                //deadline
                $tcol []= '<td>' . RFK_Task_Helper::calculate_deadline($tf->deadline_date, $tf->status_key) . '</td>';
                
                //comments
                $tcol []= '
                    <td>
                        <div class="comment_count">
                            ' . $tf->comment_count . '
                        </div>
                        <a href="#" class="comment_link">
                            <img src="' . $theme_url . '/images/b_disc.png" width="14" height="16" alt="" border="0" />
                        </a>
                    </td>
                ';
                
                //status
                $stats = '';
                for ($cont = 0; $cont < 5; $cont++) { 
                    
                    $sts = ($cont < $tf->status_key) ? (5 - $cont) : 0; 
                    $status_class = 'sts'.$sts;
                    if (RFK_Task_Helper::can_do($tf->task_id, $actual_user_id, $tf->position, $tf->author_id, 3)) {
                        $status_class .= ' status'.$cont;
                    }
                    
                    $stats .= '<td class="' . $status_class .'">&nbsp;</td>';
                    
                }
                $tcol []= $stats;
                
                //buttons
                if ($access || $tf->position > 3) {
                        $buttons = '<a href="#" class="btn_task_edit">
                                            <img src="' . $theme_url . '/images/b_edit.png" width="20" height="16" alt="edit" border="0" />
                                   </a>
                                   <a href="#" class="btn_task_delete">
                                            <img src="' . $theme_url . '/images/b_dele.png" width="20" height="16" alt="del" border="0" />
                                   </a>';
                } else {
                        $buttons = '<img src="' . $theme_url . '/images/b_edin.png" width="20" height="16" alt="del" border="0" />
                                    <img src="' . $theme_url . '/images/b_deln.png" width="20" height="16" alt="del" border="0" />';
                }
                
                $tcol []= '
                    <td class="act"> 
                        ' . $buttons . '
                    </td>
                ';
                
                $trow [] = '
                    <tr data-id="' . $tf->task_id . '">
                        ' . implode('', $tcol) . '
                    </tr>
                ';
                
                unset($tcol);

        }
        
        return implode('', $trow);
                            
    }
    
    /**
     * No task table content
     * 
     * @param string $no_task No task message
     * @param string $url url for images
     * @param bool $access access to new task button
     * @param string $new alternate for new task button image
     * @return string No task table content
     * @access public
     * @static
     */
    public static function table_no_task($no_task, $url, $access, $new) {
     
        $tnotask = '<tr class="nothanks">
                        <td colspan="14">
                            <p>&nbsp;</p>
                            <p align="center">- ' . $no_task . ' -</p>';
                           
        if ($access) {
                   
                $tnotask  = '<p align="center">
                                        <a href="#" class="btn_task_new">
                                            <img src="' . $url . '/images/b_new.png" width="39" height="16" border="0" hspace="3" 
                                                alt="' . $new . '" />
                                        </a>                                            
                                    </p>';
        }
          
        $tnotask = '        <p>&nbsp;</p>
                            <p>&nbsp;</p>
                        </td>
                    </tr>';
        
        return $tnotask;
    }
    
    
}

?>
