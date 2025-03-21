<?php
Class Mod_designz extends CI_Model {
    
function filter_my_project($search_design="", $r1min = 0, $r1max = 0, $r2min = 0, $r2max = 0, $r3min = 0, $r3max = 0, $r4min =0, $r4max  =0, $storey1=0, $storey2=0, $sort_order) {

        $filter_str = "";
        
        $filter_supplierz_str = "";
        
        if($search_design!=""){
            $filter_str .=" AND (pd.project_name LIKE '%".$search_design."%')";
            $filter_supplierz_str .=" AND ((SELECT IFNULL(pdbs.name, psd.project_name) 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id) LIKE '%".$search_design."%')";
            
        }
        if ($r1min > 0) {
            $filter_str .=" AND pd.floor_area >='" . $r1min . "'";
            $filter_supplierz_str .=" AND psd.floor_area >='" . $r1min . "'";
        }
        if ($r1max > 0) {
            $filter_str .=" AND pd.floor_area <='" . $r1max . "'";
            $filter_supplierz_str .=" AND psd.floor_area <='" . $r1max . "'";
        }
        if ($r2min > 0) {
            $filter_str .=" AND pd.bedrooms >='" . $r2min . "'";
            $filter_supplierz_str .=" AND psd.bedrooms >='" . $r2min . "'";
        }
        if ($r2max > 0) {
            $filter_str .=" AND pd.bedrooms <='" . $r2max . "'";
            $filter_supplierz_str .=" AND psd.bedrooms <='" . $r2max . "'";
        }

        if ($r3min >= 0) {
            $filter_str .=" AND pd.bathrooms >='" . $r3min . "'";
            $filter_supplierz_str .=" AND psd.bathrooms >='" . $r3min . "'";
        }
        if ($r3max >= 0) {
            $filter_str .=" AND pd.bathrooms <='" . $r3max . "'";
            $filter_supplierz_str .=" AND psd.bathrooms <='" . $r3max . "'";
        }

        if ($r4min >= 0) {
            $filter_str .=" AND pd.garage >='" . $r4min . "'";
            $filter_supplierz_str .=" AND psd.garage >='" . $r4min . "'";
        }
        if ($r4max >= 0) {
            $filter_str .=" AND pd.garage <='" . $r4max . "'";
             $filter_supplierz_str .=" AND psd.garage <='" . $r4max . "'";
        }
       
        if ($storey1 > 0 && $storey2 >0)  {
			$filter_str .=" AND (pd.living_areas BETWEEN '" . $storey1 . "' AND '" . $storey2 . "')";
			$filter_supplierz_str .=" AND (psd.living_areas BETWEEN '" . $storey1 . "' AND '" . $storey2 . "')";
        }
          elseif ($storey1 > 0 ){
               $filter_str .=" AND pd.living_areas >='" . $storey1 . "'";
               $filter_supplierz_str .=" AND psd.living_areas >='" . $storey1 . "'";
          }
          elseif ($storey2 > 0 ){
               $filter_str .=" AND pd.living_areas <='" . $storey2 . "'";
               $filter_supplierz_str .=" AND psd.living_areas <='" . $storey2 . "'";
          }
        
        
        $sort_order_query =  "";
        
        if($sort_order!=""){
            if($sort_order=="Alphabetical"){
              $sort_order_query .=" ORDER BY builderz_designz_name ASC";
            }
            else if($sort_order=="Biggest Size"){
              $sort_order_query .=" ORDER BY floor_area DESC";
            }
            else if($sort_order=="Lowest Size"){
              $sort_order_query .=" ORDER BY floor_area ASC";
            }
            else{
              $sort_order_query =  "";
            }
        }
        $query = $this->db->query('(SELECT 
    pd.designz_id AS designz_id, 
    pd.designz_id AS builderz_designz_id,
    pd.project_name, 
    pd.project_name AS builderz_designz_name,
    pd.floor_area, 
    pd.bedrooms, 
    pd.bathrooms, 
    pd.living_areas, 
    pd.garage, 
    pd.show_at_client_interface,
    pd.status, 
    pd.created_at, 
    "builderz" AS designz_type 
 FROM 
    project_designz pd
 WHERE 1=1 ' . $filter_str . ' AND pd.show_at_client_interface=1 AND company_id ='.$this->session->userdata("company_id").' GROUP BY designz_id
 )

UNION ALL

(SELECT 
    psd.designz_id AS designz_id, 
    psd.project_name, 
    IFNULL((SELECT pdbs.id 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").'), psd.designz_id) AS builderz_designz_id,
    IFNULL((SELECT pdbs.name 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").'), psd.project_name) AS builderz_designz_name,
    psd.floor_area, 
    psd.bedrooms, 
    psd.bathrooms, 
    psd.living_areas, 
    psd.garage, 
    IFNULL((SELECT pdbs.show_at_client_interface 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").'), 0) AS show_at_client_interface,
    psd.status, 
    psd.created_at, 
    "supplierz" AS designz_type 
 FROM 
    project_supplierz_designz psd 
 WHERE psd.available_for_builderz = 1 ' . $filter_supplierz_str . ' and (SELECT IFNULL(pdbs.show_at_client_interface, 0) 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").') = 1 AND (SELECT IFNULL(pdbs.company_id, 0) 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").') ='.$this->session->userdata("company_id").' GROUP BY builderz_designz_id)'.

$sort_order_query);

        $result = $query->result_array();
        return $result;
    
    }
    

    function getDesignzDetails($id, $type){
        if($type == "supplierz"){
           $query = $this->db->query('SELECT 
                      psd.designz_id AS designz_id, 
                      psd.project_name, 
                      IFNULL((SELECT pdbs.id 
                      FROM project_designz_builderz_settings pdbs 
                      WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").'), psd.designz_id) AS builderz_designz_id,
                      IFNULL((SELECT pdbs.name 
                      FROM project_designz_builderz_settings pdbs 
                      WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").'), psd.project_name) AS builderz_designz_name,
                      psd.floor_area, 
                      psd.bedrooms, 
                      psd.bathrooms, 
                      psd.living_areas, 
                      psd.garage, 
                      psd.movies,
                      psd.3D, 
                      IFNULL((SELECT pdbs.show_at_client_interface 
                      FROM project_designz_builderz_settings pdbs 
                      WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").'), 0) AS show_at_client_interface,
                      psd.status, 
                      psd.created_at, 
                      "supplierz" AS designz_type 
                   FROM 
                   project_supplierz_designz psd
                   WHERE psd.available_for_builderz = 1 AND (SELECT IFNULL(pdbs.show_at_client_interface, 0) 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").') = 1 AND designz_id ='.$id.' AND (SELECT IFNULL(pdbs.company_id, 0) 
     FROM project_designz_builderz_settings pdbs 
     WHERE pdbs.designz_id = psd.designz_id AND pdbs.company_id = '.$this->session->userdata("company_id").') ='.$this->session->userdata("company_id"));
        }
        else{
            $query = $this->db->query('SELECT 
    pd.designz_id AS designz_id, 
    pd.designz_id AS builderz_designz_id,
    pd.project_name, 
    pd.project_name AS builderz_designz_name,
    pd.floor_area, 
    pd.bedrooms, 
    pd.bathrooms, 
    pd.living_areas, 
    pd.garage, 
    pd.movies,
    pd.3D, 
    pd.show_at_client_interface,
    pd.status, 
    pd.created_at, 
    "builderz" AS designz_type 
 FROM 
    project_designz pd
 WHERE company_id ='.$this->session->userdata("company_id").' AND designz_id ='.$id.' AND show_at_client_interface = 1'
 );
        }
        if($query->num_rows()>0){
                return $query->row_array();
        }
        else{
              return array(); 
        }
        
    }
}
?>