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
    
    public function edit() {
	    
		$this->css_add(base_url() . 'plugins' . DIRECTORY_SEPARATOR . $this->directory . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'edit.css');
		$this->lang_load('email-notifications');
	
		$this->creating_task_event(NULL, NULL);
    }
	
	public function attach_events() {
		
		if ($this->config->creating_task_activated === "1") {
			//attach for creating task
			$this->attach('tasks_model_insert_task', array($this, 'creating_task_event'));
		}
		
		if ($this->config->editing_task_activated === "1") {
			//attach for editing task
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
        
	private function creating_task_event( $evt, $data ) {
		
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
			$sendto[]		= $user_assigned['email'];
		}
		
		if ($this->config->creating_task_project_members === '1') {
			$users_p		= $this->_ci->task_model->get_users_project($data['project_id']);
			
			foreach($users_p as $up) {
				$sendto[]		= $up['email'];
			}
		}
		
		$sendto				= array_unique($sendto);
		
		print_r($data);

	}
	
	private function sendmail($to, $subject, $body) {
		
	}
}