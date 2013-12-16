<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Task Decorator Helper
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
     * @param string $title header text for title column
     * @param string $user header text for useR column
     * @param string $deadline header text for deadline column
     * @param string $comments header text for comments column
     * @param string $status header text for status column
     * @param string $new alternate text for new button image
     * @param bool $access permission to show new task button
     * @param string $url url for image
     * @param int $max_status max status number
     * @return string return columns for task table header
     * @access public
     * @static
     */
    public static function table_task_head_fields($project, $title, $user, $deadline, $comments, $status, $new, $access, $url, $max_status) {
        
        $btn_new = '';
        
        if ($access) {
        
                $btn_new = '<a href="#" class="btn_task_new">
                                        <img src="' . $url . '/images/b_new.png" 
                                            width="39" height="16" border="0" hspace="3" alt="' . $new . '" />
                                </a>';
        }
        
        if ($max_status === 1) {
            $status = 'X';
        }
        
        $tfields = array(
            '<th width="2%">&nbsp;</th>',
            '<th width="2%">&nbsp;</th>',
            '<th width="15%">' . $project . '</th>',
            '<th width="41%">' . $title . '</th>',
            '<th width="10%">' . $user . '</th>',
            '<th width="10%">' . $deadline . '</th>',
            '<th width="5%">' . $comments . '</th>',
            '<th width="' . $max_status * 2 . '%" colspan="' . $max_status . '">' . $status . '</th>',
            '<th width="5%" class="act">' . $btn_new . '</th>'
        );
        
        $tfields = rfk_plugin_helper::trigger_event('tasks_view_list_head_table', $tfields);
        
        return implode('',$tfields);
        
    }
    
    /**
     * Create table task content
     * 
     * @param array $context Context arrays
     * @param array $tasks Task arrays
     * @param string $theme_url Theme url
     * @param bool $access permisions
     * @param int $actual_user_id user id
     * @param int $max_status max possible status
     * @param array $subtasks subtasks
     * @param bool $rendering_subtasks if true are rendering subtasks, supressing context and priority
     * @return string task rows
     * @access public
     * @static
     */
    public static function table_task_body_fields($context, $tasks, $theme_url, $access, $actual_user_id, $max_status, $subtasks = array(), $rendering_subtask = FALSE) {
        
        foreach ($tasks as $tf) {
                
                $tcol = array();
                
                //preparing some data
                $context_letter     = substr($context[$tf->context], 0, 1);
        
				if ($rendering_subtask) {
					$tcol ['priority']= '
						<td class="task_prio" colspan="2"> &nbsp; </td>
					';
					
					//we add also empty context
					$tcol ['context']= '';
				}
				else {
					//priority 
					$tcol ['priority']= '
						<td class="task_prio">
								<span class="task_pr' . $tf->priority . '">' . $tf->priority . '</span>
						</td>
					';

					//context
					$tcol ['context']= '
						<td class="task_ctsh">
								<span class="task_ctx' . $context_letter . '">' . $context_letter . '</span>
						</td>
					';
				}
                //project name
                $tcol ['project']= '
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

                $tcol ['title']= '<td>' . $title . '</td>';

                // first name
                $uname = $tf->user_id > 0 ? $tf->first_name : '-';
                $tcol ['first_name']= '<td>' . $uname . '</td>';
                
                //deadline
                $tcol ['deadline']= '<td>' . rfk_task_helper::calculate_deadline($tf->deadline_date, $tf->status_key) . '</td>';
                
                //comments
                $tcol ['comments']= '
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
                for ($cont = 0; $cont < $max_status; $cont++) { 
                    
                    $sts = ($cont < $tf->status_key) ? (5 - $cont) : 0; 
                    $status_class = 'sts'.$sts;
                    if (rfk_task_helper::can_do($tf->task_id, $actual_user_id, $tf->position, $tf->author_id, 4)) {
                        $status_class .= ' status'.$cont;
                    }
                    
                    $stats .= '<td class="' . $status_class .'">&nbsp;</td>';
                    
                }
                $tcol ['status']= $stats;
                
                //buttons
                if ($access ||  (int)$tf->position > 3) {
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
                
                $tcol ['buttons']= '
                    <td class="act"> 
                        ' . $buttons . '
                    </td>
                ';
                
                $tcol = rfk_plugin_helper::trigger_event('tasks_view_list_content_table_column', $tcol);
                
                $trow [] = '
                    <tr data-id="' . $tf->task_id . '">
                        ' . implode('', $tcol) . '
                    </tr>
                ';
                
				if (count($subtasks) > 0) {
					
					$subs		= rfk_task_helper::get_subtasks($subtasks, $tf->task_id);
					
					if (count($subs) > 0)
						$trow []	= self::table_task_body_fields($context, $subs, $theme_url, $access, $actual_user_id, $max_status,array(),TRUE);
				}
				
                unset($tcol);

        }
        
        $trow = rfk_plugin_helper::trigger_event('tasks_view_list_content_table_row', $trow);
        
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
                   
                $tnotask  .= '<p align="center">
                                        <a href="#" class="btn_task_new">
                                            <img src="' . $url . '/images/b_new.png" width="39" height="16" border="0" hspace="3" 
                                                alt="' . $new . '" />
                                        </a>                                            
                                    </p>';
        }
          
        $tnotask .= '        <p>&nbsp;</p>
                            <p>&nbsp;</p>
                        </td>
                    </tr>';
        
        $tnotask = rfk_plugin_helper::trigger_event('tasks_view_table_no_tasks', $tnotask);
        
        return $tnotask;
    }
    
 
    /**
     * Render close, edit, delete buttons
     * 
     * @param string $close Close text
     * @param string $edit Edit text
     * @param string $delete Delete text
     * @param integer $position User task position
     * @param string $url_theme Theme Url
	 * @param bool $access 
     * @param string $parent Parent Text
     * @param bool $parent_active Parent actived or not
     * @param string $subtasks Subtasks text
     * @param bool $subtasks_active Subtasks actived or not
     * @return string Buttons rendered
     * @access public
     * @static
     */
    public static function show_buttons($close, $edit, $delete, $position, $url_theme, $access, $parent, $parent_active, $subtasks, $subtasks_active) {
        
        $buttons = '    
                <div class="task_show_menu">
                   <div class="task_show_close">
                       <a href="#">
                           ' . $close . ' 
                           <img src="' . $url_theme . '/images/b_disn.png" width="20" height="16" border="0" alt="close" />
                       </a>
                   </div> ';
        
        if ($position > 3 || $access) {
            
                $buttons .= ' <div class="task_show_edit">
                                    <a href="#">' . $edit . '
                                        <img src="' . $url_theme . '/images/b_edin.png" width="20" height="16" border="0" alt="edit" />
                                    </a>
                                </div>
                                <div class="task_show_delete">
                                    <a href="#">
                                        ' . $delete . '
                                        <img src="' . $url_theme . '/images/b_deln.png" width="20" height="16" border="0" alt="delete" />
                                    </a>
                                </div>';

        }
        
		$buttons .= '<div class="task_show_subtasks">
						<a href="#" class="task_show_parent_' . $parent_active . '">' . $parent . ' </a>
						<a href="#" class="task_show_subtasks_' . $subtasks_active . '">' . $subtasks . ' </a>
                        <a href="#" class="task_show_new>
							<img src="' . $url_theme . '/images/b_new.png" width="39" height="16" border="0" alt="new" />
						</a>                
					</div>';
		
        $buttons .= '</div>';
        
		
        $buttons = rfk_plugin_helper::trigger_event('tasks_view_show_task_buttons', $buttons);
        
        return $buttons;
        
    }
    
    /**
     * Render show task upper part
     * 
     * @param array $tf
     * @param string $priority_text
     * @param string $deadline_text
     * @param string $context_text
     * @param char $context_letter
     * @param array $context
     * @param string $project_text
     * @param string $project_name
     * @param string $title_text
     * @param string $user_text
     * @param string $username
     * @param string $visibility
     * @param array $vis_array
     * @param string $url_theme
     * @return string popup upper part
     * @access public
     * @static
     */
    public static function show_task_info($tf, $priority_text, $deadline_text, $context_text, $context_letter, $context, $project_text, $project_name, $title_text, $user_text, $username, $visibility, $vis_array, $url_theme) {
        
        $parts = array();
    
        $parts['priority'] = '
                        <div class="task_show_priority">
                            <div class="label">' . $priority_text . '</div>
                            <div class="vprio">
                                <span class="task_pr' . $tf['priority'] . '">' . $tf['priority'] . '</span>
                            </div>
                        </div>
        ';
        
        $parts['content'] = '
                        <div class="task_show_content">
                            <div class="label">' . $deadline_text .'</div>
                            <div id="vdead">' . rfk_task_helper::calculate_deadline($tf['deadline_date'], $tf['status']) . '</div>
                        </div>
        ';
        
        $parts['context'] = '
                        <div class="task_show_content">
                            <div class="label">' . $context_text . '</div>
                            <div class="task_ctx' . $context_letter . '">
                                ' . $context[$tf['context']] . '
                            </div>
                        </div>
        ';
        
        $parts['project'] = '
                        <div class="task_show_project">
                            <div class="label">' . $project_text . '</div>
                            <div class="vproj">' . $project_name . '</div>
                        </div> 
        ';

        $parts['title'] = '
                        <div class="task_show_title">
                            <div class="label">' . $title_text . '</div>
                            <div class="vtitl">' . $tf['title'] . '</div>
                        </div>
        ';
        
        $parts['user'] = '
                        <div class="task_show_user">
                            <div class="label">' . $user_text . '</div>
                            <div class="vuser">' . $username . '</div>
                        </div>            
        ';
        
        $parts['visibility'] = '
                        <div class="task_show_visibility">
                            <div class="label">' . $visibility . '</div>
                            <div class="vvisi">
                                    ' . $vis_array[$tf['private']];
        
        if ($tf['private'] > 0) {
                        $parts['visibility'] .= '
                            <img src="' . $url_theme . '/images/priv' . $tf['private'] . '.png" width="12" height="16" align="absmiddle" border="0" alt="" />
                        ';
        }
                                            
        $parts['visibility'] .= '                  
                            </div>
                        </div>    
        ';
        
        $parts = rfk_plugin_helper::trigger_event('tasks_view_show_task_info', $parts);
        
        return implode('', $parts);
        
    }
    
    
    /**
     * Render tabs in show task
     * 
     * @param string $description_text
     * @param string $comment_text
     * @param string $history_text
     * @param string $save_text
     * @param string $cancel_text
     * @param string $description
     * @return string tabs rendered in HTML
     * @access public
     * @static
     */
    public static function show_tabs($description_text, $comment_text, $history_text, $save_text, $cancel_text, $description ) {
        
    
        $tabs['menu'] = '
                        <div class="tabmenu">
                            <ul>
                                <li class="tab tab_desc active"><a href="#">' . $description_text . '</a></li>
                                <li class="tab tab_comm"><a href="#">' . $comment_text . '</a></li>
                                <li class="tab tab_hist"><a href="#">' . $history_text . '</a></li>
                            </ul>
                        </div>    
        ';
        
        
        $tabs['content'] = '
                        <div class="tabcontent">
                                <div class="tabcontent_content">
                                    <div class="tabcontent_edit">
                                            <div>
                                                    <input class="veditid" type="hidden" name="veditid" value="0" />
                                                    <textarea class="veditbody" name="veditbody"></textarea>
                                            </div>
                                            <div>
                                                    <input type="button" name="veditsubmit" class="veditsubmit" value="' . $save_text . '"> &nbsp;
                                                    <input type="button" name="veditcancel" class="veditcancel" value="' . $cancel_text . '">
                                            </div>
                                    </div>
                                    <div class="vmore tab_description_content">' . nl2br($description, TRUE) . '</div>
                                    <div class="vmore tab_comments_content"></div>
                                    <div class="vmore tab_history_content"></div>
                                </div>
                        </div>    
        ';
        
        $tabs = rfk_plugin_helper::trigger_event('tasks_view_show_task_tabs', $tabs);
        
        return implode('', $tabs);
    }
    
    /**
     * Render status part
     * 
     * @param string $status_text Status text
     * @param string $status status
     * @return string rendered status part
     * @static
     * @access public
     */
    public static function show_status($status_text, $status) {
        
        $stat = '
                        <div class="task_show_status">
                            <div class="label2">' . $status_text . '</div>
                            <div class="task_show_status_inside">
                                  ' . $status . '
                            </div>
                        </div>
        ';

        $stat = rfk_plugin_helper::trigger_event('tasks_view_show_task_status', $stat);
        
        return $stat;
    }
    
    /**
     * Edit priority and context
     * 
     * @param string $edit_priority_text Text for priority
     * @param array $priority_list priority list of items
     * @param integer $priority task priority
     * @param string $edit_context_text Text for context
     * @param array $context_list context list of items
     * @param string $context context text
     * @param string $deadline_text deadline text
     * @param date $deadline_date deadline date
     * @return string html for edit priority and context
     * @static
     * @access public
     */
    public static function edit_priority_dead($edit_priority_text, $priority_list, $priority, $edit_context_text, $context_list, $context, $deadline_text, $deadline_date) {
        
        $tr = array();
        $tr ['priority_context']= '
                <tr>
                        <th>' . $edit_priority_text . ':</th>
                        <td>' . form_dropdown('task_priority', $priority_list, $priority, 'class="task_priority"') . '</td>
                        <th style="text-align:right">' . $edit_context_text . ':</td>
                        <td>' . form_dropdown('task_context', $context_list, $context, 'class="task_context"') . '</td>
                </tr>
        ';
        
        $tr ['deadline']= '
                <tr>
                        <th>' . $deadline_text . ':</th>
                        <td colspan="3">
                            ' . form_input('deadline',$deadline_date, 'class="task_dead"') . '
                        </td>
                </tr>
        ';
        
        $tr = rfk_plugin_helper::trigger_event('tasks_view_edit_task_pr_dead', $tr);
        
        return implode('', $tr);
    }
    
    /**
     * Render project selector
     * 
     * @param string $edit_project_text Project text
     * @param array $user_projects User project list
     * @param integer $project_id selected project
     * @param string $edit_new_text New project text
     * @param string $edit_list_text list project text
     * @return string project part rendered
     * @static
     * @access public
     */
    public static function edit_project($edit_project_text, $user_projects, $project_id, $edit_new_text, $edit_list_text) {
        
        $tr = '
                <tr>
                        <th>' . $edit_project_text . ':</th>
                        <td colspan="3">
                            <span class="project_sel">
                                ' .  form_dropdown('task_projects', $user_projects, $project_id, 'class="task_projects"') . '                               				                                
                                <a href="#" class="small task_edit_new_project">&gt; ' . $edit_new_text . '</a>
                            </span>
                            <span class="project_txt">
                                ' . form_input('task_project_name', '', 'class = "task_edit_project_new_name"') . '
                                <a href="#" class="small task_edit_list_project">&lt; ' . $edit_list_text . '</a>
                            </span>
                        </td>
                </tr>
        ';
                
        $tr = rfk_plugin_helper::trigger_event('tasks_view_edit_task_project', $tr);
        
        return $tr;        
    }
    
    /**
     * Title and Description part
     * 
     * @param string $edit_title_text Title text
     * @param string $title task title
     * @param string $edit_description_text description text
     * @param string $description task description
     * @return string input and textarea  rendered
     * @access public
     * @static
     */
    public static function edit_title_desc($edit_title_text, $title, $edit_description_text, $description) {
        
        $tr = '
                <tr>
                        <th>' . $edit_title_text . ':</th>
                        <td colspan="3">
                            ' . form_input('task_title', $title, 'class="task_full task_edit_title"') . '
                        </td>
                </tr>
                <tr valign="top">
                        <th>' . $edit_description_text . ':</th>
                        <td colspan="3">
                            ' . form_textarea('task_description', $description, 'class="task_full"') . '
                        </td>
                </tr>        
        ';
        
        $tr = rfk_plugin_helper::trigger_event('tasks_view_edit_title_description', $tr);
        
        return $tr;
    }
    
    /**
     * 
     * @param string $edit_user_text
     * @param string $user_id
     * @param string $private
     * @param string $edit_public_text
     * @param string $edit_internal_text
     * @param string $edit_private_text
     * @param string $edit_status_text
     * @param array $status_list
     * @param string $status
     * @param type $max_status
     * @return string 
     * @static
     * @access public
     */
    public static function edit_user_status($edit_user_text, $user_id, $private, $edit_public_text, $edit_internal_text, $edit_private_text, $edit_status_text, $status_list, $status, $max_status) {
        
        $tr = array();
        
        $tr []= '
                <tr>
                        <th>' . $edit_user_text . ':</th>
                        <td colspan="3">
                                ' . form_dropdown_users('task_users','-',$user_id,'task_users') . '
                                <span>
                                    ' . form_radio('showPrivate', '0', (int)$private === 0 ? true : false) . '
                                    <label>' . $edit_public_text . '</label>
                                </span>
                                <span>
                                    ' . form_radio('showPrivate', '1', (int)$private === 1 ? true : false) . '
                                    <label>' . $edit_internal_text . '</label>
                                </span>
                                <span>
                                    ' . form_radio('showPrivate', '2', (int)$private === 2 ? true : false) . '
                                    <label>' . $edit_private_text . '</label>
                                </span>
                        </td>
                </tr>
        ';
        
        if ($max_status < 5) {
            for($x=$max_status + 1; $x<=5;$x++) {
                unset($status_list[$x]);
            }
        }
        
        $tr []= '
                <tr>
                        <th>' . $edit_status_text . ':</th>
                        <td colspan="3">
                            ' . form_dropdown('task_status', $status_list, $status,'class="task_status"') . '
                        </td>
                </tr>
        ';
        
        $tr = rfk_plugin_helper::trigger_event('tasks_view_edit_user_status', $tr);
        
        return implode('', $tr);
        
    }
     
    /**
     * 
     * @param array $tasks Task arrays
     * @param string $project_text text for project
     * @param string $priority_text text for priority
     * @param string $user_text text for user
     * @param string $deadline_text text for deadline
     * @param string $status_text text for status
     * @param array $status status text array
     * @return string html for print
     * @access public
     * @static
     */
    public static function table_print($tasks, $project_text, $priority_text, $user_text, $deadline_text, $status_text, $status) {
	    
	    $part	= array();
	    
	    foreach ($tasks as $tf) {
                
			$tcol			= array();
			
			$tcol['begin_box']		= '
				<div class="printbox">
			';
			
			$tcol['title']		= '
				<h2>' . $tf->title . '</h2>
			';
			
			$tcol['begin_table']	= '
				<table cellpadding="1" cellspacing="0" border="0" width="100%">
			';
			
			$tcol['project']	= '
				<tr>
				    <td colspan="4"> ' .
					$project_text . ': 
					<strong>' . $tf->project_name . '</strong></td>
				</tr>
			';
			
			$tcol['info']		= '
				<tr>
					<td width="15%">' . 
						$priority_text .': <strong>' . $tf->priority .'</strong>
					</td>
					<td width="35%">' .
						$user_text . ': <strong>' . $tf->first_name . ' ' . $tf->last_name . '</strong>
					</td>
					<td width="35%">' .
						$deadline_text . ': <strong>' . rfk_task_helper::calculate_deadline($tf->deadline_date, $tf->status_key) .'</strong>
					</td>
					<td width="15%">' .
						$status_text . ': <strong>' . $status[$tf->status_key] . '</strong>
					</td>
				</tr>
			';
			
			$tcol['end_table']	= '
				</table>
			';
			
			$tcol['description']	= '
				<div class="printdescription">' . $tf->description . '</div>
			';
			
			$tcol['end_box']		= '
				</div>
			';
			
			$tcol = rfk_plugin_helper::trigger_event('tasks_print_task_content', $tcol);
			
			$part []= implode('',$tcol);
	    }
	    
	    $part	= rfk_plugin_helper::trigger_event('tasks_print_all_content', $part);
	    
	    return implode('',$part);
    }
}

/* End of file task_helper.php */
/* Location: ./application/helpers/decorators/task_helper.php */