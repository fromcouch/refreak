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
	 */
	private $task_id		= 0;
	
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
		
		$actual_user_id			= $data['actual_user']->id;
		
		$this->load_model('recurring_model');
		$tasks					= $this->_ci->recurring_model->get_recurring_tasks($actual_user_id);
		
		return $data;
	}
	
	public function get_task_id( $evt, $data ) {
		
		$this->task_id		= $data['task_id'];
		
		return $data;
		
	}
	
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
	
	public function save_task( $evt, $data ) {
		
		$task_id			= $data[0];
		$post_data			= $data[1];
		
		if ($post_data->post('recurring') !== FALSE && $post_data->post('recurring') === 'yes') {
			
			$this->load_model('recurring_model');
			$this->_ci->recurring_model->save($task_id, $post_data->post('every'), $post_data->post('moment'));
		
			
		}
		
		return $data;
	}
	
	private function recurring($task_id) {
		
		
		
	}
}