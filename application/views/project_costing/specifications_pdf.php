<html>
    <head>
        <title><?php echo ucwords(str_replace("_", " ", $type));?> Report</title>
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
                                        <h2 class="card-title"><?php echo ucwords(str_replace("_", " ", $type));?> Report</h2>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="projectCosting">
                                                <?php if($company_info["com_logo"]!=""){ ?>
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
                                                <?php } else{ ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-3 homeworx_logo">
                                                        <img src="<?php echo SURL; ?>assets/img/homeworx_logo.png">
                                                    </div>
                                                </div>
                                                <?php } ?>
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
                                                <!--<div class="row">
                                                    <div class="col-sm-12">
                                	    				<h4 class="pro_address">
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
                                                </div>-->
                                                <div class="form-group label-floating">
                                                    <div class="table-responsive col-md-12">
                                                                 <table id="partstable" class="table sortable_table templates_table partstable" style="border: none !important;">
                                                                   <!--<thead>
                                                                       <tr>
                                                                       <th>Stage</th>
                                                                       <th>Part</th>
                                                                       <th>Comment</th>
                                                                       <th>Component</th>
                                                                       <th>Image</th>
                                                                       </tr>
                                                                   </thead>-->
                                                                   <tbody>
                                                                        
                                                                        <?php 
                                                                        foreach ($stages As $key => $stage) {
                                                                        
                                                        				if(count($stage["costing_parts"])>0){
                                                                        ?>
                                                                       
                                                        	    			<tr>	    				    			
                                                        	    			<td colspan="4" style="background-color: #f56700; color:#fff;">
                                                        	    			    <?php echo $stage["stage_name"];?>
                                                        	    			</td>
                                                        				    </tr>
                                                        				<?php 
                                                        				foreach ($stage["costing_parts"] As $key => $prjprt) {?>
                                                                        <tr>
                                                                           <td>
                                                                               <?php echo $prjprt->costing_part_name; ?>
                                                                           </td>
                                                                            <td>
                                                                               <?php echo $prjprt->comment;?>
                                                                            </td>
                                                                            <td>
                                                                                    <?php echo $prjprt->component_name;?>
                                                                           </td>
                                                                           <td>
                                                                            <?php if($prjprt->component_image!=""){?>
                                                                               <img src="<?php echo base_url('assets/components/thumbnail/'.$prjprt->component_image);?>" style="width: 80px; height: 50px;">
                                                                               <?php } else{ ?>
                                                                               <img src="<?php echo base_url('assets/img/image_placeholder.jpg');?>" style="width: 80px; height: 50px;">
                                                                               <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php } } } ?> 
                                                                    </tbody>
                                                                   </table>
                                                           </div>             
                                        		 </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12 notprint">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                            <a href="javascript:window.print()" class="btn btn-warning btn-fill">Print</a>
                                            <a href="javascript:window.print()" class="btn btn-warning btn-fill">Export To Excel</a>
                                            <a href="javascript:window.print()" class="btn btn-warning btn-fill">Export To PDF</a>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
    </body>
</html>
           
                