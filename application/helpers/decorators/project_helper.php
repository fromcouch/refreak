<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Project Decorator Helper
 *
 * @package	Refreak
 * @subpackage	helper
 * @category	decorator
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class project_helper {
    
    /**
     * Decorate table head
     * 
     * @param string $content content to decorate
     * @return string content decorated
     * @static
     * @access public
     */
    public static function table_project_head($content) {
        
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
     * @param string $position header text for position column
     * @param string $members header text for members column
     * @param string $status header text for status column
     * @param string $tasks header text for tasks column
     * @param string $new alternate text for new button image
     * @param string $access have access to button?
     * @param string $create_url url for create project
     * @param string $theme_url theme url
     * @param string $action Action text
     * @return string header table part
     * @access public
     * @static
     */
    public static function table_project_head_fields($project, $position, $members, $status, $tasks, $new, $access, $create_url, $theme_url, $action) {
        
        $btn_new = '';
        
        if ($access) {
        
                $btn_new = '<a href="' . $create_url . '">
                                <img src="' . $theme_url . '/images/new.png" width="39" height="16" 
                                    border="0" hspace="3" alt="'. $new . '" />                        
                            </a>';
        }
        else {
                $btn_new = $action;
        }
        
        $tfields = array(
            '<th width="50%">' . $project .'</th>',
            '<th width="12%">' . $position . '</th>',
            '<th width="8%">' . $members . '</th>',
            '<th width="12%">' . $status . '</th>',
            '<th width="8%">' . $tasks . '</th>',
            '<th width="10%"  style="text-align:center">' . $btn_new . '</th>',
        );
        
        return implode('',$tfields);
        
    }
    
    
    /**
     * Create table project content
     * 
     * @param array $projects project list
     * @param array $position position array
     * @param array $status status array
     * @param string $edit_url edit url
     * @param string $theme_url theme url
     * @param string $delete_url delete url
     * @param bool $in_group user is in graup
     * @param bool $access user is admin
     * @param string $confirmdelete cinfirm delete text
     * @return string project rows 
     * @access public
     * @static
     */
    public static function table_project_body_fields($projects, $position, $status, $edit_url, $theme_url, $delete_url, $in_group, $access, $confirmdelete) {
        
               
        foreach ($projects as $table_project) {
            
                $tcol = array();
                
                //project name with link
                $tcol['project_name'] = '
                        <td>
                            <a href="' . $edit_url . $table_project->project_id . '">
                                ' . $table_project->name . '
                            </a>
                        </td>
                ';
                
                //position
                $tcol['position'] = '
                        <td>' . $position[$table_project->position] . '</td>
                ';
                
                //members
                $tcol['members'] = '
                        <td>' . $table_project->users . '</td>
                ';
                
                //status
                $tcol['status'] = '
                        <td>' . $status[empty($table_project->status_id) ? 1 : $table_project->status_id] . '</td>
                ';
                
                //tasks
                $tcol['tasks'] = '
                        <td>' . $table_project->tasks . '</td>
                ';
                
                
                if ($in_group) {
                    $btn_edit = '
                        <a href="' . $edit_url . $table_project->project_id . '">
                            <img src="' . $theme_url  . '/images/b_edit.png" width="20" height="16" border="0" />
                        </a>
                    ';
                }
                else {
                    $btn_edit = '
                        <img src="' . $theme_url . '/images/b_edin.png" width="20" height="16" border="0" />
                    ';
                } 
                    
                if ($table_project->position == 5 || $access) {
                    $btn_delete = '
                        <a href="' . $delete_url . $table_project->project_id . '" 
                                onclick="return confirm(\'' . $confirmdelete . '\');">
                                    <img src="' . $theme_url . '/images/b_dele.png" width="20" height="16" border="0" />
                        </a>
                    ';
                }
                else {
                    $btn_delete = '
                        <img src="' . $theme_url . '/images/b_deln.png" width="20" height="16" border="0" />
                    ';
                }
                
                $tcol []= '
                    <td align="center"> 
                        ' . $btn_edit . $btn_delete . '
                    </td>
                ';
                
                $trow [] = '
                    <tr>
                        ' . implode('', $tcol) . '
                    </tr>
                ';
                
                unset($tcol);
        }
            
           
        return implode('', $trow);
    }
 
    /**
     * Create project form
     * 
     * @param string $project_info_text Project info text
     * @param string $compulsory_text Compulsory text
     * @param string $project_name_text Project name text
     * @param string $project_desc_text Project description text
     * @param string $project_status_text Project status text
     * @param string $project_button_text Create project text
     * @param array $name project name
     * @param array $description project description
     * @param array $status list of status
     * @return string html form for create project
     * @access public
     * @static
     */
    public static function create_project($project_info_text, $compulsory_text, $project_name_text, $project_desc_text, $project_status_text, $project_button_text, $name, $description, $status) {
        
        $part = array();
        
        //open fieldset
        $part['fieldset_open'] = form_fieldset($project_info_text);
        
        //compulsory
        $part['compulsory'] = '<p>' . $compulsory_text . '</p>';
        
        //project name
        $part['name'] = '
                <p>
                    <label class="compulsory">' . $project_name_text . '</label>
                    ' . form_input($name) . '
                </p>
        ';
        
        //project description
        $part['description'] = '
                <p>
                    <label>' . $project_desc_text . '</label>
                    ' . form_textarea($description) . '
                </p>
        ';
        
        //project status
        $part['status'] = '
                <p>
                    <label>' . $project_status_text . '</label>
                    ' . form_dropdown('status', $status) . '
                </p>
        ';

        $part['submit'] = '
                <p>
                    '. form_submit('submit', $project_button_text) . '
                </p>    
        ';

        $part['fieldset_close'] = form_fieldset_close();
              
        return implode('', $part);
    }
    
    
    /**
     * Edit project upper part 
     * 
     * @param string $project_info_text Project info text
     * @param string $compulsory_text Compulsory text
     * @param string $project_name_text Project name text
     * @param string $project_desc_text Project description text
     * @param string $project_status_text Project status text
     * @param string $project_button_text Create project text
     * @param array $name project name
     * @param array $description project description
     * @param array $status list of status
     * @param integer $project_position actual user project position
     * @param string $selected_status selected status
     * @return string head html form for edit project
     * @access public
     * @static
     */
    public static function edit_project_info($project_info_text, $compulsory_text, $project_name_text, $project_desc_text, $project_status_text, $project_button_text, $name, $description, $status, $project_position, $selected_status) {
        
        $part = array();
        
        if ($project_position == 5) {
            $temp_name = form_input($name);
            $temp_desc = form_textarea($description);
        } else {
            $temp_name = $name['value'];
            $temp_desc = empty($description['value']) ? '-' : $description['value'];
        };
        
        //open fieldset
        $part['fieldset_open'] = form_fieldset($project_info_text);
        
        //compulsory
        $part['compulsory'] = '<p>' . $compulsory_text . '</p>';
        
        //project name
        $part['name'] = '
                <p>
                    <label class="compulsory">' . $project_name_text . '</label>
                    ' . $temp_name  . '
                </p>
        ';
        
        //project description
        $part['description'] = '
                <p>
                    <label>' . $project_desc_text . '</label>
                    ' . $temp_desc . '
                </p>
        ';
        
        //project status
        $part['status'] = '
                <p>
                    <label>' . $project_status_text . '</label>
                    ' . form_dropdown('status', $status, $selected_status) . '
                </p>
        ';

        $part['submit'] = '
                <p>
                    '. form_submit('submit', $project_button_text) . '
                </p>    
        ';

        $part['fieldset_close'] = form_fieldset_close();
              
        return implode('', $part);
    }
    
    /**
     * Add user to project
     * 
     * @param string $theme_url Theme url
     * @param string $add_members_text Add members text
     * @param string $user_text user text
     * @param string $position_text position text
     * @param array $dropdown_users user list
     * @param array $position position list
     * @return html part to select user to project
     * @access public
     * @static
     */
    public static function edit_add_user_to_project($theme_url, $add_members_text, $user_text, $position_text, $dropdown_users, $position)
    {
        
        $part = array();
        
        $part['selector'] = '
                <p>
                    <img src="' . $theme_url . '/images/bullet.png" /> 
                    <a href="" class="project_members">
                        ' . $add_members_text . '
                    </a>
                </p>
        ';
        
        $part['open_invitation'] = '
            <div class="invitation">
        ';
        
        $part['open_fieldset'] = form_fieldset();
        
        $part['open_table'] = '
            <table cellspacing="0" cellpadding="3" border="0" class="form">
        ';
        
        $part['users'] = '
                <tr>
                    <th>' . $user_text . ':</th>
                    <td>' . form_dropdown('dropdown_users', $dropdown_users, array(), 'class="dropdown_users"') . '</td>
                </tr>
        ';
        
        $part['position'] = '
                <tr>
                    <th>' . $position_text . ':</th>
                    <td>' . 
                        form_dropdown('project_position', $position, array(), 'class="project_position"')
                  . '</td>
                </tr>
        ';
        
        $part['add_button'] = '
                <tr>
                    <th>&nbsp;</th>
                    <td>' .
                        form_input(array(
                            'type'      => 'button',
                            'class'     => 'project_invite',
                            'value'     => $add_members_text,
                            'name'      => 'project_invite'
                        ))
                  . '</td>                            
                </tr>
        ';
        
        $part['close_table'] = '
                </table>
        ';
        
        $part['close_fieldset'] = form_fieldset_close();
        
        $part['close_invitation'] = '
                </div>
        ';
                
        return implode('', $part);
    }
    
    
    /**
     * table user part
     * 
     * @param string $theme_url Theme url
     * @param string $user_text User text
     * @param string $position_text position text
     * @param string $action_text action text
     * @param array $position postiion array
     * @param array $project_users project users list
     * @param object $actual_user actual user object
     * @return string html table part
     * @access public
     * @static
     */
    public static function edit_table_user($theme_url, $user_text, $position_text, $action_text, $position, $project_users, $actual_user)
    {
        $action = '';
        if ($actual_user->project_position >= 4) {
                $action = '<th width="10%">' . $action_text . '</th>';
        }
        
        $part = array();
        
        $part['open_table'] = '
                <table cellspacing="0" cellpadding="3" border="0" width="100%" class="data">
        ';
        
        //head
        $part['open_head'] = '<thead>';
        
        $part['header'] = '
                    <tr align="left">
                            <th width="45%">' . $user_text . '</th>
                            <th width="15%">' . $position_text . '</th>                            
                            ' . $action . '
                    </tr>
        ';

        $part['close_head'] = '</thead>';
        
        $part['open_body'] = '<tbody>';
            
        foreach ($project_users as $pu) {
            
            $tcol = array();
            
            //user name
            $tcol['name'] = '
                    <td>' . $pu->first_name . ' ' . $pu->last_name . '</td>
            ';
            
            //position
            $tcol['position'] = '
                    <td>' . $position[$pu->position] . '</td>
            ';
            
            if ($actual_user->project_position >= 4) {
                
                    if($pu->position === 5 || $actual_user->id == $pu->user_id || $pu->position >= $actual_user->project_position) {
                        $tcol['buttons'] = '
                            <td> - </td>
                        ';
                    }
                    else
                    {
                        $tcol['buttons'] = '
                            <td>
                                <a href="#" class="project_members_edit">
                                        <img src="' . $theme_url . '/images/b_edit.png" width="20" height="16" border="0" />
                                </a>
                                <a href="#" class="project_members_delete">
                                        <img src="' . $theme_url . '/images/b_dele.png" width="20" height="16" border="0" />
                                </a>
                            </td>
                        ';
                    }
            }
            
            $trow[] = '
                <tr data-id="' . $pu->user_id . '" class="project_data">
                    ' . implode('', $tcol) . '
                </tr>
            ';
               
        }
        
        $part['rows'] = implode('', $trow);
        
        $part['close_body'] = '</tbody>';
        
        $part['close_table'] = '</table>';
        
        return implode('', $part);
    }
    
    /**
     * bottom part
     * 
     * @param string $theme_url Theme url
     * @param string $add_members_text add members text
     * @param string $user_text User text
     * @param string $position_text position text
     * @param string $action_text action text
     * @param string $members_text members text
     * @param array $position position array
     * @param array $project_users project users list
     * @param object $actual_user actual user object
     * @param array $dropdown_users user list
     * @return string html table part
     * @access public
     * @static
     */
    public static function edit_bottom_part($theme_url, $add_members_text, $user_text, $position_text, $action_text, $members_text, $position, $project_users, $actual_user, $dropdown_users) {
        
        $part = array();
        
        $part['open_field'] = form_fieldset($members_text);

        if ($actual_user->project_position >= 4) {
                  
                  $part['user_to_project'] = project_helper::edit_add_user_to_project($theme_url, 
                                                                                      $add_members_text, 
                                                                                      $user_text, 
                                                                                      $position_text,
                                                                                      $dropdown_users, 
                                                                                      $position);
                  
        }
              
        $part['table_user'] = project_helper::edit_table_user($theme_url, 
                                                              $user_text, 
                                                              $position_text, 
                                                              $action_text, 
                                                              $position, 
                                                              $project_users, 
                                                              $actual_user);
        
        $part['close_field'] =  form_fieldset_close(); 
        
        return implode('', $part);
        
    }
}

/* End of file project_helper.php */
/* Location: ./application/helpers/decorators/project_helper.php */