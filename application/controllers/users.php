<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/***
 * Controller Users
 * 
 * @todo adjust permisions and redirect to correct place if fail!
 */
/**
 * Users Controller
 *
 * @package	Refreak
 * @subpackage	users
 * @category	controller
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Users extends RF_Controller {
   
    /**
     * Constructor
     */
    public function __construct() {        
        parent::__construct();            
        //$this->output->enable_profiler(TRUE);
        
        $this->lang->load('users');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error_box">', '</div>');
        
        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

    }

    /**
     * List Users
     * 
     * @return void 
     * @access public
     */
    public function index()
    {
        
        $this->load->view('users/users', $this->data);
        
    }
        
    /**
     * Show And Process Create User Form and Creates a new user
     * 
     * @return void
     * @access public
     */
    public function create_user()
    {
        if ($this->ion_auth->is_admin()) {
            //validate form input
            $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

            if ($this->form_validation->run() == true)
            {
                    $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
                    $email    = $this->input->post('email');
                    $password = $this->input->post('password');
                    $group    = $this->input->post('group');
                    
                    $additional_data = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name'  => $this->input->post('last_name'),
                            'company'    => $this->input->post('company'),
                            'author_id'  => $this->data['actual_user']->id,
                            'title'      => $this->input->post('title'),
                            'city'       => $this->input->post('city'),
                            'country_id' => $this->input->post('country_id'),
                            'active'     => $this->input->post('active_user') === 'ok' ? true : false,
                    );
            }
            if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data, array($group)))
            { 
                    //check to see if we are creating the user
                    //redirect them back to the admin page
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("users", 'refresh');
            }
            else
            { 
                    //display the create user form
                    $this->data['title'] = array(
                            'name'  => 'title',
                            'id'    => 'title',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('title'),
                    );
                    $this->data['first_name'] = array(
                            'name'  => 'first_name',
                            'id'    => 'first_name',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('first_name'),
                    );
                    $this->data['last_name'] = array(
                            'name'  => 'last_name',
                            'id'    => 'last_name',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('last_name'),
                    );
                    $this->data['email'] = array(
                            'name'  => 'email',
                            'id'    => 'email',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('email'),
                    );
                    $this->data['company'] = array(
                            'name'  => 'company',
                            'id'    => 'company',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('company'),
                    );                    
                    $this->data['password'] = array(
                            'name'  => 'password',
                            'id'    => 'password',
                            'type'  => 'password',
                            'value' => $this->form_validation->set_value('password'),
                    );
                    $this->data['password_confirm'] = array(
                            'name'  => 'password_confirm',
                            'id'    => 'password_confirm',
                            'type'  => 'password',
                            'value' => $this->form_validation->set_value('password_confirm'),
                    );
                    $this->data['active_user'] = array(
                            'name'  => 'active_user',
                            'class' => 'active_user',
                            'checked'  => FALSE,
                            'value' => 'ok',
                    );
                    $this->data['city'] = array(
                            'name'  => 'city',
                            'id'    => 'city',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('city'),
                    );
                    $this->data['country'] = array(
                            'name'  => 'country_id',                    
                            'value' => $this->form_validation->set_value('country_id'),
                            'data'  => $this->to_dropdown_array($this->user_model->get_country(), 'country_id', 'name')
                    );

                    $this->data['groups'] = $this->to_dropdown_array($this->data['groups'], 'id', 'description');
                    
                    $this->load->view('auth/create_user', $this->data);
            }
        }
    }

    /**
     * Show And Process Edit User Form
     * 
     * @param int $id user id
     * @todo show user author
     * @return void
     * @access public
     */
    public function edit_user($id = false)
    {            
            if (!$id) $id = $this->data['actual_user']->id;
        
            $user = $this->ion_auth->user($id)->row();

            //validate form input
            $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
            $this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'required|xss_clean');

            if ($this->input->post('id') && $this->input->post('first_name'))
            {
                    // do we have a valid request?
                    if ($id != $this->input->post('id'))
                    {
                            show_error('This form post did not pass our security checks.');
                    }

                    $data = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name'  => $this->input->post('last_name'),
                            'company'    => $this->input->post('company'),                            
                            'email'      => $this->input->post('email'),
                            'title'      => $this->input->post('title'),
                            'city'       => $this->input->post('city'),
                            'country_id' => $this->input->post('country_id'),
                            'active'     => $this->input->post('active_user') === 'ok' ? true : false,
                    );

                    //update the password if it was posted
                    if ($this->input->post('password'))
                    {
                            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                            $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

                            $data['password'] = $this->input->post('password');
                    }

                    if ($this->form_validation->run() === TRUE)
                    { 
                            $this->ion_auth->update($user->id, $data);
                            
                            if ($this->input->post('group')) {                                
                                $this->ion_auth->remove_from_group(null, $user->id);
                                $this->ion_auth->add_to_group($this->input->post('group'), $user->id);
                            }
                            
                            //check to see if we are creating the user
                            //redirect them back to the admin page
                            $this->session->set_flashdata('message', "User Saved");
                            redirect("users", 'refresh');
                    }
            }


            //pass the user to the view
            $this->data['user'] = $user;

            $this->data['title'] = array(
                    'name'  => 'title',
                    'id'    => 'title',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('title', $user->title),
            );
            $this->data['first_name'] = array(
                    'name'  => 'first_name',
                    'id'    => 'first_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('first_name', $user->first_name),
            );
            $this->data['last_name'] = array(
                    'name'  => 'last_name',
                    'id'    => 'last_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('last_name', $user->last_name),
            );
            $this->data['company'] = array(
                    'name'  => 'company',
                    'id'    => 'company',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('company', $user->company),
            );            
            $this->data['password'] = array(
                    'name' => 'password',
                    'id'   => 'password',
                    'type' => 'password',
                    'autocomplete'  => 'off'
            );
            $this->data['password_confirm'] = array(
                    'name' => 'password_confirm',
                    'id'   => 'password_confirm',
                    'type' => 'password',
                    'autocomplete'  => 'off'
            );
            $this->data['email'] = array(
                    'name'  => 'email',
                    'id'    => 'email',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('email', $user->email),
            );
            $this->data['city'] = array(
                    'name'  => 'city',
                    'id'    => 'city',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('city', $user->city),
            );
            $this->data['active_user'] = array(
                    'name'  => 'active_user',
                    'class' => 'active_user',
                    'checked'  => $user->active,
                    'value' => 'ok',
            );
            $this->data['country'] = array(
                    'name'  => 'country_id',                    
                    'value' => $this->form_validation->set_value('country_id', $user->country_id),
                    'data'  => $this->to_dropdown_array($this->user_model->get_country(), 'country_id', 'name')
            );
            
            $this->data['groups'] = $this->to_dropdown_array($this->data['groups'], 'id', 'description');
            $this->data['groups_show'] = $user->active ? '' : ' style = "display:none" ';
            
            $this->load->view('auth/edit_user', $this->data);
    }
    
    
    /**
     * Show User Details Page
     * 
     * @param int $id User ID
     * @return void
     * @access public
     */
    public function details($id = false)
    {            
            if (!$id) $id = $this->data['actual_user']->id;
        
            //user to show
            $user               = $this->ion_auth->user($id)->row();
            $author             = $this->ion_auth->user($user->author_id)->row()->first_name;
            
            //load projects language, we need here.
            $this->lang->load('projects');
            
            $this->load->model('user_model');
            //$project_list = $this->user_model->get_projects_user($id); //don't need, is loaded in RF_BaseController
            
            //pass the user to the view
            $this->data['user']         = $user;
            $this->data['author']       = $author;
            $this->data['user_groups']  = $this->ion_auth->get_users_groups($id)->result_object();
            $this->data['groups']       = $this->to_dropdown_array($this->data['groups'], 'id', 'description');

            $this->load->view('users/details', $this->data);
    }
    
    /**
     * Delete User
     * 
     * @param int $id User to delete
     * @return void
     * @access public
     */
    public function delete_user($id) {
        
        if ($this->ion_auth->is_admin() && !empty($id) && $id != false && !is_null($id)) {
            $this->ion_auth->delete_user($id);
            
            $this->session->set_flashdata('message', "User Deleted");
            redirect("users", 'refresh');
        }
        
    }

    /**
     * Activate User
     * 
     * @param int $id User Id to activate
     * @return void
     * @access public
     */
    public function activate($id) {
                               
        if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);

            if ($activation)
            {
                    //redirect them to the auth page
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("users", 'refresh');
            }
            else
            {
                    //redirect them to the forgot password page
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect("users", 'refresh');
            }
        }
            
    }
    
    /**
     * Deactivate User
     * 
     * @param int $id User Id to deactivate
     * @return void
     * @access public
     */    
    function deactivate($id)
    {
            
            if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
            {
                    //redirect them to the user page
                    $this->session->set_flashdata('message', 'User Deactivated');
                    $this->ion_auth->deactivate($id);
            }

            //redirect them back to the auth page
            redirect('users', 'refresh');
            
    }

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */