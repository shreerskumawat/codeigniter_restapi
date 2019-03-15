<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRows($id)
    {
    	if(!empty($id))
    	{
    		$user = $this->db->where('id',$id)->get('users');
    		return $user->row_array();
    	}
    	else
    	{
    		$query = $this->db->get('users');
    		return $query->result_array();
    	}
    }

    public function insert($data = array())
    {
    	if(!array_key_exists('created', $data)){
            $data['created'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists('modified', $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }
        $insert = $this->db->insert('users', $data);
        if($insert){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
}