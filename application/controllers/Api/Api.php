<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user');
	}

	public function user_get($id = 0)
	{
		$users = $this->user->getRows($id);

		if(!empty($users))
		{
			$this->response($users, REST_Controller::HTTP_OK);
		}
		else
		{
			$this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function user_post()
	{
		$userdata = array();

		$userdata['first_name'] = $this->input->post('first_name');
		$userdata['last_name'] = $this->input->post('last_name');
		$userdata['email'] = $this->input->post('email');
		$userdata['phone'] = $this->input->post('phone');

		if(!empty($userdata['first_name']) && !empty($userdata['last_name']) && !empty($userdata['email']) && !empty($userdata['phone']))
		{
			$insert = $this->user->insert($userdata);
			if($insert){
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User has been added successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
		}
		else{
            //set the response and exit
            $this->response("Provide complete user information to create.", REST_Controller::HTTP_BAD_REQUEST);
        }
	}


	public function user_delete($id = 0)
	{
		if(!empty($id))
		{
			$this->response([
                    'status' => TRUE,
                    'message' => 'User has been deleted successfully.'
                ], REST_Controller::HTTP_OK
			);
		}
		else
		{
			$this->response('User not found', REST_Controller::HTTP_NOT_FOUND);
		}
	}
}
