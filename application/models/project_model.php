<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Projects Model
*
* Author:  Victor Santacreu
* 		   victor@ebavs.net
*
*
* Location: 
*
* Created:  23/01/2013
*
* Description:  Projects model
* 
*/
/**
 * Project Model
 *
 * @package	Refreak
 * @subpackage	projects
 * @category	model
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Project_model extends CI_Model
{
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * List projects from a user
     * 
     * @param int $user_id
     * @return object list of projects 
     * @access public
     */
    public function get_projects_list($user_id)
    {

        return $this->db
                ->select('projects.*, up1.position, ps.status_id, COUNT( DISTINCT up2.user_id ) AS users,  COUNT( DISTINCT t.task_id ) AS tasks, MAX( ps.status_date ) AS status_date')                
                ->join('user_project up1', 'up1.project_id = projects.project_id AND up1.user_id = ' . $user_id, 'inner' )
                ->join('user_project up2', 'up2.project_id = projects.project_id', 'left' )
                //->join('project_status ps', 'ps.project_id = projects.project_id  AND ps.status_date = (' . $subquery . ')', 'inner')
                ->join('(SELECT * FROM rfk_project_status ORDER BY status_date DESC) ps', 'ps.project_id = projects.project_id', 'inner')
                ->join('tasks t', 't.project_id = projects.project_id', 'left')
                ->group_by('ps.project_id')
                ->order_by('ps.status_id','asc')
                ->order_by('projects.name','asc')
                ->get('projects')
                ->result_object();
                
    }
    
    /**
     * Insert project in database
     * 
     * @param string $name Project name
     * @param int $user_id User Id
     * @param string $description Project Description
     * @param int $status Project Status
     * @return int inserted project id
     * @access public
     */
    public function save($name, $user_id, $description = '', $status = 1) 
    {
        //insert project
        $project_data = array(
            'name'          => $name,
            'description'   => $description
        );
        $this->db->insert('projects', $project_data); //get id from project
        
        $last_project_id = $this->db->insert_id();
        
        // insert status
        $status_data = array(
            'project_id'    => $last_project_id,
            'status_date'   => date(DATE_ATOM),
            'status_id'     => $status,
            'user_id'       => $user_id
        );
        $this->db->insert('project_status', $status_data);
        
        // insert user to project
        // when create project fix position to leader        
        $this->set_user_project($user_id, $last_project_id, 5);
        
        return $last_project_id;
    }
    
    /**
     * Update project in database
     * 
     * @param int $project_id
     * @param string $name Project name
     * @param int $user_id User Id
     * @param string $description Project Description
     * @param int $status Project Status
     * @return void 
     * @access public
     */
    public function update($project_id, $name, $user_id, $description = '', $status = 1) 
    {
        
        $project_data = array(
            'name'          => $name,
            'description'   => $description
        );
        $this->db->update('projects', $project_data, array('project_id' => $project_id));
        
        $status_data = array(
            'project_id'    => $project_id,
            'status_date'   => date(DATE_ATOM),
            'status_id'     => $status,
            'user_id'       => $user_id
        );
        $this->db->insert('project_status', $status_data);
        
    }

    /**
     * Delete Project
     * 
     * @todo faltan tareas y relacionados. Seguro usuario???????
     * 
     * @param int $project_id Project ID to remove
     * @param int $user_id User Id to remove
     * @return void
     * @access public
     */
    public function delete($project_id, $user_id)
    {
        $this->remove_user_project($user_id, $project_id);
        
        $this->db->delete('project_status', 
                array(                    
                    'project_id'    => $project_id
                    )
        );
        
        $this->db->delete('projects', 
                array(
                    'project_id'    => $project_id
                    )
        );
    }

    /**
     * Get One Project
     * 
     * @param int $project_id
     * @return object project row
     * @access public
     */
    public function get_project($project_id) {
        return $this->db                
                ->where('projects.project_id', $project_id)
                ->join('project_status', 'project_status.project_id = projects.project_id', 'inner')
                ->order_by('project_status.project_status_id','desc')
                ->get('projects')
                ->row();
    }
    
    /**
     * Get users assigned to a project
     * 
     * @param int $project_id
     * @return object list of users
     * @access public
     */
    public function get_users_project($project_id) {
        
        return $this->db
                ->select('user_project.user_id, user_project.position, users.first_name, users.last_name')
                ->where('project_id', $project_id)
                ->join('users', 'user_project.user_id = users.id', 'inner')
                ->get('user_project')
                ->result_object();
        
    }
    
    /**
     * Get user position inside project
     * 
     * @param int $project_id
     * @param int $user_id
     * @return object 
     * @access public
     */
    public function get_user_position($project_id, $user_id) {
        
        return $this->db
                ->select('user_project.position')
                ->where('project_id', $project_id)
                ->where('user_id', $user_id)                
                ->get('user_project')
                ->result_object();
        
    }
    
    /**
     * Set position for project and user
     * 
     * @param int $user_id
     * @param int $project_id
     * @param int $position
     * @return void 
     * @access public
     */
    public function set_user_project($user_id, $project_id, $position) {
        
        $user_data = array(
            'user_id'       => $user_id,
            'project_id'    => $project_id,
            'position'      => $position
        );
        $this->db->insert('user_project', $user_data);
        
    }
    
    
    /**
     * Remove user from project
     * 
     * @param int $user_id
     * @param int $project_id
     * @access public
     * @return void
     */
    public function remove_user_project($user_id, $project_id) {
        
        $user_data = array(
                    'user_id'       => $user_id,
                    'project_id'    => $project_id
        );
        $this->db->delete('user_project', $user_data);              
        
    }
    
    /**
     * Update user position in project
     * 
     * @param int $user_id
     * @param int $project_id
     * @param int $position
     * @return void
     * @access public
     */
    public function update_user_position($user_id, $project_id, $position) {
        
        $user_data = array(                    
                    'position'      => $position
        );
        
        $user_where = array('user_id'       => $user_id,
                    'project_id'    => $project_id
        );
        
        $this->db->update('user_project', $user_data, $user_where);
        
    }
}