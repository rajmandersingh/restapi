<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Auth_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function auth($name,$email)
		{
			return $this->db->get_where("users",array('name'=>$name,'email'=>$email))->row_array();
		}
	}
?>