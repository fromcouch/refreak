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
/**
 * User Model
 *
 * @package	Refreak
 * @subpackage	users
 * @category	model
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class User_model extends CI_Model {
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->plugin_handler->trigger('users_model_init');
        
    }
    
    /**
     * Get list of user projects
     *
     * @param int $user_id
     * @return object projects list
     * @access public
     */
    public function get_projects_user($user_id)
    {

        $this->db
                ->select('projects.project_id, projects.name, user_project.position')                
                ->join('user_project', 'user_project.project_id = projects.project_id', 'inner' )                
                ->where('user_project.user_id', $user_id);
        
        $data               = $this->plugin_handler->trigger('users_model_projects_user', array($user_id, $this->db) );
        $this->db           = $data[1];
        
        return $this->db->get('projects')
                ->result_object();

    }
    
    /**
     * Get all users inside a group
     * 
     * @return array users list
     * @access public
     */
    public function get_all_users_with_group()
    {

        $this->db->select(
                            $this->ion_auth_model->tables['users'].'.*, '.
                            $this->ion_auth_model->tables['users_groups'].'.'.$this->ion_auth_model->join['groups'].' as group_id, '.
                            $this->ion_auth_model->tables['groups'].'.name as group_name, '.
                            $this->ion_auth_model->tables['groups'].'.description as group_desc'
                    )
                ->join($this->ion_auth_model->tables['users_groups'], $this->ion_auth_model->tables['users_groups'].'.'.$this->ion_auth_model->join['users'].'='.$this->ion_auth_model->tables['users'].'.id')
                ->join($this->ion_auth_model->tables['groups'], $this->ion_auth_model->tables['users_groups'].'.'.$this->ion_auth_model->join['groups'].'='.$this->ion_auth_model->tables['groups'].'.id');
        
        $this->db           = $this->plugin_handler->trigger('users_model_users_with_group', $this->db );
                
        return $this->db->get($this->ion_auth_model->tables['users'])->result();
        
    }
    
    /**
     * Get country list
     * 
     * @return array
     * @access public
     */
    public function get_country() {
        
        
        
        $this->db->order_by('name')
                 ->from('country');
        
         $this->db          = $this->plugin_handler->trigger('users_model_country', $this->db);

         return $this->db->get()
                        ->result_array();
        
    }
    
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
