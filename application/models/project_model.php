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

class Project_model extends CI_Model
{
    
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * List projects from a user
     * 
     * @param int $user_id
     * @return object list of projects 
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
        
    }
    
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
     * faltan tareas y relacionados
     * 
     * @param type $project_id
     * @param type $user_id 
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

    public function get_project($project_id) {
        return $this->db                
                ->where('projects.project_id', $project_id)
                ->join('project_status', 'project_status.project_id = projects.project_id', 'inner')
                ->order_by('project_status.project_status_id','desc')
                ->get('projects')
                ->row();
    }
    
    public function get_users_project($project_id) {
        
        return $this->db
                ->select('user_project.user_id, user_project.position, users.first_name, users.last_name')
                ->where('project_id', $project_id)
                ->join('users', 'user_project.user_id = users.id', 'inner')
                ->get('user_project')
                ->result_object();
        
    }
    
    public function get_user_position($project_id, $user_id) {
        
        return $this->db
                ->select('user_project.position')
                ->where('project_id', $project_id)
                ->where('user_id', $user_id)                
                ->get('user_project')
                ->result_object();
        
    }
    
    public function set_user_project($user_id, $project_id, $position) {
        
        $user_data = array(
            'user_id'       => $user_id,
            'project_id'    => $project_id,
            'position'      => $position
        );
        $this->db->insert('user_project', $user_data);
        
    }
    
    public function remove_user_project($user_id, $project_id) {
        
        $user_data = array(
                    'user_id'       => $user_id,
                    'project_id'    => $project_id
        );
        $this->db->delete('user_project', $user_data);              
        
    }
    
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