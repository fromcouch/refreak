<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * recurring Tasks Refreak Plugin
 *
 * @version 0.1beta
 * @package	Refreak
 * @subpackage	plugin
 * @category	plugin
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Recurring extends RF_Plugin {
    
	/**
	 * Task id readed from events
	 * 
	 * @var integer 
	 * @access private
	 */
	private $task_id			= 0;
	
	/**
	 * Actual user id
	 * 
	 * @var integer 
	 * @access private
	 */
	private $actual_user_id		= 0;
	
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct() {
        
        parent::__construct();
		
    }
    
	public function initialize() {
		
		$this->load_lang('recurring-tasks');
		
		$this->attach_events();
		
	}
	
    public function edit() {
	    
		$this->load_lang('recurring-tasks');
		//$this->css_add(base_url() . 'plugins' . DIRECTORY_SEPARATOR . $this->directory . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'edit.css');
		
    }
	
	public function install() {
		
		$this->load_model('recurring_model');
		$this->_ci->recurring_model->install();
		
	}
	
	public function attach_events() {
		
		/*
		 * 1. attach event for init task controller
		 * 2. look for how many recurring task exists 
		 * 3. if recurring task are less than config number of tasks create the rest of tasks
		 * 4. modify view to add recurring time. How many days to repeat.
		 * 
		 */
		
		//attach for creating task
		$this->attach('tasks_post_init', array($this, 'try_recurring'));
		
		//this event is because i need task id and decorator don't send to me
		$this->attach('tasks_show_edit_task', array($this, 'get_task_id'));
		
		//event for show new inputs and selects in edit window
		$this->attach('tasks_view_edit_task_pr_dead', array($this, 'render_edit'));
		
		//save the recurring task
		$this->attach('tasks_save_task_saved', array($this, 'save_task'));
		
	}
        
	/**
	 * Initialize the recurring system looking for task consistency
	 * 
	 * @param string $evt Event name
	 * @param array $data Data
	 * @return array Data
	 * @access public
	 */
	public function try_recurring( $evt, $data ) {
		
		$this->actual_user_id	= $data['actual_user']->id;
		
		$this->load_model('recurring_model');
		$tasks					= $this->_ci->recurring_model->get_recurring_tasks($this->actual_user_id);
		print_r($tasks);
		if (count($tasks) < (int)$this->config->recurring_many_numbers) {
			//we need to know how many task we need to create
			$total_new			= (int)$this->config->recurring_many_numbers - count($tasks);
			
//			for ($e = 1; $e <= $total_new; $e++) {
//				
//			}
			
		}
		
		return $data;
	}
	
	public function get_task_id( $evt, $data ) {
		
		$this->task_id		= $data['task_id'];
		
		return $data;
		
	}
	
	/**
	 * Render edit part in edit popup
	 * 
	 * @param string $evt Event name fired
	 * @param array $data Array with data
	 * @return array Data modified
	 * @access public 
	 */
	public function render_edit( $evt, $data ) {
		
		$checked				= FALSE;
		$every					= '';
		$moment					= 'day';
		
		//here need to get recurred task
		$this->load_model('recurring_model');
		$task					= $this->_ci->recurring_model->get_recurring_task($this->task_id);
		
		if (!is_null($task)) {
			
			$checked			= TRUE;
			$every				= $task[0]->every;
			$moment				= $task[0]->moment;
			
		}
		
		$day					= ($moment === 'day') ? 'selected="selected"' : '';
		$week					= ($moment === 'week') ? 'selected="selected"' : '';
		$month					= ($moment === 'month') ? 'selected="selected"' : '';
		$year					= ($moment === 'year') ? 'selected="selected"' : '';
		
		$data ['recurring']= '
                <tr>
						<th>
							' . $this->_ci->lang->line('recurring_task_recurring') . ':
						</th>
						<td colspan="3">
							' . form_checkbox('recurring', 'yes', $checked) . '
							' . $this->_ci->lang->line('recurring_task_every') . ':
							' . form_input('every',$every, 'style="width: 100px;"') . '
							<select class="moment" name="moment">
								<option value="day" ' . $day . '>' . $this->_ci->lang->line('recurring_task_moment_day') . '</option>
								<option value="week"  ' . $week . '>' . $this->_ci->lang->line('recurring_task_moment_week') . '</option>
								<option value="month"  ' . $month . '>' . $this->_ci->lang->line('recurring_task_moment_month') . '</option>
								<option value="year"  ' . $year . '>' . $this->_ci->lang->line('recurring_task_moment_year') . '</option>
							</select>
						</td>
                </tr>
        ';
		
		return $data;
	}
	
	/**
	 * Create recurring tasks
	 * 
	 * @param string $evt Event name
	 * @param array $data Array with data
	 * @return array Data parsed
	 * @access public
	 */
	public function save_task( $evt, $data ) {
		
		$task_id				= $data[0];
		$post_data				= $data[1];
		$task_parent_id			= $data[2];
		
		if ($post_data->post('recurring') !== FALSE) {
			
			$this->load_model('recurring_model');
			$this->_ci->recurring_model->save($task_id, $post_data->post('every'), $post_data->post('moment'), $post_data->post('recurring') === 'yes');
		
			$this->load_model('task_model');
			
			//get deadline and every
			$every				= intval($post_data->post('every'));
			$deadline			= $post_data->post('deadline');
			
			//build interval
			$interval			= $this->parse_interval($every, $post_data->post('moment'));
			
			//create new tasks and relation
			$recurring				= intval($this->config->recurring_many_numbers);
			$this->create_recurrent_tasks($recurring,
											$interval,
											$task_id, 
											$post_data->post('task_title'),
											$post_data->post('task_priority'),
											$post_data->post('task_context'),
											$deadline,
											$post_data->post('task_projects'),
											$post_data->post('task_project_name'),
											$post_data->post('task_description'),
											$post_data->post('task_users'),
											$post_data->post('showPrivate'),
											$post_data->post('task_status'),
											$task_parent_id);
			
		}
		
		return $data;
	}
	
	/**
	 * Create recurrent tasks
	 * 
	 * @param int $times how many times task will be created
	 * @param string $interval interval in time to create tasks
	 * @param int $task_id Main task id
	 * @param string $task_title Task title
	 * @param int $task_priority Task priority
	 * @param int $task_context Task Context
	 * @param string $deadline Task deadline
	 * @param int $task_projects Project Task
	 * @param string $task_project_name Name of Project for new project
	 * @param string $task_description Task Description
	 * @param int $task_users User ID assigned to task
	 * @param int $task_private Task Scope 0 = public, 1 = internal, 2 = private
	 * @param int $task_status  Task Status
	 * @param int $task_parent_id Parent Tasks if this is a subtask
	 * @return void
	 * @access private
	 */
	private function create_recurrent_tasks($times, $interval, $task_id, $task_title, $task_priority, $task_context, $deadline, $task_projects, $task_project_name, $task_description, $task_users, $task_private, $task_status, $task_parent_id) {
		
		for ($e = 1; $e <= $times; $e++) {
				
			$deadline		= $this->increase_date($deadline, $interval);

			$r_task_id		= $this->_ci->task_model->save_task(
									$task_title,
									$task_priority,
									$task_context,
									$deadline,
									$task_projects,
									$task_project_name,
									$task_description,
									$task_users,
									$task_private,
									$task_status,
									$this->actual_user_id,
									0,
									(int)$task_parent_id
			);

			$this->_ci->recurring_model->add_recurrence($r_task_id, $task_id);
		}
	}
	
	/**
	 * Parse Interval to DateInterval format
	 * 
	 * @param int $every 
	 * @param string $moment
	 * @return string Interval Format
	 * @access private
	 */
	private function parse_interval($every, $moment) {
		
		//build interval
		$interval			= 'P' . $every;
		switch($moment) {
			case 'day': 
				$interval		.= 'D';
				break;
			case 'week': 
				$interval		.= 'W';
				break;
			case 'month': 
				$interval		.= 'M';
				break;
			case 'year': 
				$interval		.= 'Y';
				break;
		}
		
		return $interval;
	}

	/**
	 * Increase date with interval specified
	 * @param string $date Original date to increase
	 * @param string $interval Interval
	 * @return string date increased
	 * @access private
	 */
	private function increase_date($date, $interval) {

		$idate			= new DateTime($date);
		$idate->add(new DateInterval($interval));
		return $idate->format('Y-m-d');
		
	}
}