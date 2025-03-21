<div class="sidebar" data-active-color="orange" data-background-color="black" data-image="<?php echo IMG;?>sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
            <div class="logo">
                <a href="<?php echo SURL;?>dashboard" class="simple-text logo-mini">
                    PS
                </a>
                <a href="<?php echo SURL;?>dashboard" class="simple-text logo-small">
                    Project Software
                </a>
            </div>
			<?php 
			$controller1 = $this->uri->segment(1);
			$controller2 = $this->uri->segment(2);
			if($controller2==""){
				$main_controller = $this->uri->segment(1);
			}
			else{
				$main_controller = $controller1."/".$controller2;
			}
			?>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src="<?php echo PROFILE_IMG.$this->session->userdata("avatar");?>" />
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>
                                <?php echo $this->session->userdata("firstname")." ".$this->session->userdata("lastname");?>
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="clearfix"></div>
                        <div <?php if($controller1=="profile" || $controller1=="change_password" || $controller1=="xero_settings"){ ?> class="collapse in" <?php } else { ?> class="collapse" <?php } ?>id="collapseExample">
                            <ul class="nav">
                                <li <?php if($controller1=="profile"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>profile">
                                        <span class="sidebar-mini">MP</span>
                                        <span class="sidebar-normal">My Profile</span>
                                    </a>
                                </li>
                                <li <?php if($controller1=="change_password"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>change_password">
                                        <span class="sidebar-mini">CP</span>
                                        <span class="sidebar-normal">Change Password</span>
                                    </a>
                                </li>
                                <?php
                                   if(in_array(124, $this->session->userdata("permissions"))) {
                                ?>
                                <li <?php if($controller1=="xero_settings"){ ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>xero_settings">
                                        <span class="sidebar-mini">XS</span>
                                        <span class="sidebar-normal">Xero Settings</span>
                                    </a>
                                </li>
                                <?php } ?>
								 <li>
                                    <a href="<?php echo SURL;?>logout">
                                        <span class="sidebar-mini">L</span>
                                        <span class="sidebar-normal">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">
                    <?php
                      if(in_array(125, $this->session->userdata("permissions"))) {
                      ?>
                    <li <?php if($main_controller=="dashboard"){ ?> class="active" <?php } ?>>
                        <a href="<?php echo SURL;?>dashboard">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
					
					<!-- Project Costing -->
                      <?php
                      } ?>
                        
                            
                      
					     <li <?php if($main_controller=="project_costing" || $main_controller=="confirmed_estimate" || $main_controller=="project_variations"){ ?> class="active" <?php } ?>>
                        <a data-toggle="collapse" href="#builderz">
                            <i class="material-icons">android</i>
                            <p>Builderz
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="project_costing" || $controller1=="confirmed_estimate" || $controller1=="project_variations"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="builderz">
                            
                                   <ul class="nav">
                                                <?php
                                                  if(in_array(1, $this->session->userdata("permissions"))) {
                                                ?>
                                                <li <?php if($main_controller=="project_costing" || ( $main_controller=="project_costing/add_project_costing") || $main_controller=="project_costing/edit_project_costing"){ ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SURL;?>project_costing">
                                                       <span class="sidebar-mini">PC</span>
                                                       <span class="sidebar-normal">Project Costing</span>
                                                    </a>
                                                </li>
                                                <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(in_array(110, $this->session->userdata("permissions"))) {
                                                ?>
                                                <li <?php if($main_controller=="confirmed_estimate" || ($main_controller=="confirmed_estimate/add_confirmed_estimate") || $main_controller=="confirmed_estimate/view_confirmed_estimate"){ ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SURL;?>confirmed_estimate">
                                                       <span class="sidebar-mini">CE</span>
                                                       <span class="sidebar-normal">Confirmed Estimate</span>
                                                    </a>
                                                </li>
                                                <?php
                                                  }
                                                ?>
                                                <?php
                                                  if(in_array(5, $this->session->userdata("permissions"))) {
                                                ?>
                                                <li <?php if($main_controller=="project_variations" || ($main_controller=="project_variations/add_variation") || $main_controller=="project_variations/edit_variation"){ ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SURL;?>project_variations">
                                                       <span class="sidebar-mini">MV</span>
                                                       <span class="sidebar-normal">Variations</span>
                                                    </a>
                                                </li>
                                                <?php
                                                  }
                                                  
                                                ?>
                                        </ul>
                                   
                        </div>
                        </li>
                     
                    
                    <!-- Purchase Orders -->
                    <?php
                      if(in_array(11, $this->session->userdata("permissions"))) {
                    ?>
                        <li <?php if($main_controller=="purchase_orders"){ ?> class="active" <?php } ?>>
                            <a data-toggle="collapse" href="#purchase_orders">
                                <i class="material-icons">shopping_cart</i>
                                <p>Purchase Orders
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div <?php if($controller1=="purchase_orders"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="purchase_orders">
                                <ul class="nav">
                                        <?php
                                          if(in_array(11, $this->session->userdata("permissions"))) {
                                        ?>
                                        <li <?php if($main_controller=="purchase_orders" || ($controller1=="purchase_orders" && $controller2!="add_purchase_order") || $main_controller=="purchase_orders/edit_purchase_order"){ ?> class="active" <?php } ?>>
                                            <a href="<?php echo SURL;?>purchase_orders">
                                               <span class="sidebar-mini">MPO</span>
                                               <span class="sidebar-normal">Manage Purchase Orders</span>
                                            </a>
                                        </li>
                                        <?php
                                          }
                                          if(in_array(13, $this->session->userdata("permissions"))) {
                                        ?>
                                        <li <?php if($main_controller=="purchase_orders/add_purchase_order"){ ?> class="active" <?php } ?>>
                                            <a href="<?php echo SURL;?>purchase_orders/add_purchase_order">
                                               <span class="sidebar-mini">APO</span>
                                               <span class="sidebar-normal">Add Purchase Order</span>
                                            </a>
                                        </li>
                                        <?php
                                          }
                                        ?>
                                </ul>
                            </div>
                        </li>
                    <?php } ?>
                    
                    <!-- Supplier Invoices -->
                     <?php
                      if(in_array(18, $this->session->userdata("permissions"))) {
                      ?>
                    <li <?php if($main_controller=='supplier_invoices' || $main_controller=='supplier_credits'){ ?> class="active" <?php } ?>>
        <a data-toggle="collapse" href="#supplier_invoices">
                            <i class="material-icons">receipt</i>
                            <p>Supplier Invoices
                                <b class="caret"></b>
                            </p>
        </a>
        <div <?php if($controller1=="supplier_invoices" || $controller1 == "supplier_credits"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="supplier_invoices">
                            <ul class="nav">
                                    <?php
                                      if(in_array(19, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplier_invoices" || ($controller1=="supplier_invoices" && $controller2!="add_invoice") || $main_controller=="supplier_invoices/viewinvoice"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplier_invoices">
                                           <span class="sidebar-mini">MSI</span>
                                           <span class="sidebar-normal">Manage Supplier Invoices</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(20, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplier_invoices/add_invoice"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplier_invoices/add_invoice">
                                           <span class="sidebar-mini">ASI</span>
                                           <span class="sidebar-normal">Add Supplier Invoice</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      $xero_credentials = get_xero_credentials();
                                      if(count($xero_credentials)>0){
                                     if(in_array(24, $this->session->userdata("permissions"))) {
                                    ?>
                                    <?php
                                      if(in_array(25, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplier_credits" || ($controller1=="supplier_credits" && $controller2!="create_supplier_credit") || $main_controller=="supplier_invoices/viewinvoice"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplier_credits">
                                           <span class="sidebar-mini">MSC</span>
                                           <span class="sidebar-normal">Manage Supplier Credits</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(26, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplier_credits/create_supplier_credit"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplier_credits/create_supplier_credit">
                                           <span class="sidebar-mini">CSC</span>
                                           <span class="sidebar-normal">Create Supplier Credit</span>
                                        </a>
                                    </li>
                                    <?php
                                      } } }
                                    ?>
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                    
                    <!-- Sales Invoices -->
                    <?php
                      if(in_array(30, $this->session->userdata("permissions"))) {
                      ?>
                    <li <?php if($main_controller=='sales_invoices' || $main_controller=='sales_credits_notes'){ ?> class="active" <?php } ?>>
        <a data-toggle="collapse" href="#sales_invoices">
                            <i class="material-icons">summarize</i>
                            <p>Sales Invoices
                                <b class="caret"></b>
                            </p>
        </a>
        <div <?php if($controller1=="sales_invoices" || $controller1=="sales_credits_notes"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="sales_invoices">
                            <ul class="nav">
                                    <?php
                                    if(in_array(31, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="sales_invoices/project_sales_summary"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>sales_invoices/project_sales_summary">
                                           <span class="sidebar-mini">PSS</span>
                                           <span class="sidebar-normal">Project Sales Summary</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(32, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="sales_invoices" || ($controller1=="sales_invoices" && $controller2=="") || $main_controller=="sales_invoices/viewsalesinvoice"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>sales_invoices">
                                           <span class="sidebar-mini">MSI</span>
                                           <span class="sidebar-normal">Manage Sales Invoices</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(37, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if(($controller1=="sales_invoices" && $controller2=="manage_csv_files") || $main_controller=="sales_invoices/viewcsv"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>sales_invoices/manage_csv_files">
                                           <span class="sidebar-mini">MCF</span>
                                           <span class="sidebar-normal">Manage CSV Files</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      $xero_credentials = get_xero_credentials();
                                      if(count($xero_credentials)>0){
                                     if(in_array(36, $this->session->userdata("permissions"))) {
                                    ?>
                                    <?php
                                      if(in_array(38, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if(($main_controller=="sales_credits_notes" && $controller2="") || $main_controller=="sales_credits_notes/viewcreditnotes"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>sales_credits_notes">
                                           <span class="sidebar-mini">MSC</span>
                                           <span class="sidebar-normal">Manage Sales Credits</span>
                                        </a>
                                    </li>
                                    <?php
                                      } } }
                                    ?>
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                    
                    <?php
                     if(in_array(42, $this->session->userdata("permissions"))) {
                    ?>
                        <li <?php if($main_controller=="cash_transfers"){ ?> class="active" <?php } ?>>
                        <a data-toggle="collapse" href="#cash_transfersmenu">
                            <i class="material-icons">money</i>
                            <p>Cash Transfers
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="cash_transfers"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="cash_transfersmenu">
                            <ul class="nav">
                                    <?php
                                      if(in_array(43, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="cash_transfers" || ($controller1=="cash_transfers" && $controller2!="add_cash_transfer") || $main_controller=="cash_transfers/edit_cash_transfer"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>cash_transfers">
                                           <span class="sidebar-mini">MCT</span>
                                           <span class="sidebar-normal">Manage Cash Transfers</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(44, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="cash_transfers/add_cash_transfer"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>cash_transfers/add_cash_transfer">
                                           <span class="sidebar-mini">ACT</span>
                                           <span class="sidebar-normal">Add Cash Transfer</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                    ?>
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                    
                    <!-- Reports -->
                    <?php
                      if(in_array(47, $this->session->userdata("permissions"))) {
                      ?>
                    <li <?php if($main_controller=='reports'){ ?> class="active" <?php } ?>>
        <a data-toggle="collapse" href="#reportsMenu">
                            <i class="material-icons">report</i>
                            <p>Reports
                                <b class="caret"></b>
                            </p>
        </a>
        <div <?php if($controller2=="project_report" || $controller2=="project_summary" || $controller2=="component_items_unordered" || $controller2=="tracking" || $controller2=="add_tracking" || $controller2=="edit_tracking_report" || $controller2=="tracking_report" || $controller2=="project_uninvoiced_component" || $controller2=="updated_specifications_report" || $controller2=="project_suppliers_report" || $controller2=="updated_project_costing_report" || $controller2=="workInProgress" || $controller2=="budget_vs_actual" || $controller2=="project_transactions_report" || $controller2=="project_unordered_items"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="reportsMenu">
                            <ul class="nav">
                                   <?php
                                      if(in_array(48, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="reports/project_report"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/project_report">
                                           <span class="sidebar-mini">PR</span>
                                           <span class="sidebar-normal">Project Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/project_summary"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/project_summary">
                                           <span class="sidebar-mini">PS</span>
                                           <span class="sidebar-normal">Project Summary</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/workInProgress"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/workInProgress">
                                           <span class="sidebar-mini">WIPR</span>
                                           <span class="sidebar-normal">Work In Progress Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/budget_vs_actual"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/budget_vs_actual">
                                           <span class="sidebar-mini">BVAR</span>
                                           <span class="sidebar-normal">Budget VS Actual Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/project_transactions_report"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/project_transactions_report">
                                           <span class="sidebar-mini">PTR</span>
                                           <span class="sidebar-normal">Project Transactions Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/project_unordered_items"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/project_unordered_items">
                                           <span class="sidebar-mini">WIPR</span>
                                           <span class="sidebar-normal">Project Unordered Items Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/component_items_unordered"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/component_items_unordered">
                                           <span class="sidebar-mini">CIU</span>
                                           <span class="sidebar-normal">Component Items Unordered</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/project_uninvoiced_component"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/project_uninvoiced_component">
                                           <span class="sidebar-mini">UCR</span>
                                           <span class="sidebar-normal">Uninvoiced Components Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/project_suppliers_report"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/project_suppliers_report">
                                           <span class="sidebar-mini">PSR</span>
                                           <span class="sidebar-normal">Project Suppliers Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/updated_project_costing_report"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/updated_project_costing_report">
                                           <span class="sidebar-mini">UPCR</span>
                                           <span class="sidebar-normal">Updated Project Costing Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if($main_controller=="reports/updated_specifications_report"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/updated_specifications_report">
                                           <span class="sidebar-mini">USR</span>
                                           <span class="sidebar-normal">Updated Specifications Report</span>
                                        </a>
                                    </li>
                                    
                                    <li <?php if(($main_controller=="reports/tracking") || ($main_controller=="reports/add_tracking") || ($main_controller=="reports/edit_tracking_report") || ($main_controller=="reports/tracking_report")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>reports/tracking">
                                           <span class="sidebar-mini">TR</span>
                                           <span class="sidebar-normal">Tracking Report</span>
                                        </a>
                                    </li>
                                    
                                    <?php } ?>
                                    
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                    
					<li <?php if($main_controller=="manage"){ ?> class="active" <?php } ?>>
                        <a data-toggle="collapse" href="#manage">
                            <i class="material-icons">edit</i>
                            <p>Manage
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="manage" || $controller1=="price_book_requests"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="manage">
                            <ul class="nav">
                                    <?php
                                      if(in_array(52, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="manage/clients" || $main_controller=="manage/add_client" || $main_controller=="manage/edit_client" || $main_controller=="manage/view_client"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/clients">
                                           <span class="sidebar-mini">MC</span>
                                           <span class="sidebar-normal">Manage Clients</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(57, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="manage/projects" || $main_controller=="manage/add_project" || $main_controller=="manage/edit_project"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/projects">
                                           <span class="sidebar-mini">MP</span>
                                           <span class="sidebar-normal">Manage Projects</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(63, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="manage/suppliers" || $main_controller=="manage/add_supplier" || $main_controller=="manage/edit_supplier"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/suppliers">
                                           <span class="sidebar-mini">MS</span>
                                           <span class="sidebar-normal">Manage Suppliers</span>
                                        </a>
                                    </li>
                                    <?php
                                      } 
                                      if(in_array(120, $this->session->userdata("permissions"))) {
                                      ?>
                                      <li <?php if($main_controller=="manage/supplier_components"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/supplier_components">
                                           <span class="sidebar-mini">SC</span>
                                           <span class="sidebar-normal">Supplier Components</span>
                                        </a>
                                      </li>
                                      <?php
                                      } 
                                      if(in_array(121, $this->session->userdata("permissions"))) {
                                      ?>
                                      <li <?php if($main_controller=="price_book_requests"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>price_book_requests">
                                           <span class="sidebar-mini">PBR</span>
                                           <span class="sidebar-normal">Price Book Requests</span>
                                        </a>
                                      </li>
                                    <?php } if(in_array(68, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="manage/components" || $main_controller=="manage/add_component" || $main_controller=="manage/edit_component"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/components">
                                           <span class="sidebar-mini">MC</span>
                                           <span class="sidebar-normal">Manage Components</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <li <?php if($main_controller=="setup"){ ?> class="active" <?php } ?>>
                        <a data-toggle="collapse" href="#setup">
                            <i class="material-icons">settings</i>
                            <p>Setup
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="setup"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="setup">
                            <ul class="nav">
                                    <?php
                                      if(in_array(73, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="setup/stages" || $main_controller=="setup/add_stage" || $main_controller=="setup/edit_stage"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>setup/stages">
                                           <span class="sidebar-mini">SS</span>
                                           <span class="sidebar-normal">Setup Stages</span>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                      if(in_array(78, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="setup/takeoffdata" || $main_controller=="setup/add_takeoffdata" || $main_controller=="setup/edit_takeoffdata"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>setup/takeoffdata">
                                           <span class="sidebar-mini">TOD</span>
                                           <span class="sidebar-normal">Setup Take off Data</span>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                      if(in_array(83, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="setup/templates" || $main_controller=="setup/add_template" || $main_controller=="setup/edit_template"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>setup/templates">
                                           <span class="sidebar-mini">ST</span>
                                           <span class="sidebar-normal">Setup Templates</span>
                                        </a>
                                    </li>
                                    <?php
                                     }
                                     if(in_array(113, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="setup/template_store"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>setup/template_store">
                                           <span class="sidebar-mini">TS</span>
                                           <span class="sidebar-normal">Template Store</span>
                                        </a>
                                    </li>
                                    <?php
                                     }
                                     if(in_array(114, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="setup/request_a_template"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>setup/request_a_template">
                                           <span class="sidebar-mini">RAT</span>
                                           <span class="sidebar-normal">Request a Template</span>
                                        </a>
                                    </li>
                                    <?php
                                     }
                                    if(in_array(88, $this->session->userdata("permissions"))) {
                                    ?>
                                        <li <?php if($main_controller=="setup/users" || $main_controller=="setup/add_user" || $main_controller=="setup/edit_user"){ ?> class="active" <?php } ?>>
                                            <a href="<?php echo SURL;?>setup/users">
                                               <span class="sidebar-mini">SU</span>
                                               <span class="sidebar-normal">Setup Users</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(in_array(93, $this->session->userdata("permissions"))) {?>
                                        <li <?php if($main_controller=="setup/roles" || $main_controller=="setup/add_role" || $main_controller=="setup/edit_role"){ ?> class="active" <?php } ?>>
                                            <a href="<?php echo SURL;?>setup/roles">
                                               <span class="sidebar-mini">SR</span>
                                               <span class="sidebar-normal">Setup Roles</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                            </ul>
                        </div>
                    </li>
                    
                    <!-- Manage Timesheets-->
                      <?php
                      if(in_array(105, $this->session->userdata("permissions"))) {
                      ?>
                      
                      <li <?php if($main_controller=="timesheets"){ ?> class="active" <?php } ?>>
                                        <a data-toggle="collapse" href="#timesheets">
                                            <i class="material-icons">schedule</i>
                                            <p>Timesheets
                                                <b class="caret"></b>
                                            </p>
                                        </a>
                                        <div <?php if($controller1=="timesheets"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="timesheets">
                                            <ul class="nav">
                                                    <?php
                                                      if(in_array(106, $this->session->userdata("permissions"))) {
                                                    ?>
                                                        <li <?php if($main_controller=="timesheets" || ($controller1=="timesheets")){ ?> class="active" <?php } ?>>
                                                            <a href="<?php echo SURL;?>timesheets">
                                                               <span class="sidebar-mini">MTS</span>
                                                               <span class="sidebar-normal">Manage Timesheets</span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                            </ul>
                                        </div>
                                    </li>
                       <?php } ?>
                       
                        <!-- Supplierz -->
                         <li <?php if($main_controller=="supplierz"){ ?> class="active" <?php } ?>>
                        <a data-toggle="collapse" href="#supplierz">
                            <i class="material-icons">airport_shuttle</i>
                            <p>Supplierz
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="supplierz"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="supplierz">
                            <ul class="nav">
                                    <?php
                                      if(in_array(114, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz" || ($controller1=="supplierz" && $controller2=="price_books") || $main_controller=="supplierz/add_price_book"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/price_books">
                                           <span class="sidebar-mini">PB</span>
                                           <span class="sidebar-normal">Price Books</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(119, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/price_book_requests"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/price_book_requests">
                                           <span class="sidebar-mini">PBR</span>
                                           <span class="sidebar-normal">Price Book Requests <sup class="badge badge-success"><?php echo get_price_book_requests_count($this->session->userdata('company_id'));?></sup></span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(119, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/manage_allocate"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_allocate">
                                           <span class="sidebar-mini">PBR</span>
                                           <span class="sidebar-normal">Allocate Price Book</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(122, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/manage_confirm_estimate_requests"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_confirm_estimate_requests">
                                           <span class="sidebar-mini">CER</span>
                                           <span class="sidebar-normal">Confirm Estimate Requests <sup class="badge badge-success"><?php echo get_confirm_estimate_requests_count($this->session->userdata('company_id'));?></sup></span>
                                        </a>
                                    </li>
                                    <li <?php if($main_controller=="supplierz/returned_confirm_estimate"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/returned_confirm_estimate">
                                           <span class="sidebar-mini">RCE</span>
                                           <span class="sidebar-normal">Returned Confirm Estimate</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(123, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/manage_component_orders"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_component_orders">
                                           <span class="sidebar-mini">CO</span>
                                           <span class="sidebar-normal">Component Orders <sup class="badge badge-success"><?php echo get_component_orders_count($this->session->userdata('company_id'));?></sup></span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(129, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/manage_templates" || $main_controller=="supplierz/add_template" || $main_controller=="supplierz/edit_template"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_templates">
                                           <span class="sidebar-mini">MT</span>
                                           <span class="sidebar-normal">Templates</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(130, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/manage_template_requests"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_template_requests">
                                           <span class="sidebar-mini">MTR</span>
                                           <span class="sidebar-normal">Template Requests <sup class="badge badge-success"><?php echo get_template_requests_count($this->session->userdata('company_id'));?></sup></span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                    ?>
                            </ul>
                        </div>
                    </li>
                    
                      <!-- Manage Tickets -->
                      <?php
                      if(in_array(97, $this->session->userdata("permissions"))) {
                      ?>
                      <li <?php if($main_controller=="tickets"){ ?> class="active" <?php } ?>>
                                        <a data-toggle="collapse" href="#ticket">
                                            <i class="material-icons">help</i>
                                            <p>Tickets
                                                <b class="caret"></b>
                                            </p>
                                        </a>
                                        <div <?php if($controller1=="tickets"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="ticket">
                                            <ul class="nav">
                                                    <?php
                                                      if(in_array(98, $this->session->userdata("permissions"))) {
                                                    ?>
                                                    <li <?php if($main_controller=="tickets" || ($controller1=="tickets" && $controller2!="add_ticket") || $main_controller=="tickets/edit_ticket"){ ?> class="active" <?php } ?>>
                                                        <a href="<?php echo SURL;?>tickets">
                                                           <span class="sidebar-mini">YT</span>
                                                           <span class="sidebar-normal">Your Tickets</span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                      }
                                                      if(in_array(99, $this->session->userdata("permissions"))) {
                                                    ?>
                                                    <li <?php if($main_controller=="tickets/add_ticket"){ ?> class="active" <?php } ?>>
                                                        <a href="<?php echo SURL;?>tickets/add_ticket">
                                                           <span class="sidebar-mini">AT</span>
                                                           <span class="sidebar-normal">Add Ticket</span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                      }
                                                    ?>
                                            </ul>
                                        </div>
                                    </li>
                                  
                      <?php } ?>
                      <li <?php if($main_controller=="help"){ ?> class="active" <?php } ?>>
                        <a href="<?php echo SURL;?>help">
                            <i class="material-icons">help</i>
                            <p>Help Section</p>
                        </a>
                    </li>
                    <!--<li <?php if($main_controller=="notifications"){ ?> class="active" <?php } ?>>
                        <a href="<?php echo SURL;?>notifications">
                            <i class="material-icons">notifications</i>
                            <p>Notifications</p>
                        </a>
                    </li>-->
                    
                </ul>
            </div>
        </div>