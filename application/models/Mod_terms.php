<?php
Class Mod_terms extends CI_Model {
	
	public function get_terms_and_condition(){
		$company_id = $this->session->userdata('user_id');
		$this->db->select("*");
		$this->db->from("project_terms_and_conditions");
		$this->db->where("company_id",$company_id);

		$query = $this->db->get();
		$result = $query->row();
		
		return $result;
	}
	public function add_terms_and_condition(){
		$data = array(
			'detail'=>$this->input->post('detail'),
			'company_id' =>$this->session->userdata('company_id')
		);
		$this->db->insert("project_terms_and_conditions", $data);		
		return true;
	}
	public function update_terms_and_condition(){
		$data = array('detail'=>$this->input->post('detail'));
		$this->db->where('id',$this->input->post('term_id'));
		$this->db->where('company_id',$this->session->userdata('company_id'));
		$this->db->update("project_terms_and_conditions", $data);

		
		return true;
	}
}
?>