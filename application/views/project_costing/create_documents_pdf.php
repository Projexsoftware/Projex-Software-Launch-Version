<html>
    <head>
        <title><?php echo ucwords(str_replace("_", " ", $filename));?> Report</title>
        <style>
               html, body {
                    margin: 0;
                    padding: 0;
                    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                    font-size: 14px;
                }
              .col-md-offset-3 {
                margin-left: 25%;
               }
               .col-md-6 {
                 width: 50%;
               }
               .panel-title, .card-title{
                   text-align:center;
               }
               th{
                   font-weight:bold;
               }
               td, th {
            		padding: 8px;
                line-height: 1.42857143;
                vertical-align: top;
                border-top: 1px solid #ddd;
                text-align:left;
            	}
              .templates_table .form-control{
                  background-image: none;
                  border:1px solid #ccc!important;
                  padding:5px;
                  margin-top:12px;
              }
             .form-group.is-focused .templates_table .form-control{
                  background-image: none!important;
              }
              .part-form-control{
                  width:200px;
              }
              .uom-form-control, .uc-form-control{
                width:100px;
              }
              .no-padding{
                  padding:0px!important;
              }
              .comments, .status, .include, .boom_mobile{
                display:none;
              }
              .table_project_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0;font-weight:bold;}
              .homeworx_logo{
                  /*margin-top:25px;*/
                  text-align:center;
                  
              }
              .homeworx_logo img{
                width: auto!important;
                height: auto;
               }
              
              #partstable{
                  width:100%;
              }
              
              .table tr td {
                    //border: none !important;
                    padding:10px !important;
                    padding-top: 15px !important;
                    vertical-align: top;
                    text-align:left !important;
                	
                }
                .col-md-6{
                    float:left;
                    width:48%;
                }
               .tab_info tr td{
                  background: none !important;
                  font-size: 14px;
                  border: none !important;
                  padding-left:40px;
                  padding-top:0px!important;
                }
                .tab_info tr td h5{
                  background: none !important;
                  font-size: 17px !important;
                  padding-left:40px;
                  padding-bottom:0px!important;
                  padding-top:0px!important;
                }
              
              @media print {
                @page { size: landscape; }
            	.notprint{
                    display: none !important;
                }
              }
          </style>
    </head>
    <body>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-content">
                                        <h2 class="card-title"><?php echo ucwords(str_replace("_", " ", $filename));?> Report</h2>
                                       <div class="row">
                                           <div class="col-md-6">
                                            <img style="width:100%;height:100px;" src="<?php echo trim(SURL).'/assets/company/'.trim($company_info["com_logo"]);?>">
                                          </div>
                                          <div class="col-md-6">
                                           <table class="table tab_info" align="right">
                                             <tr>
                                                <td><h4><?php echo $company_info["com_name"];?></h4></td>
                                             </tr>
                                             <tr>
                                               <td><p><img style="width:16px;" src="<?php echo SURL.'/assets/icons/grid-world.png';?>"> <?php echo $company_info["com_website"];?></p></td>
                                             </tr>
                                              <tr>
                                               <td><p><img style="width:16px;" src="<?php echo SURL.'/assets/icons/envelope.png';?>"> <?php echo $company_info["com_email"];?></p></td>
                                             </tr>
                                              <tr>
                                               <td><p><img style="width:16px;" src="<?php echo SURL.'/assets/icons/telephone-handle-silhouette.png';?>"> <?php echo $company_info["com_phone_no"];?></p></td>
                                             </tr>
                                           </table>
                                          </div>
                                       </div>
                                	    <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="table_project_name">
                                	    				Project Name:
                                	    				<?php echo $project_name['project_title']; ?>
                                	    				<br/>
                                	    				Project Address:
                                	    				<?php 
                                	    					echo $project_info['street_pobox'] . ' ' .
                                	    					$project_info['suburb'] . ', ' .
                                	    					$project_info['project_address_city'] . ', ' .
                                							$project_info['project_address_state'] . ', ' .
                                							$project_info['project_address_country'] . ', ' .
                                							$project_info['project_zip'];
                                	    				?>
                                                        </h4>
                                                    </div>
                                                </div>	    				
                                	   <div class="col-md-12">
                                        <table class="table table-bordered table-striped table-hover print_table" style="border: none !important;">
                            				<tr>	    				    			
                            	    			<td style="background-color: #f56700; color:#fff;">
                            	    			    Stage
                            	    			</td>
                            	                <td style="background-color: #f56700; color:#fff;">Part</td>
                            	    			<td style="background-color: #f56700; color:#fff;">Component</td>
                            	    			<?php if($type!="checklist"){ ?>
                            	    			<td style="background-color: #f56700; color:#fff;">Document</td>
                            	    			<?php } else{ ?>
                            	    			<td style="background-color: #f56700; color:#fff;">Checklist</td>
                            	    			<?php } ?>
                            				</tr>
                            	    		<?php foreach ($prjprts as $key => $prjprt): 
                            	    	
                            	    		?>
                            	    			<tr>
                            	    			    <td>
                            	    			        <?php echo $prjprt->stage_name;?>
                            	    			    </td>	    				
                            	    				<td>
                            	    					<?php echo $prjprt->costing_part_name; ?>
                            	    				</td>	    				
                            	    				<td>
                            	    					<?php echo $prjprt->component_name;?>
                            	    				</td>
                            	    				<td>
                            	    				    <?php if($type=="checklist"){ ?>
                                                           
                                                           <?php 
                                                                            $checklists = get_checklist_items_for_builders($prjprt->component_id);
                                                                            $existing_checklist = "";
                                                                            if(count($checklists)>0){
                                                                            ?>
                                                                            <ul style="margin-left:25px;">
                                                                            <?php
                                                                                foreach($checklists as $checklist){ 
                                                                                $existing_checklist .=$checklist['checklist'].",";
                                                                              ?>
                                                                                  <li checklist="<?php echo $checklist['checklist'];?>"><?php echo $checklist['checklist'];?></li>
                                                                              <?php } ?>
                                                                              </ul>
                                                                              <?php
                                                                               }  
                             
                            	    				    
                            	    				    } else { 
                            	    				         $component_document = is_component_have_documents($prjprt->component_id, $type);
                            	    				         
                            	    				         if($type=="specification" && $component_document["specification"]!=""){ ?>
                                                            
                                                            <a target="_Blank" href="<?php echo SURL;?>assets/component_documents/specification/<?php echo $component_document["specification"];?>"><?php echo $component_document["specification"];?></a>
                                                            
                                                           <?php } else if($type=="warranty" && $component_document["warranty"]!=""){ ?>
                                                               <a target="_Blank" href="<?php echo SURL;?>assets/component_documents/warranty/<?php echo $component_document["warranty"];?>"><?php echo $component_document["warranty"];?></a>
                                                           
                                                           <?php } else if($type=="installation" && $component_document["installation"]!=""){ ?>
                                                               <a target="_Blank" href="<?php echo SURL;?>assets/component_documents/installation/<?php echo $component_document["installation"];?>"><?php echo $component_document["installation"];?></a>
                                                           
                                                           <?php } else if($type=="maintenance" && $component_document["maintenance"]!=""){ ?>
                                                               <a target="_Blank" href="<?php echo SURL;?>assets/component_documents/maintenance/<?php echo $component_document["maintenance"];?>"><?php echo $component_document["maintenance"];?></a>
                                                            <?php 
                                                           }
                                                           } ?>
                                                        </td> 
                            	    			</tr>
                            				<?php endforeach; ?>
                            	    	</table>
                                        </div>
		                            </div>
                            </div>    
                        </div>
                    </div>