<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Task Model
*
* Author:  Victor Santacreu
* @author  victor@ebavs.net
*
*
* Location: 
*
* Created:  15/02/2013
*
* Description:  Task model
* 
*/

class Task_model extends CI_Model {
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Get list of tasks
     * 
     * @param int $actual_user_id Actual user
     * @param int $user_id user to see tasks
     * @param int $project_id project id
     * @param int $time_concept 0 = future tasks , 1 = past tasks , 2 all tasks
     * @return array of objects 
     */
    public function get_tasks($actual_user_id, $user_id = null, $project_id = null, $time_concept = 0, $projects = array()) {
        
        $this->db
                ->select('tasks.*, COUNT(DISTINCT rfk_task_comment.post_date) comment_count,
                        SUBSTRING(MAX(CONCAT(rfk_task_status.status_date,rfk_task_status.status)),1,19) AS status_date, 
                        SUBSTRING(MAX(CONCAT(rfk_task_status.status_date,rfk_task_status.status)),20) AS status_key,
                        projects.name as project_name, users.first_name as first_name, 
                        users.last_name as last_name, users.username as username, 
                        user_project.position', false)
                ->join('task_status', 'task_status.task_id = tasks.task_id', 'inner' )
                ->join('projects', 'tasks.project_id = projects.project_id', 'left' )
                ->join('user_project', 'user_project.project_id = tasks.project_id AND rfk_user_project.user_id = ' . $actual_user_id, 'left')
                ->join('users', 'users.id = tasks.user_id', 'left')
                ->join('task_comment', 'tasks.task_id = task_comment.task_id', 'left')                
                ->where('(rfk_tasks.private = 0 OR rfk_tasks.private = 1 OR (rfk_tasks.private = 2 AND (rfk_tasks.user_id=' . $actual_user_id . ' OR rfk_tasks.author_id = ' . $actual_user_id . ')))')
                ->group_by('tasks.task_id')                
                ->order_by('tasks.deadline_date','asc')
                ->order_by('tasks.priority','asc');
        
      
        //if $time_concept == 2 do nothing to show all tasks
        switch ($time_concept) {
            
            case 0:
                $this->db->having('(status_key = 5 AND DATE(status_date) >= CURDATE()) OR status_key < 5');
                break;

            case 1:
                $this->db->having('(DATE(tasks.deadline_date) <= CURDATE() OR status_key = 5)');
                break;
            
        }
        
        if (!is_null($user_id) ) {
            
            $this->db->where('tasks.user_id', $user_id);
            
            if (is_array($projects) && count($projects)>0 ) {
                
                $this->db->where_in('tasks.project_id', $projects);
                
            }
        }
        
        if (!is_null($project_id)) {
            
            $this->db->where('tasks.project_id', $project_id);
            
        }
        
        return $this->db->get('tasks')->result_object();
        
    }
 
    public function get_users_project($project_id) {
        
        if ($project_id == 0) {
            return $this->db
                        ->select('users.id, users.first_name, users.last_name')
                        ->get('users')
                        ->result_array();
        }
        else {
            return $this->db
                        ->select('users.id, users.first_name, users.last_name')
                        ->join('users', 'users.id = user_project.user_id', 'inner')
                        ->where('user_project.project_id', $project_id)
                        ->get('user_project')
                        ->result_array();
            
        }
        
        
    }
}

/* End of file task_model.php */
/* Location: ./application/models/task_model.php */
