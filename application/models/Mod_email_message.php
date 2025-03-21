<?php
Class Mod_email_message extends CI_Model {
	
	public function get_email_template(){
		$company_id = $this->session->userdata('user_id');
		$this->db->select("*");
		$this->db->from("project_email_templates");
		$this->db->where("company_id",$company_id);

		$query = $this->db->get();
		$result = $query->row();
		
		return $result;
	}
	public function add_email_template(){
		$data = array(
			'detail'=>$this->input->post('detail'),
			'company_id' =>$this->session->userdata('company_id')
		);
		$this->db->insert("project_email_templates", $data);		
		return true;
	}
	public function update_email_template(){
		$data = array('detail'=>$this->input->post('detail'));
		$this->db->where('id',$this->input->post('email_message_id'));
		$this->db->where('company_id',$this->session->userdata('company_id'));
		$this->db->update("project_email_templates", $data);

		
		return true;
	}
}
?>