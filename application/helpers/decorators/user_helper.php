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
     * @return string user rows
     * @access public
     * @static
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
    
    /**
     * Personal info 
     * 
     * @param object $user
     * @param array $groups
     * @param integer $user_group
     * @param string $author
     * @param string $url_theme
     * @param string $edit_url
     * @param bool $access
     * @param integer $actual_user_id
     * @param string $personalinfo_text
     * @param string $createdon_text
     * @param string $createdonby_text
     * @param string $name_text
     * @param string $level_text
     * @return string html upper part of detail user
     * @access public
     * @static
     */
    public static function detail_user_personal_info($user, $groups, $user_group, $author, $url_theme, $edit_url, $access, $actual_user_id, $personalinfo_text, $createdon_text, $createdonby_text, $name_text, $level_text) {
        
        //upper edit button
        $edit_button = '';
        if ($actual_user_id == $user->id || $access) {
            $edit_button = '<a href="' .$edit_url . $user->id . '">
                                <img src="' . $url_theme . '/images/b_edit.png" width="20" height="16" border="0" />
                            </a>
            ';
        }
        
        $fieldset = form_fieldset($personalinfo_text . ' (' . $user->username . ') ' . $edit_button);
        
        $fieldset .= '
                <div align="right">
                    <small>' . $createdon_text . ' ' . 
                                      date('j M y', $user->created_on) . $createdonby_text . 
                                      ' ' . $author . '</small>
                </div>

                <p>
                        <label>' . $name_text . '</label>
                        ' . $user->title . ' ' . $user->first_name . ' ' . $user->last_name . '
                </p>
        ';
        
        $fieldset .= '
                <p>
                    <label>' . $level_text . '</label>
        ';
                    
        if ($user->active) {
                    
                $reverse_groups = array_reverse($groups, true);                        
                foreach ($reverse_groups as $gr_id => $gr) {
                    $class = 'level_pad level_0';
                    if ($gr_id == $user_group)
                        $class = 'level_high level_'.$gr_id;

                    $fieldset .= '<span class="' . $class . '">' . $gr . '</span>';

                }
                
        } else {

                $fieldset .= $disabled_text;

        }                      
                        
        $fieldset .= '
                </p>
        ';
        
        $fieldset .= form_fieldset_close(); 
        
        return $fieldset;        
    }
    
    /**
     * Project List for details 
     * 
     * @param array $user_projects
     * @param array $position
     * @param string $listproject
     * @param string $projects_text
     * @param string $listposition_text
     * @param string $project_edit_url
     * @return string Project lis for user in HTML
     * @static
     * @access public
     */
    public static function detail_user_projects($user_projects, $position, $listproject, $projects_text, $listposition_text, $project_edit_url) {
        
        $fieldset = form_fieldset($projects_text);
        
        $fieldset .= '
                    <table class="data" width="100%">
                        <tr>
                            <th width="80%" align="left">' . $listproject . '</th>
                            <th align="left">' . $listposition_text . '</th>
                        </tr>
        ';                       
        
        foreach ($user_projects as $prj) {
            
            $fieldset .= '
                        <tr>
                            <td>
                                <a href="' . $project_edit_url . $prj->project_id . '">
                                    ' . $prj->name . '
                                </a>
                            </td>
                            <td>
                                ' . $position[$prj->position] . '</td>
                        </tr>
             ';
        }                    

        $fieldset .= '</table>';                  
        $fieldset .= form_fieldset_close(); 
        
        return $fieldset;
    }
            
}

?>
