<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH . '/libraries/REST_Controller.php';

	class MyProfile extends REST_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->data1 = array('success'=>0,'data'=>array(),'error'=>"Invalid Api");

			$this->load->model('auth_model');
			$this->load->helper('string');


			$unique_id 		= $this->input->post('unique_id');
			$access_token 	= $this->input->post('access_token');

			if(!empty($unique_id) && !empty($access_token))
			{	
				$res = $this->db->get_where('users',array('unique_id'=>$unique_id,'access_token'=>$access_token))->row();
				if(empty($res))
				{
					$this->set_response($this->data1, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code						
				}
			}
			else
			{
					$this->set_response($this->data1, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
			}



		}

		function userDetails_post()
		{
			$unique_id    = $this->input->post('unique_id');
			$access_token = $this->input->post('access_token');

			$res = $this->db->get_where('users',array('unique_id'=>$unique_id,'access_token'=>$access_token))->row();
			
			if(!empty($res))
			{
				$this->data1 = array('success'=>1,'data'=>$res);
			}
			$this->set_response($this->data1, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code						
		}
	}
