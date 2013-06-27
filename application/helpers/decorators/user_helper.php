<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Decorator Helper
 *
 * @package	Refreak
 * @subpackage	helper
 * @category	decorator
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class user_helper {
    
    /**
     * Decorate table head
     * 
     * @param string $content content to decorate
     * @return string content decorated
     * @static
     * @access public
     */
    public static function table_user_head($content) {
        
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
     * @param string $user User text
     * @param string $level Usel level
     * @param string $lastlogin Last login
     * @param bool $access Permissions
     * @param string $create_url Url fer create user
     * @param string $url_theme Theme url
     * @param string $new New user text
     * @return string return columns for user table header
     * @access public
     * @static
     */    
    public static function table_user_head_fields($user, $level, $lastlogin, $access, $create_url, $url_theme, $new) {
        
        $btn_new = '';
        
        if ($access) {
        
                $btn_new = '<a href="' . $create_url . '" class="btn_task_new">
                                        <img src="' . $url_theme . '/images/new.png" 
                                            width="39" height="16" border="0" hspace="3" alt="' . $new . '" />
                                </a>';
        }
        else {
                $btn_new = $action;
        }
        
        $tfields = array(
            '<th width="25%">' . $user . '</th>',
            '<th width="10%">' . $level . '</th>',
            '<th width="20%">' . $lastlogin . '</th>',            
            '<th width="10%" style="text-align:center">' . $btn_new . '</th>'
        );              
                
        return implode('',$tfields);
        
    }
    
    /**
     * Create user table content
     * 
     * @param type $users
     * @param type $access
     * @param type $theme_url
     * @param type $detail_url
     * @param type $delete_url
     * @param type $edit_url
     * @param type $actual_user_id
     * @param type $confirmdelete
     * @return string task rows
     * @access public
     * @static
     */
    /**
     * 

     * @return type
     */
    public static function table_user_body_fields($users, $access, $theme_url, $detail_url, $delete_url, $edit_url, $actual_user_id, $confirmdelete) {
        
        foreach ($users as $table_user) {
                $user_status    = $table_user->active ? 'ena' : 'dis';
                $user_status   .= ($actual_user_id != $table_user->id && $access) ? 'y' : 'n';
                $url_active     = $table_user->active ? 'deactivate' : 'activate';
                $tr_class       = $table_user->active ? '' : 'class = "disabled"';
            
                $tcol = array();
                
                //name
                $tcol['name'] = '
                        <td>
                            <a href="' . $detail_url . $table_user->id . '">' . $table_user->first_name.' '.$table_user->last_name . '</a>
                        </td>
                ';
                
                //group
                $tcol['group'] = '
                        <td>
                            ' . $table_user->group_desc . '
                        </td>
                ';
                
                //last_login
                $tcol['last_login'] = '
                        <td>
                            ' . date('D d/m/Y G:i', $table_user->last_login) . '
                        </td>
                ';
                
                //buttons
                if ($actual_user_id != $table_user->id && $access) {
                        $btn_active = '
                            <a href="' . site_url() . 'users/' . $url_active . '/' . $table_user->id . '">
                                <img src="' . $theme_url. '/images/b_' . $user_status . '.png" />
                            </a>
                        ';
                        
                        $btn_delete = '
                            <a href="' . $delete_url . $table_user->id .'" onclick="return confirm(\'' . $confirmdelete . '\');">
                                <img src="' . $theme_url. '/images/b_dele.png" width="20" height="16" border="0" />
                            </a>
                        ';
                }
                else {
                        $btn_active = '
                            <img src="' . $theme_url. '/images/b_' . $user_status . '.png" />
                        ';
                        
                        $btn_delete = '
                            <img src="' . $theme_url. '/images/b_deln.png" width="20" height="16" border="0" />
                        ';
                }
                
                if ($actual_user_id == $table_user->id || $access) {
                    
                        $btn_edit = '
                            <a href="' . $edit_url . $table_user->id . '">
                                <img src="' . $theme_url. '/images/b_edit.png" width="20" height="16" border="0" />
                            </a>
                        ';
                
                }
                else {
                       $btn_edit = '
                           <img src="' . $theme_url. '/images/b_edin.png" width="20" height="16" border="0" />
                       ';
                }
                
                $tcol['buttons'] = '
                        <td align="center">
                            ' . $btn_active . $btn_edit . $btn_delete . '
                        </td>
                ';
                
                $trow []= '
                    <tr ' . $tr_class . '>
                        ' . implode('', $tcol) . '
                    </tr>
                '; 
                
                unset($tcol);
            }        
        
        return implode('', $trow);
                            
    }
//    
//    /**
//     * No task table content
//     * 
//     * @param string $no_task No task message
//     * @param string $url url for images
//     * @param bool $access access to new task button
//     * @param string $new alternate for new task button image
//     * @return string No task table content
//     * @access public
//     * @static
//     */
//    public static function table_no_task($no_task, $url, $access, $new) {
//     
//        $tnotask = '<tr class="nothanks">
//                        <td colspan="14">
//                            <p>&nbsp;</p>
//                            <p align="center">- ' . $no_task . ' -</p>';
//                           
//        if ($access) {
//                   
//                $tnotask  = '<p align="center">
//                                        <a href="#" class="btn_task_new">
//                                            <img src="' . $url . '/images/b_new.png" width="39" height="16" border="0" hspace="3" 
//                                                alt="' . $new . '" />
//                                        </a>                                            
//                                    </p>';
//        }
//          
//        $tnotask = '        <p>&nbsp;</p>
//                            <p>&nbsp;</p>
//                        </td>
//                    </tr>';
//        
//        return $tnotask;
//    }
//    
// 
//    /**
//     * Render close, edit, delete buttons
//     * 
//     * @param string $close Close text
//     * @param string $edit Edit text
//     * @param string $delete Delete text
//     * @param integer $position User task position
//     * @param string $url_theme Theme Url
//     * @return string Buttons rendered
//     * @access public
//     * @static
//     */
//    public static function show_buttons($close, $edit, $delete, $position, $url_theme) {
//        
//        $buttons = '    
//                <div class="task_show_menu">
//                   <div class="task_show_close">
//                       <a href="#">
//                           ' . $close . ' 
//                           <img src="' . $url_theme . '/images/b_disn.png" width="20" height="16" border="0" alt="close" />
//                       </a>
//                   </div> ';
//        
//        if ($position > 3) {
//            
//                $buttons .= ' <div class="task_show_edit">
//                                    <a href="#">' . $edit . '
//                                        <img src="' . $url_theme . '/images/b_edin.png" width="20" height="16" border="0" alt="edit" />
//                                    </a>
//                                </div>
//                                <div class="task_show_delete">
//                                    <a href="#">
//                                        ' . $delete . '
//                                        <img src="' . $url_theme . '/images/b_deln.png" width="20" height="16" border="0" alt="delete" />
//                                    </a>
//                                </div>';
//
//        }
//                  
//        $buttons .= '</div>';
//        
//        return $buttons;
//        
//    }
//    
//    /**
//     * Render show task upper part
//     * 
//     * @param array $tf
//     * @param string $priority_text
//     * @param string $deadline_text
//     * @param string $context_text
//     * @param char $context_letter
//     * @param array $context
//     * @param string $project_text
//     * @param string $project_name
//     * @param string $title_text
//     * @param string $user_text
//     * @param string $username
//     * @param string $visibility
//     * @param array $vis_array
//     * @param string $url_theme
//     * @return string popup upper part
//     * @access public
//     * @static
//     */
//    public static function show_task_info($tf, $priority_text, $deadline_text, $context_text, $context_letter, $context, $project_text, $project_name, $title_text, $user_text, $username, $visibility, $vis_array, $url_theme) {
//        
//        $parts = array();
//    
//        $parts['priority'] = '
//                        <div class="task_show_priority">
//                            <div class="label">' . $priority_text . '</div>
//                            <div class="vprio">
//                                <span class="task_pr' . $tf['priority'] . '">' . $tf['priority'] . '</span>
//                            </div>
//                        </div>
//        ';
//        
//        $parts['content'] = '
//                        <div class="task_show_content">
//                            <div class="label">' . $deadline_text .'</div>
//                            <div id="vdead">' . RFK_Task_Helper::calculate_deadline($tf['deadline_date'], $tf['status']) . '</div>
//                        </div>
//        ';
//        
//        $parts['context'] = '
//                        <div class="task_show_content">
//                            <div class="label">' . $context_text . '</div>
//                            <div class="task_ctx' . $context_letter . '">
//                                ' . $context[$tf['context']] . '
//                            </div>
//                        </div>
//        ';
//        
//        $parts['project'] = '
//                        <div class="task_show_project">
//                            <div class="label">' . $project_text . '</div>
//                            <div class="vproj">' . $project_name . '</div>
//                        </div> 
//        ';
//        
//        $parts['title'] = '
//                        <div class="task_show_title">
//                            <div class="label">' . $title_text . '</div>
//                            <div class="vtitl">' . $tf['title'] . '</div>
//                        </div>
//        ';
//        
//        $parts['user'] = '
//                        <div class="task_show_user">
//                            <div class="label">' . $user_text . '</div>
//                            <div class="vuser">' . $username . '</div>
//                        </div>            
//        ';
//        
//        $parts['visibility'] = '
//                        <div class="task_show_visibility">
//                            <div class="label">' . $visibility . '</div>
//                            <div class="vvisi">
//                                    ' . $vis_array[$tf['private']];
//        
//        if ($tf['private'] > 0) {
//                        $parts['visibility'] .= '
//                            <img src="' . $url_theme . '/images/priv' . $tf['private'] . '.png" width="12" height="16" align="absmiddle" border="0" alt="" />
//                        ';
//        }
//                                            
//        $parts['visibility'] .= '                  
//                            </div>
//                        </div>    
//        ';
//        
//        return implode('', $parts);
//        
//    }
//    
//    
//    /**
//     * Render tabs in show task
//     * 
//     * @param string $description_text
//     * @param string $comment_text
//     * @param string $history_text
//     * @param string $save_text
//     * @param string $cancel_text
//     * @param string $description
//     * @return string tabs rendered in HTML
//     * @access public
//     * @static
//     */
//    public static function show_tabs($description_text, $comment_text, $history_text, $save_text, $cancel_text, $description ) {
//        
//    
//        $tabs['menu'] = '
//                        <div class="tabmenu">
//                            <ul>
//                                <li class="tab tab_desc active"><a href="#">' . $description_text . '</a></li>
//                                <li class="tab tab_comm"><a href="#">' . $comment_text . '</a></li>
//                                <li class="tab tab_hist"><a href="#">' . $history_text . '</a></li>
//                            </ul>
//                        </div>    
//        ';
//        
//        
//        $tabs['content'] = '
//                        <div class="tabcontent">
//                                <div class="tabcontent_content">
//                                    <div class="tabcontent_edit">
//                                            <div>
//                                                    <input class="veditid" type="hidden" name="veditid" value="0" />
//                                                    <textarea class="veditbody" name="veditbody"></textarea>
//                                            </div>
//                                            <div>
//                                                    <input type="button" name="veditsubmit" class="veditsubmit" value="' . $save_text . '"> &nbsp;
//                                                    <input type="button" name="veditcancel" class="veditcancel" value="' . $cancel_text . '">
//                                            </div>
//                                    </div>
//                                    <div class="vmore tab_description_content">' . $description . '</div>
//                                    <div class="vmore tab_comments_content"></div>
//                                    <div class="vmore tab_history_content"></div>
//                                </div>
//                        </div>    
//        ';
//        
//        return implode('', $tabs);
//    }
//    
//    /**
//     * Render status part
//     * 
//     * @param string $status_text Status text
//     * @param string $status status
//     * @return string rendered status part
//     * @static
//     * @access public
//     */
//    public static function show_status($status_text, $status) {
//        
//        $stat = '
//                        <div class="task_show_status">
//                            <div class="label2">' . $status_text . '</div>
//                            <div class="task_show_status_inside">
//                                  ' . $status . '
//                            </div>
//                        </div>
//        ';
//
//        return $stat;
//    }
//    
//    /**
//     * Edit priority and context
//     * 
//     * @param string $edit_priority_text Text for priority
//     * @param array $priority_list priority list of items
//     * @param integer $priority task priority
//     * @param string $edit_context_text Text for context
//     * @param array $context_list context list of items
//     * @param string $context context text
//     * @param string $deadline_text deadline text
//     * @param date $deadline_date deadline date
//     * @return string html for edit priority and context
//     * @static
//     * @access public
//     */
//    public static function edit_priority_dead($edit_priority_text, $priority_list, $priority, $edit_context_text, $context_list, $context, $deadline_text, $deadline_date) {
//        
//        $tr = array();
//        $tr ['priority_context']= '
//                <tr>
//                        <th>' . $edit_priority_text . ':</th>
//                        <td>' . form_dropdown('task_priority', $priority_list, $priority, 'class="task_priority"') . '</td>
//                        <th style="text-align:right">' . $edit_context_text . ':</td>
//                        <td>' . form_dropdown('task_context', $context_list, $context, 'class="task_context"') . '</td>
//                </tr>
//        ';
//        
//        $tr ['deadline']= '
//                <tr>
//                        <th>' . $deadline_text . ':</th>
//                        <td colspan="3">
//                            ' . form_input('deadline',$deadline_date, 'class="task_dead"') . '
//                        </td>
//                </tr>
//        ';
//        
//        return implode('', $tr);
//    }
//    
//    /**
//     * Render project selector
//     * 
//     * @param string $edit_project_text Project text
//     * @param array $user_projects User project list
//     * @param integer $project_id selected project
//     * @param string $edit_new_text New project text
//     * @param string $edit_list_text list project text
//     * @return string project part rendered
//     * @static
//     * @access public
//     */
//    public static function edit_project($edit_project_text, $user_projects, $project_id, $edit_new_text, $edit_list_text) {
//        
//        $tr = '
//                <tr>
//                        <th>' . $edit_project_text . ':</th>
//                        <td colspan="3">
//                            <span class="project_sel">
//                                ' .  form_dropdown('task_projects', $user_projects, $project_id, 'class="task_projects"') . '                               				                                
//                                <a href="#" class="small task_edit_new_project">&gt; ' . $edit_new_text . '</a>
//                            </span>
//                            <span class="project_txt">
//                                ' . form_input('task_project_name', '', 'class = "task_edit_project_new_name"') . '
//                                <a href="#" class="small task_edit_list_project">&lt; ' . $edit_list_text . '</a>
//                            </span>
//                        </td>
//                </tr>
//        ';
//                
//        return $tr;        
//    }
//    
//    /**
//     * Title and Description part
//     * 
//     * @param string $edit_title_text Title text
//     * @param string $title task title
//     * @param string $edit_description_text description text
//     * @param string $description task description
//     * @return string input and textarea  rendered
//     * @access public
//     * @static
//     */
//    public static function edit_title_desc($edit_title_text, $title, $edit_description_text, $description) {
//        
//        $tr = '
//                <tr>
//                        <th>' . $edit_title_text . ':</th>
//                        <td colspan="3">
//                            ' . form_input('task_title', $title, 'class="task_full task_edit_title"') . '
//                        </td>
//                </tr>
//                <tr valign="top">
//                        <th>' . $edit_description_text . ':</th>
//                        <td colspan="3">
//                            ' . form_textarea('task_description', $description, 'class="task_full"') . '
//                        </td>
//                </tr>        
//        ';
//        
//        return $tr;
//    }
//    
//    
//    public static function edit_user_status($edit_user_text, $actual_user_id, $private, $edit_public_text, $edit_internal_text, $edit_private_text, $edit_status_text, $status_list, $status) {
//        
//        $tr = array();
//        
//        $tr []= '
//                <tr>
//                        <th>' . $edit_user_text . ':</th>
//                        <td colspan="3">
//                                ' . form_dropdown_users('task_users','-',$actual_user_id,'task_users') . '
//                                <span>
//                                    ' . form_radio('showPrivate', '0', (int)$private === 0 ? true : false) . '
//                                    <label>' . $edit_public_text . '</label>
//                                </span>
//                                <span>
//                                    ' . form_radio('showPrivate', '1', (int)$private === 1 ? true : false) . '
//                                    <label>' . $edit_internal_text . '</label>
//                                </span>
//                                <span>
//                                    ' . form_radio('showPrivate', '2', (int)$private === 2 ? true : false) . '
//                                    <label>' . $edit_private_text . '</label>
//                                </span>
//                        </td>
//                </tr>
//        ';
//        
//        $tr []= '
//                <tr>
//                        <th>' . $edit_status_text . ':</th>
//                        <td colspan="3">
//                            ' . form_dropdown('task_status', $status_list, $status,'class="task_status"') . '
//                        </td>
//                </tr>
//        ';
//        
//        return implode('', $tr);
//        
//    }
            
}

?>
