<?php



Class Mod_variation extends CI_Model {



    public function get_variation_parts_by_variation_id($variation_id) {

        $company_id = $this->session->userdata('company_id');

        $q = $this->db->query("SELECT * FROM `project_templates` bt WHERE company_id =" . $company_id);

        return $q->result();

    }



    public function getvariationstatusbyvarid($var_id){


        $this->db->select('status');

        $this->db->where('id', $var_id);

        $get = $this->db->get('project_variations');



        return $get->row_array();

    }



    public function getnivariationpartsbyid($var_id){



        $this->db->select('*');

        $this->db->where('variation_id', $var_id);

        $this->db->where('is_including_pc =', '0');

        $this->db->where('status_part', '1');

        $get = $this->db->get('project_variation_parts');
        
        $resultarr= $get->result_array();

        $varnpart = array();



        foreach($resultarr as $key => $vat) {


            $varnpart['variation_id'][$key] = $vat['variation_id'];

            $varnpart['variationp_id'][$key] = $vat['id'];

            $varnpart['stage_id'][$key] = $vat['stage_id'];

            $varnpart['component_id'][$key] = $vat['component_id'];
            
            $varnpart['costing_part_id'][$key] = $vat['costing_part_id'];

            $varnpart['costing_part_name'][$key] = $vat['part_name'];

            $varnpart['costing_uom'][$key] = $vat['component_uom'];

            $varnpart['costing_uc'][$key] = $vat['component_uc'];

            $varnpart['costing_supplier'][$key] = $vat['supplier_id'];

            $varnpart['quantity_type'][$key] = $vat['quantity_type'];

            $varnpart['quantity_formula'][$key] = $vat['formulaqty'];

            $varnpart['formula_text'][$key] = $vat['formulatext'];

            $varnpart['line_cost'][$key] = $vat['linetotal'];

            $varnpart['costing_quantity'][$key] = $vat['updated_quantity'];

            $varnpart['include_in_specification'][$key] = $vat['include_in_specification'];

            $varnpart['client_allowance'][$key] = $vat['allowance_check'];

            $varnpart['margin'][$key] = $vat['margin'];

            $varnpart['line_margin'][$key] = $vat['margin_line'];

            $varnpart['type_status'][$key] = $vat['type_status'];

            $varnpart['is_locked'][$key] = $vat['is_line_locked'];

            $varnpart['costing_part_status'][$key] = $vat['status_part'];





        }



        return $varnpart;

    }



    function lastinsertedvariationid() {



        $table_name = "project_variations";

        $query ="SHOW TABLE STATUS WHERE name='$table_name'";

        $q = $this->db->query($query);

        $row = $q->result();



        return $row[0]->Auto_increment;







    }



    public function get_var_id_by_var_no($var_number) {

        $this->db->select('id');

        $this->db->where('var_number', $var_number);



        $get = $this->db->get('project_variations');



        $resultarr= $get->result_array();

        return $resultarr[0]['id'];

    }



    public function get_varparts_ids_by_var_id($var_id) {

        $query = "SELECT id, costing_part_id  "

            . " FROM project_variation_parts  "

            . " WHERE variation_id = '" . $var_id . "' AND status_part = 1";



        $q = $this->db->query($query);

        return $q->result_array();

    }

    public function getPurchaseOrderCost($project_id){

        $query = "SELECT SUM(line_cost) as total_line_cost FROM project_purchase_order_items WHERE purchase_order_id IN (SELECT id FROM project_purchase_orders WHERE project_id='".$project_id."')";



        $q = $this->db->query($query);

        return $q->result_array();

    }

    public function getaprovedvarbycosid($costing_id, $type) {

        $this-> db  ->select('id')->where('costing_id', $costing_id);

        if($type!='all')

            $this-> db ->where('var_type', $type);

        $get = $this->db->get('project_variations');



        $vars= $get->result_array();

        $resultarr=array();

        foreach ($vars as $key => $val){



            array_push($resultarr, $val['id']);

        }

        return $resultarr;



    }
    public function getaprovedvarbycosid1($costing_id, $type) {

        $this-> db  ->select('id')
            ->where('costing_id', $costing_id);

        if($type!='all')
            $this->db->where('var_type', $type);
        $this->db->where('hide_from_sales_summary', 0);

        $get = $this->db->get('project_variations');

        $vars= $get->result_array();

        $resultarr=array();

        foreach ($vars as $key => $val){



            array_push($resultarr, $val['id']);

        }

        return $resultarr;



    }

}







?>