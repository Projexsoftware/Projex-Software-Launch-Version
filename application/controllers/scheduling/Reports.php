<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

        public function __construct() {
             parent::__construct();

             $this->stencil->layout('default_layout');

             $this->stencil->slice('header_script');
             $this->stencil->slice('header');
             $this->stencil->slice('sidebar');
             $this->stencil->slice('footer_script');
             $this->stencil->slice('footer');

             $this->load->model("mod_common");
             
             $this->load->model("mod_scheduling");

             $this->mod_common->verify_is_user_login();
             
             $this->mod_common->is_company_page_accessible(134);
             $this->mod_common->is_company_page_accessible(144);

        }
	public function index()
	{
             $this->mod_common->is_company_page_accessible(144);
             $this->stencil->title('Reports');
             
            $data["projects"] = $this->mod_scheduling->get_existing_projects_for_buildz();
                 
    	    $this->stencil->paint('scheduling/reports/project_summary', $data);
	}

    public function project_summary()
	{
	    $this->mod_common->is_company_page_accessible(145);
        $this->stencil->title('Project Summary');
             
        if($this->session->userdata("admin_role_id")==1){
              $data['projects'] = $this->mod_common->get_all_records("scheduling_projects", "*", 0, 0, array("company_id" => $this->session->userdata("company_id"), "status" => 1));
        }
        else{
               $data['projects'] = $this->mod_scheduling->get_all_projects();
        }
             
	    $this->stencil->paint('scheduling/reports/project_summary', $data);
	}
	
	public function daily_summary($current_date="")
	{
	    $this->mod_common->is_company_page_accessible(146);
        $this->stencil->title('Daily Summary');
        if($current_date==""){
          $current_date = date("d/m/Y");
        }
        else{
          $current_date = date("d/m/Y", strtotime(str_replace("-", "/", $current_date)));
        }
        
        $data['from'] = $current_date;
        $data['to'] = $current_date;
        
        $data['projects'] = $this->mod_scheduling->get_all_daily_summary_projects($this->session->userdata("admin_role_id"), $current_date, $current_date);
             
	    $this->stencil->paint('scheduling/reports/daily_summary', $data);
	}
    public function get_daily_summary(){
          $this->mod_common->is_company_page_accessible(146);
          $data['from'] = $from = $this->input->post("start_date");
          $data['to'] = $to = $this->input->post("end_date");
          
          $data['projects'] = $this->mod_scheduling->get_all_daily_summary_projects($this->session->userdata("admin_role_id"), $from, $to);
             
          $this->load->view('scheduling/reports/project_daily_summary', $data);
    }
    public function get_project_summary(){
          $this->mod_common->is_company_page_accessible(144);
          $project_id = $this->input->post("project_id");
          $summary_type = $this->input->post("summary_type");
          $data['project_name'] = get_project_name($project_id);
          if($summary_type=="log"){
            $data['project_id'] = $project_id;
            $data['from'] = $start_date = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post("start_date"))));
            $data['to'] = $end_date = date("Y-m-d", strtotime(str_replace("/", "-", $this->input->post("end_date"))));
            $data['project_logs'] = $this->mod_scheduling->get_project_logs($project_id, $start_date, $end_date);
          }
          else{
            $data['tasks'] = $this->mod_scheduling->get_project_tasks($project_id);
          }
          if($summary_type=="notes"){
           $this->load->view('scheduling/reports/project_notes', $data);
          }
          else if($summary_type=="checklist"){
           $this->load->view('scheduling/reports/project_checklist', $data);
          }
          else if($summary_type=="documents"){
           $data["project_id"] = $project_id;
           $project_info = $this->mod_common->select_single_records("project_projects", array("project_id" => $project_id));
           $this->load->view('scheduling/reports/project_documents', $data);
          }
          else if($summary_type=="images"){
           $this->load->view('scheduling/reports/project_images', $data);
          }
          else if($summary_type=="log"){
            $this->load->view('scheduling/reports/project_log', $data);
          }
          else{
           $this->load->view('scheduling/reports/project_files', $data);
          }

        }

    public function export(){
        
        $project_id = $this->input->post("project_id");
        $summary_type = $this->input->post("summary_type");
        if($summary_type=="log"){
            $data['from'] = $from = $this->input->post("project_start_date");
            $data['to'] = $to = $this->input->post("project_end_date");
            $data['project_logs'] = $this->mod_scheduling->get_project_logs($project_id, $from, $to); 
        }
        else{
             $data['tasks'] = $this->mod_scheduling->get_project_tasks($project_id); 
        }
        $data['project_name'] = get_project_name($project_id);
        if($summary_type=="notes"){
           $html = $this->load->view('scheduling/reports/pdf/project_notes', $data, true); // render the view into HTML
           $pdfFilePath = "project_summary_notes.pdf";
        }
        else if($summary_type=="checklist"){
         $html = $this->load->view('scheduling/reports/pdf/project_checklist', $data, true); // render the view into HTML
         $pdfFilePath = "project_summary_checklist.pdf";
        }
        else if($summary_type=="documents"){
         $data["project_id"] = $project_id;
         $project_info = $this->mod_common->select_single_records("project_projects", array("project_id" => $project_id));
         $data["project_id"] = $project_info['project_id'];
         $html = $this->load->view('scheduling/reports/pdf/project_documents', $data, true); // render the view into HTML
         $pdfFilePath = "project_summary_documents.pdf";
        }
         else if($summary_type=="daily_summary"){
          $data['from'] = $from = $this->input->post("project_start_date");
          $data['to'] = $to = $this->input->post("project_end_date");
          $data['projects'] = $this->mod_scheduling->get_all_daily_summary_projects($this->session->userdata("admin_role_id"), $from, $to);
          $html = $this->load->view('scheduling/reports/pdf/project_daily_summary', $data, true); // render the view into HTML
          $pdfFilePath = "project_daily_summary.pdf";
        }
        else if($summary_type=="images"){
         $html = $this->load->view('scheduling/reports/pdf/project_images', $data, true); // render the view into HTML
         $pdfFilePath = "project_summary_images.pdf";
        }
        else if($summary_type=="log"){
         $html = $this->load->view('scheduling/reports/pdf/project_log', $data, true); // render the view into HTML
         $pdfFilePath = "project_log_report.pdf";
        }
        else{
          $html = $this->load->view('scheduling/reports/pdf/project_files', $data, true); // render the view into HTML
          $pdfFilePath = "project_summary_files.pdf";
        }

        //load mPDF library
        $this->load->library('M_pdf');

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  

        }
        
    public function project_schedule()
	{       
	         $this->mod_common->is_company_page_accessible(147);
             $this->stencil->title('Project Schedule');
             if($this->session->userdata("admin_role_id")==1){
              $data['projects'] = $this->mod_common->get_all_records("scheduling_projects", "*", 0, 0, array("company_id" => $this->session->userdata("company_id"), "status" => 1));
             }
             else{
               $data['projects'] = $this->mod_scheduling->get_all_projects();
             }
	     $this->stencil->paint('scheduling/reports/project_schedule', $data);
	}
	
	public function get_project_schedule(){
	    $this->mod_common->is_company_page_accessible(147);
    $project_id = $this->input->post("project_id");
    $daterange = $this->input->post("daterange");
    
    if($daterange!=""){   
        $daterange = str_replace("%20"," ", $daterange);
        $daterange = explode(" - ", $daterange);
        $start_date = explode("/", $daterange[0]);
        $from_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];
        $min = $start_date[2].", ".(intval($start_date[1])-1).", ".$start_date[0];
        $end_date = explode("/", $daterange[1]);
        $to_date = $end_date[2]."-".$end_date[1]."-".$end_date[0];
        $max = $end_date[2].", ".(intval($end_date[1])-1).", ".$end_date[0];
    }
    
    $startDate = new DateTime($from_date." 12:00:00"); 
    $endDate = new DateTime($to_date." 12:00:00"); 
    $plotBands = array();
    $weekday_iteration = 0;
    // iterate over start to end date 
    while($startDate <= $endDate ){ 
        // find the timestamp value of start date 
        $timestamp = strtotime($startDate->format('Y-m-d H:i:s')); 
  
        // find out the day for timestamp and increase particular day 
        $weekDay = date('l', $timestamp); 
        if($weekDay == "Saturday"){
           
                $saturdayDate = new DateTime(date('Y-m-d H:i:s', $timestamp));
                $sundayDate = $saturdayDate->modify('+2 days')->format('Y-m-d H:i:s');
                
              
                    $plotBands[]= array(
                        "color" => "#dedede",
                        "from" => $timestamp*1000,
                        "to" => strtotime($sundayDate)*1000
                        );
        }
        else if($weekday_iteration==0 && $weekDay == "Sunday"){
                $sundayDate1 = new DateTime(date("Y-m-d", $timestamp));
                $sundayDate = $sundayDate1->modify('+1 day')->format('Y-m-d');
                    $plotBands[]= array(
                        "color" => "#dedede",
                        "from" => $timestamp*1000,
                        "to" => strtotime($sundayDate)*1000
                        );
        }
        // increase startDate by 1 
        $startDate->modify('+1 day');
        $weekday_iteration++;
    } 
    
    $query = $this->db->query("SELECT pi.stage_id, pi.stages_priority, pi.id, s.stage_name as stage_name FROM project_scheduling_items pi INNER JOIN project_stages s ON s.stage_id = pi.stage_id WHERE pi.project_id ='".$project_id."' GROUP BY pi.stage_id ORDER BY pi.stages_priority ASC, pi.id DESC");
     
    $stages = $query->result_array();
    
    $stages_array = $query->result_array();
    
    $str = "";
    $stage_index =1;
    $tasks = "";
    $listItems = array();
    $i = 0;
    foreach($stages as $stage){
    $query = $this->db->query("SELECT t.name as task_name, pi.* FROM project_scheduling_items pi INNER JOIN project_scheduling_tasks t ON t.id = pi.task_id WHERE pi.project_id ='".$project_id."' AND pi.stage_id = '".$stage['stage_id']."' AND (pi.start_date >= '".$from_date."' AND pi.end_date <= '".$to_date."') ORDER BY pi.priority ASC");
    $items = $query->result_array();
    if(count($items)>0){
    for($j=0;$j<count($items);$j++){
    if($items[$j]["status"]==0){
    $item_color = "#f44336";
    }else if($items[$j]["status"]==1){ 
    $item_color = "#ff9800";
    }else{ 
    $item_color = "#4caf50";
    } 
    $item_start_date = explode("-", $items[$j]['start_date']);
    $item_end_date = explode("-", $items[$j]['end_date']);
    $start_date = $item_start_date[0]."-".(intval($item_start_date[1])-1)."-".$item_start_date[2];
    $end_date = $item_end_date[0]."-".(intval($item_end_date[1])-1)."-".$item_end_date[2];
    $who = get_user_info($items[$j]['assign_to_user']);
    $task_name = $items[$j]["task_name"];
    $listItems[] = array(
        "task_name" => $task_name,
        "current" => $i,
        );
        $listItems[$i]["tasks"][0] = array(
            "assignedTo" => trim($who)==""?'':$who,
            "start_year" => $item_start_date[0],
            "start_month" => intval($item_start_date[1])-1,
            "start_day" => $item_start_date[2],
            "end_year" => $item_end_date[0],
            "end_month" => intval($item_end_date[1])-1,
            "end_day" => $item_end_date[2],
            "color" => $item_color
            );
    $i++;
    }
    }
    
    }
    
    $result = array('items' => $listItems, 'min' => $min, 'max' => $max, 'plotBands' => $plotBands, 'project_name' => get_scheduling_project_name($project_id));
    
    echo json_encode($result);
    
  }
  
  public function send_project_schedule(){
      $this->mod_common->is_company_page_accessible(148);
      $this->stencil->title('Send Project Schedule Report');
      $data['users'] = $this->mod_common->get_all_records("project_users","*", 0, 0, array("role_id !=" => 1, "user_id !=" => $this->session->userdata("user_id"), "company_id" => $this->session->userdata("company_id"), "user_status" => 1), "user_id");
      $this->stencil->paint('scheduling/reports/send_project_schedule', $data);
  }
  
  public function send_project_schedule_report_process(){
      
    $this->mod_common->is_company_page_accessible(148);
    if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != "") {
						
						$projects_folder_path = './assets/scheduling/project_schedule_uploads/';


						$config['upload_path'] = $projects_folder_path;
						$config['allowed_types'] = 'pdf';
						$config['overwrite'] = false;
						$config['encrypt_name'] = false;
						

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('attachment')) {
							$error_file_arr = array('error' => $this->upload->display_errors());
							print_r($error_file_arr);exit;
							
						} else {

							$data_image_upload = array('upload_image_data' => $this->upload->data());
							$filename = $data_image_upload['upload_image_data']['file_name'];
							$full_path = $data_image_upload['upload_image_data']['full_path'];
							
                            
							
						}
					}
     $subject = $this->input->post("subject");
     $message = $this->input->post("description");
     $to = implode(", ", $this->input->post("to"));
     
     $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'mail.wizard.net.nz',
        'smtp_port' => 587,
        'smtp_user' => 'info@wizard.net.nz', // change it to yours
        'smtp_pass' => '{SGwI8a~GDMJ', // change it to yours
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'wordwrap' => TRUE
     );
     $this->load->library('email', $config);
     $this->email->set_newline("\r\n"); 
     $this->email->set_mailtype("html");
     $this->email->to($to);
     $this->email->CC('gordon@homeworx.co.nz');
     $this->email->from('info@wizard.net.nz');
     $this->email->subject($subject);
     $this->email->message($message);
     $this->email->attach($_SERVER["DOCUMENT_ROOT"].'/projex_software/assets/scheduling/project_schedule_uploads/'.$filename);
     $this->email->send();
     $this->session->set_flashdata('ok_message', 'Project Schedule Report has been sent successfully!'); 
     redirect(SCURL."reports/send_project_schedule");
  }
}
