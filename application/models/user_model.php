<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  User Model
*
* Author:  Victor Santacreu
* @author  victor@ebavs.net
*
*
* Location: 
*
* Created:  11/02/2013
*
* Description:  Users model
* 
*/

class User_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function get_projects_user($user_id)
    {

        return $this->db
                ->select('projects.project_id, projects.name, user_project.position')                
                ->join('user_project', 'user_project.project_id = projects.project_id', 'inner' )                
                ->where('user_project.user_id', $user_id)
                ->get('projects')
                ->result_object();

    }
    
    public function get_all_users_with_group()
    {

        return $this->db->select(
                            $this->ion_auth_model->tables['users'].'.*, '.
                            $this->ion_auth_model->tables['users_groups'].'.'.$this->ion_auth_model->join['groups'].' as group_id, '.
                            $this->ion_auth_model->tables['groups'].'.name as group_name, '.
                            $this->ion_auth_model->tables['groups'].'.description as group_desc'
                    )
                ->join($this->ion_auth_model->tables['users_groups'], $this->ion_auth_model->tables['users_groups'].'.'.$this->ion_auth_model->join['users'].'='.$this->ion_auth_model->tables['users'].'.id')
                ->join($this->ion_auth_model->tables['groups'], $this->ion_auth_model->tables['users_groups'].'.'.$this->ion_auth_model->join['groups'].'='.$this->ion_auth_model->tables['groups'].'.id')
                ->get($this->ion_auth_model->tables['users'])->result();
        
    }
    
    public function get_country() {
        
        return $this->db->order_by('name')
                        ->get('country')                        
                        ->result_array();
        
    }
    
}

?>
