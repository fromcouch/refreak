<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Email Notification Refreak Plugin
 *
 * @package	Refreak
 * @subpackage	plugin
 * @category	plugin
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Email_Notification extends RF_Plugin {
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct() {
        
        parent::__construct();
		
    }
    
	public function initialize() {
		
		$this->attach_events();
		
	}
	
    public function edit() {
	    
		$this->css_add(base_url() . 'plugins' . DIRECTORY_SEPARATOR . $this->directory . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'edit.css');
		$this->lang_load('email-notifications');
		
    }
	
	public function attach_events() {
		
		if ($this->config->creating_task_activated === "1") {
			//attach for creating task
			$this->attach('tasks_model_insert_task', array($this, 'creating_task_event'));
		}
		
		if ($this->config->editing_task_activated === "1") {
			//attach for editing task
			$this->attach('tasks_model_update_task', array($this, 'editing_task_event'));
		}
		
		if ($this->config->commenting_activated === "1") {
			//attach for commenting task
		}
		
		if ($this->config->project_user_activated === "1") {
			//attach for project_user
		}
		
		if ($this->config->user_activated === "1") {
			//attach for user
		}
		
		
	}
        
	public function creating_task_event( $evt, $data ) {
		
		$actual_user		= $this->_ci->ion_auth->user()->row();
		$groups				= $this->_ci->ion_auth->groups()->result_array();
		
		$sendto				= array();
		
		foreach($groups as $grp) {
			$property		= 'creating_task_group_'.$grp['name'];

			if ($this->config->$property === '1') {
				$us			= $this->_ci->ion_auth->users($grp['id'])->result_array();
				
				if (count($us) > 0) {
					foreach($us as $u) {
						if (!empty($u['email'])) {
							$sendto[]	= $u['email'];
						}
					}
				}
			}
		}

		if ($this->config->creating_task_creator === '1') {
			$sendto[]		= $actual_user->email;
		}
		
		if ($this->config->creating_task_assigned === '1') {
			$user_assigned	= $this->_ci->ion_auth->user($data['user_id'])->result_array();
			
			if (count($user_assigned) > 0) 
				$sendto[]		= $user_assigned[0]['email'];		//we get first one
		}
		
		if ($this->config->creating_task_project_members === '1') {
			$this->_ci->load->model('task_model');
			$users_p		= $this->_ci->task_model->get_users_project($data['project_id']);
			
			foreach($users_p as $up) {
				$sendto[]		= $up['email'];
			}
		}
		
		$sendto				= array_unique($sendto);
		//error_log($this->parse_task_vars($this->config->creating_task_email_body, $data),0);
		//error_log($data,0);
		
		return $data;
	}
	
	public function editing_task_event( $evt, $data ) {
		
		$task_id			= $data[0];
		$data				= $data[1];
		$actual_user		= $this->_ci->ion_auth->user()->row();
		$groups				= $this->_ci->ion_auth->groups()->result_array();
		
		$sendto				= array();
		
		foreach($groups as $grp) {
			$property		= 'editing_task_group_'.$grp['name'];

			if ($this->config->$property === '1') {
				$us			= $this->_ci->ion_auth->users($grp['id'])->result_array();
				
				if (count($us) > 0) {
					foreach($us as $u) {
						if (!empty($u['email'])) {
							$sendto[]	= $u['email'];
						}
					}
				}
			}
		}

		if ($this->config->editing_task_editor === '1') {
			$sendto[]		= $actual_user->email;
		}
		
		if ($this->config->editing_task_assigned === '1') {
			$user_assigned	= $this->_ci->ion_auth->user($data['user_id'])->result_array();
			
			if (count($user_assigned) > 0) 
				$sendto[]		= $user_assigned[0]['email'];		//we get first one
		}
		
		if ($this->config->editing_task_project_members === '1') {
			$this->_ci->load->model('task_model');
			$users_p		= $this->_ci->task_model->get_users_project($data['project_id']);
			
			foreach($users_p as $up) {
				$sendto[]		= $up['email'];
			}
		}
		
		$sendto				= array_unique($sendto);
		//print_r($this->parse_task_vars($this->config->editing_task_email_body, $data));
		//print_r($data);

		return array($task_id, $data);
	}
	
	private function sendmail($to, $subject, $body) {
		
	}
	
	private function parse_task_vars($text, $data) {
		
		preg_match_all("/\{.*?\}/", $text, $parsed_vars);
		
		foreach($parsed_vars[0] as $p) {
			
			switch ($p) {
				case '{task_creator}':
				case '{task_editor}':
					$actual_user		= $this->_ci->ion_auth->user()->row();
					$text				= str_replace($p, $actual_user->first_name . ' ' . $actual_user->last_name, $text);
					break;
				
				case '{task_user}':
					$user_assigned		= $this->_ci->ion_auth->user($data['user_id'])->result_array();
			
					if (count($user_assigned) > 0) 					
						$text			= str_replace('{task_user}', $user_assigned[0]['first_name'] . ' ' . $user_assigned[0]['last_name'], $text);
					break;
					
				case '{project_name}':
					$this->_ci->load->model('project_model');
					$project			= $this->_ci->project_model->get_project($data['project_id']);
					
					if (!is_null($project))
						$text			= str_replace('{project_name}', $project->name, $text);
					break;

				case '{refreak_url}':
					$text			= str_replace('{refreak_url}', site_url(), $text);
					
				default:
					
					if(strpos($text, $p) !== FALSE) {
						$var			= str_replace('{task_', '', $p);
						$var			= str_replace('}', '', $var);
						
						$text			= str_replace($p, $data[$var], $text);
					}
					
					break;
			}
		}
		
		return $parsed_vars;
	}
}