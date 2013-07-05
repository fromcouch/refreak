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
     * @return string header table part
     * @access public
     * @static
     */
    public static function table_project_head_fields($project, $position, $members, $status, $tasks, $new, $access, $create_url, $theme_url) {
        
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
            
}

/* End of file project_helper.php */
/* Location: ./application/helpers/decorators/project_helper.php */