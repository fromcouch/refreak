<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Tasks Model
 *
 * @package	Refreak
 * @subpackage	tasks
 * @category	model
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Task_model extends CI_Model {
    
    /**
     * Constructor
     * 
     */
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
     * @return array of objects with tasks
     * @access public
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
 
    /**
     * Return users assigned to a specific project. If no project is set return all users
     * 
     * @param int $project_id Project ID
     * @return array Users List
     * @access public 
     */
    public function get_users_project($project_id = 0) {
        
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
    
    /**
     * Insert or Update a task
     * 
     * @param string $title Task title
     * @param int $priority Task priority
     * @param int $context Task Context
     * @param date $deadline Task deadline
     * @param int $project_id Project Task 
     * @param string $project_name Name of Project for new project
     * @param string $description Task Description
     * @param int $user_id User ID assigned to task
     * @param int $scope Task Scope 0 = public, 1 = internal, 2 = private
     * @param int $status Task Status
     * @param int $author_id User ID created task
     * @param int $task_id 0 for new Task or Task ID for update
     * @return int Return Task ID
     * @access public
     */
    public function save_task($title, $priority, $context, $deadline, $project_id, $project_name, $description, $user_id, $scope, $status, $author_id, $task_id = 0) {
        
        if (!empty($project_name)) {
            // Create new project
            $this->load->model('project_model');
            $project_id         = $this->project_model->save($project_name, $author_id);
            
            // assing position to Official to user
            $this->project_model->set_user_project($user_id, $project_id, 2);
        }
        
        $task_data              = array(
                                    'title'             => $title,
                                    'priority'          => $priority,
                                    'context'           => $context,
                                    'deadline_date'     => $deadline,
                                    'project_id'        => $project_id,
                                    'description'       => $description,
                                    'user_id'           => $user_id,
                                    'private'           => $scope,                                    
                                    'author_id'         => $author_id
        );
        
        // task id 0 is for insert, if task_id have non zero value is an update
        if ($task_id === 0) {
            $this->db->insert('tasks', $task_data); 
            $task_id           = $this->db->insert_id();   //get id from project
        }
        else {
            $this->db->where('task_id', $task_id);
            $this->db->update('tasks', $task_data); 
        }                
        
        $status_data            = array(
                                    'task_id'           => $task_id,
                                    'status'            => $status,
                                    'status_date'       => date('Y-m-d'),
                                    'user_id'           => $user_id
        );
        
        $this->db->insert('task_status', $status_data);
        
        return $task_id;
    }
    
    /**
     * Get single Task
     * 
     * @param type $task_id
     * @return array Task
     * @access public
     */
    public function get_task($task_id) {
        
        return $this->db 	 	 
                        ->select('tasks.task_id, tasks.project_id, tasks.priority, tasks.context, 
                                  tasks.title, tasks.description, tasks.deadline_date, tasks.private,
                                  tasks.user_id, tasks.author_id, tasks.modified_date') 
                        ->select('SUBSTRING(MAX(CONCAT(rfk_task_status.status_date,rfk_task_status.status)),20) AS status', false)
                        ->join('task_status', 'task_status.task_id = tasks.task_id', 'inner' )
                        ->where('tasks.task_id', $task_id)
                        ->get('tasks')
                        ->result_array();
        
    }
    
    public function get_task_description($task_id) {
        
        $task           = $this->db
                            ->select('tasks.description')                
                            ->where('tasks.task_id', $task_id)
                            ->get('tasks')
                            ->result_object();
        
        if (count($task)>0) {
                return $task[0]->description;
        }
        else {
                return;
        }
        
    }
}

/* End of file task_model.php */
/* Location: ./application/models/task_model.php */
