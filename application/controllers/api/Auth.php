<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH . '/libraries/REST_Controller.php';

	class Auth extends REST_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->data1 = array('success'=>0,'data'=>array(),'error'=>"Invalid Api");

			$this->load->model('auth_model');
			$this->load->helper('string');
		}

		

		public function login_post()
		{
			$this->load->library("form_validation");

			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('email',"Email","required|valid_email");

			if($this->form_validation->run() == true)
			{
				$name = $this->input->post('name');
				$email = $this->input->post('email');

				$data = $this->auth_model->auth($name, $email);

				if(!empty($data))
				{
					
					$accessToken = random_string();
					$this->db->update('users',array('access_token'=>$accessToken,'last_accesstime'=>time()));
					$this->db->where('id',$data['id']);

					$data['access_token']=$accessToken;
					unset($data['id']);
					
					$this->data1 = array('success'=>1,'data'=>$data);
				}
				else
				{
					$this->data1 = array('success'=>0,'data'=>array());
				}

				$this->set_response($this->data1, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code		
			}
			else
			{
				$this->data1 = array('success'=>0,'data'=>array(),'error'=>$this->form_validation->error_array());
				$this->set_response($this->data1, REST_Controller::HTTP_CREATED); 
			}
		}

		public function user_get()
		{
			$data = array('name'=>"ajay",'age'=>56);

		}


	}
?>