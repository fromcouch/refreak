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
                
        $tfields = rfk_plugin_helper::trigger_event('users_view_list_head_table', $tfields);
        
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
                
                $tcol = rfk_plugin_helper::trigger_event('users_view_list_content_table_column', $tcol);
                
                $trow []= '
                    <tr ' . $tr_class . '>
                        ' . implode('', $tcol) . '
                    </tr>
                '; 
                
                unset($tcol);
            }        
            
        $trow = rfk_plugin_helper::trigger_event('users_view_list_content_table_row', $trow);
        
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
    
    
    /**
     * Edit user personal info part
     * 
     * @param string $compulsory_text Compulsory text
     * @param string $title_text Title text
     * @param string $title title 
     * @param string $titleexample title example
     * @param string $firstname_text First name example
     * @param string $first_name First name
     * @param string $lastname_text Last name text
     * @param string $last_name Last name
     * @param string $company_text Company text
     * @param string $company Company
     * @param string $email_text Email text
     * @param string $email email
     * @param string $city_text City Text
     * @param string $city City
     * @param string $country_text Country text
     * @param array $country Country
     * @param string $personal_text Personal info text
     * @return string Upper HTML  part for edit user
     * @static
     * @access public
     */
    public static function edit_user_personal_info($compulsory_text, $title_text, $title, $titleexample, $firstname_text, $first_name, $lastname_text, $last_name, $company_text, $company, $email_text, $email, $city_text, $city, $country_text, $country, $personal_text  ) {
        
        $part = array();
            
        $part['compulsory'] = '
            <p>
                    ' . $compulsory_text . '
            </p>
        ';
        
        $part['title'] = '
            <p>
                    <label>' . $title_text . '</label>
                    ' . form_input($title, '', 'class ="shortest"') . '
                    <small>' . $titleexample . '</small>
            </p>
        ';
        
        $part['firstname'] = '
            <p>
                    <label class="compulsory">' . $firstname_text . '</label>
                    ' . form_input($first_name) . '
            </p>
        ';

        $part['lastname'] = '
            <p>
                    <label class="compulsory">' . $lastname_text . '</label>
                    ' . form_input($last_name) .'
            </p>
        ';
        
        $part['company'] = '
            <p>
                    <label>' . $company_text . '</label>
                    ' . form_input($company) . '
            </p>
        ';

        $part['email'] = '
            <p>
                    <label class="compulsory">' . $email_text . '</label>
                    ' . form_input($email) . '
            </p>  
        ';
        
        $part['city'] = '
            <p>
                    <label>' . $city_text . '</label>
                    ' . form_input($city) . '
            </p>     
        ';
        
        $part['country'] = '
            <p>
                    <label>' . $country_text . '</label>
                    ' . form_dropdown($country['name'], $country['data'], $country['value']) . '
            </p>
        ';
                
        $html = form_fieldset($personal_text) . 
                implode('', $part) .
                form_fieldset_close(); 
        
        unset($part);
        
        return $html;
    }
            
    /**
     * Account part 
     * 
     * @param string $username_text
     * @param string $username
     * @param string $passwordchanging
     * @param string $password
     * @param string $confirmpasschanging
     * @param string $password_confirm
     * @param bool $access
     * @param string $active_user
     * @param string $enabled_text
     * @param array $groups
     * @param integer $user_id
     * @param string $groups_show
     * @param string $account_text
     * @return string Account HTML part
     * @access public
     * @static
     */        
    public static function edit_user_account($username_text, $username, $passwordchanging, $password, $confirmpasschanging, $password_confirm, $access, $active_user, $enabled_text, $groups, $user_id, $groups_show, $account_text ) {
        
        $part = array();
        
        $part['username']= '
            <p>
                    <label class="password compulsory">' . $username_text . '</label>
                    ' . form_input($username) . '
            </p>
        ';

        $part['password']= '
            <p>
                    <label class="password compulsory">' . $passwordchanging . ' </label>
                    ' . form_input($password) . '
            </p>
        ';

        $part['confirm']= '
            <p>
                    <label class="password compulsory">' . $confirmpasschanging . ' </label>
                    ' . form_input($password_confirm) . '
            </p>
        ';
        
        if ($access) {
            
            $part['active']= '
                <p>
                        ' . form_checkbox($active_user) . '
                        <span>' . $enabled_text . '</span>
                        ' . form_dropdown('group', $groups, $user_id, 'class="group"' . $groups_show) . '
                </p>
            ';
            
        }

        $html = 
                form_fieldset($account_text) . 
                implode('', $part) . 
                form_fieldset_close() .
                form_hidden('id', $user_id);

        
        return $html;

    }
}

/* End of file user_helper.php */
/* Location: ./application/helpers/decorators/user_helper.php */