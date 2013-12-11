<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Email Model
 *
 * @package	Refreak
 * @subpackage	plugin
 * @category	model
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Email_model extends CI_Model {
	
	/**
     * Constructor
     * 
     */
    public function __construct() 
    {
        parent::__construct();
    }
	
	/**
     * Get task from comment id.
     * 
     * @param int $task_comment_id task comment id
     * @return int task id
     * @access public
     */
    public function get_task_from_comment($task_comment_id) {
        
        $db         = $this->db
                            ->select('task_comment.task_id')
                            ->where('task_comment.task_comment_id', $task_comment_id);
        
        $task       = $db->get('task_comment')
                            ->row();
		
        return $task->task_id;
        
    }
	
	/**
     * Get user from comment id.
     * 
     * @param int $task_comment_id task comment id
     * @return int user id
     * @access public
     */
    public function get_user_from_comment($task_comment_id) {
        
        $db         = $this->db
                            ->select('task_comment.user_id')
                            ->where('task_comment.task_comment_id', $task_comment_id);
        
        $task       = $db->get('task_comment')
                            ->row();
		
        return $task->user_id;
        
    }
}
