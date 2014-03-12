<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Recurring Model
 *
 * @package	Refreak
 * @subpackage	plugin
 * @category	model
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Recurring_model extends CI_Model {
	
	/**
     * Constructor
     * 
     */
    public function __construct() 
    {
        parent::__construct();
    }
	
	/**
	 * Installing plugin
	 * 
	 * @access public
	 * @return void
	 */
	public function install() {
		
		$this->create_table_recurring();
		$this->create_table_relation();
		
	}
	
	/**
	 * Create table realtion
	 * 
	 * @access private
	 * @return void
	 */
	private function create_table_relation() {
		
		$this->load->dbforge();

		$this->dbforge->add_field(array(
						'id'		=> array(
										'type'				=> 'INT',
										'constraint'		=> 9, 
										'unsigned'			=> TRUE,
										'auto_increment'	=> TRUE
						),
						'recurring_task_id'	=> array(
										'type'				=> 'INT',
										'constraint'		=> 9, 
										'unsigned'			=> TRUE
						),
						'task_id'		=> array(
										'type'				=> 'INT',
										'constraint'		=> 9, 
										'unsigned'			=> TRUE
						)
		));
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('recurring_rel', TRUE);
		
	}
	
	/**
	 * Create table recurring
	 * 
	 * @access private
	 * @return void
	 */
	private function create_table_recurring() {
		
		$this->load->dbforge();

		$this->dbforge->add_field(array(
						'id'		=> array(
										'type'				=> 'INT',
										'constraint'		=> 9, 
										'unsigned'			=> TRUE,
										'auto_increment'	=> TRUE
						),
						'task_id'	=> array(
										'type'				=> 'INT',
										'constraint'		=> 9, 
										'unsigned'			=> TRUE
						),
						'every'		=> array(
										'type'				=> 'INT',
										'constraint'		=> 9, 
										'unsigned'			=> TRUE
						),
						'moment'	=> array(
										'type'				=> 'ENUM("day","week","month","year")',
										'default'			=> 'day',
										'null'				=> FALSE,
						),
						'active'	=> array(
										'type'				=> 'BOOL',
										'default'			=> '1'
							
						)
		));
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('recurring_tasks', TRUE);
		
	}
	
	/**
	 * Get all recurring tasks
	 * 
	 * @param int $actual_user_id Actual user
	 * @access public
	 * @return array Array of tasks
	 */
	public function get_recurring_tasks($actual_user_id) {
		
			$max_status = $this->config->item('rfk_status_levels');
			
			$this->db
                ->select('tasks.*, recurring_tasks.*,
                        SUBSTRING(MAX(CONCAT(rfk_task_status.status_date,rfk_task_status.status)),1,19) AS status_date, 
                        SUBSTRING(MAX(CONCAT(rfk_task_status.status_date,rfk_task_status.status)),20) AS status_key',false)
				->join('recurring_tasks', 'recurring_tasks.task_id = tasks.task_id', 'inner')
                ->join('task_status', 'task_status.task_id = tasks.task_id', 'inner' )
				->join('user_project', 'user_project.project_id = tasks.project_id', 'left')
					
                ->where('recurring_tasks.active', 1)
                ->where('user_project.user_id', $actual_user_id)
				->or_where('(`rfk_tasks`.project_id = 0 AND rfk_tasks.user_id=' . $actual_user_id . ')')
                ->group_by('tasks.task_id')                
                ->order_by('tasks.deadline_date','asc')
                ->order_by('tasks.priority','asc')
				->having('(status_key = ' . $max_status . ' AND DATE(status_date) > CURDATE()) OR status_key < ' . $max_status . '');
        		
			return $this->db->get('tasks')->result_object();
	}
	
	/**
	 * Get one recurring task
	 * 
	 * @param int $task_id Task id
	 * @access public
	 * @return object Task
	 */
	public function get_recurring_task($task_id) {
		
		$this->db
                    ->select('recurring_tasks.task_id, recurring_tasks.every, recurring_tasks.moment')
                    ->where('recurring_tasks.task_id', $task_id);
                
		$result			= $this->db->get('recurring_tasks')->result_object();
		
        return count($result) > 0 ? $result : NULL;
		
	}
	
	/**
	 * Save recurring task
	 * 
	 * @param int $task_id Task identificator
	 * @param int $every repeat every
	 * @param string $moment how the repeat occurs
	 * @param int $active Active recurring or not
	 * @access public
	 * @return void
	 */
	public function save($task_id, $every, $moment, $active) {
		
		$data			= array(
						'task_id'			=> $task_id,
						'every'				=> $every,
						'moment'			=> $moment,
						'active'			=> $active
			);
		
		$this->db
				->select('recurring_tasks.id')
				->where('recurring_tasks.task_id', $task_id);
		
		$db					= $this->db->get('recurring_tasks');
		
		if ($db->num_rows() > 0) {
			$row				= $db->row();
			$id					= $row->id;
			
			$this->db->where('id', $id);
            $this->db->update('recurring_tasks', $data); 
		}
		else {
			$this->db->insert('recurring_tasks', $data);
		}
			
	}
	
	/**
	 * Add recurrence relation for task
	 * 
	 * @param int $task_id New task created
	 * @param int $original_task_id Original task_id
	 * @access public
	 * @return void
	 */
	public function add_recurrence($task_id, $original_task_id) {
		
		$data			= array(
						'task_id'			=> $original_task_id,
						'recurring_task_id'	=> $task_id
		);
		
		$this->db->insert('recurring_rel', $data);
		
	}
}
