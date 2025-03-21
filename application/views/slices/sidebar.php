<div class="sidebar" data-active-color="orange" data-background-color="black" data-image="<?php echo IMG;?>sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
            <div class="logo">
                <a href="<?php echo SURL;?>dashboard" class="simple-text logo-mini">
                    LV
                </a>
                <a href="<?php echo SURL;?>dashboard" class="simple-text logo-small">
                    Launch Version
                </a>
            </div>
			<?php 
			$controller1 = $this->uri->segment(1);
			$controller2 = $this->uri->segment(2);
			$controller3 = $this->uri->segment(3);
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
                        <a class="parentMenu" data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>
                                Welcome <?php echo $this->session->userdata("firstname")." (".$this->session->userdata("company_name").")";?>
                                
                            </span>
                        </a>
                        <div class="clearfix"></div>
                        <?php $is_profile_update = checkUserProfile();
                        ?>
                       
                    </div>
                </div>
                <?php if($is_profile_update){ ?>
                <ul class="nav mainMenu">
                    <!--Dashboard-->
                    <?php
                      if(in_array(125, $this->session->userdata("permissions"))) {
                      ?>
                    <li class="<?php if($main_controller=="dashboard"){ ?>active<?php } ?>">
                        <a href="<?php echo SURL;?>dashboard">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <?php
                      }
                    ?>
                    <!--Designz-->
                    <?php
                      if(in_array(159, $this->session->userdata("permissions"))) {
                      ?>
                    <li class="child1 <?php if ($main_controller == "designz") { ?>active<?php } ?>">
                        <a class="parentMenu" href="<?php echo SURL; ?>designz" data-toggle="collapse" data-target="#designz" aria-expanded="<?php echo ($controller1 == "designz") ? 'true' : 'false'; ?>" onclick="designzMenuClick(event)">
                            <i class="material-icons">draw</i>
                            <p>
                                Designz
                                <b class="caret"></b>
                            </p>
                        </a>

                    <div <?php if ($controller1 == "designz") { ?> class="collapse in" <?php } else { ?> class="collapse" <?php } ?> id="designz">
                        <ul class="nav">
                            <li <?php if (($controller1 == "designz" && $controller2 == "manage_designz") || ($controller1 == "designz" && $controller2 == "add_designz") || $main_controller == "designz/edit_designz" || $main_controller == "designz/view_designz_details") { ?> class="active" <?php } ?>>
                                <a href="<?php echo SURL; ?>designz/manage_designz">
                                    <span class="sidebar-mini">MD</span>
                                    <span class="sidebar-normal">Add/Manage Designz</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                    <?php
                      }
                    ?>
					<!-- Costingz -->
                      <?php
                      $excludeSetupPages = array("users", "add_user", "edit_user", "roles", "add_role", "edit_role");
                      if(in_array(1, $this->session->userdata("permissions")) || in_array(109, $this->session->userdata("permissions"))) {
                      ?>
					    <li class="child1 <?php if($main_controller=="project_costing" || $controller1 == "manage" || ($controller1 == "setup" && !in_array($controller2, $excludeSetupPages))){ ?>active<?php } ?>">
                        <a class="parentMenu" data-toggle="collapse" href="#project_costing">
                            <i class="material-icons">android</i>
                            <p>Costingz
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="project_costing" || $controller1 == "manage" || ($controller1 == "setup" && !in_array($controller2, $excludeSetupPages))){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="project_costing">
                            <ul class="nav">
                                    <?php
                                      if(in_array(1, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="project_costing" || ($controller1=="project_costing" && $controller2!="add_project_costing") || $main_controller=="project_costing/edit_project_costing"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>project_costing">
                                           <span class="sidebar-mini">MPC</span>
                                           <span class="sidebar-normal">Manage Project Costing</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(3, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="project_costing/add_project_costing"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>project_costing/add_project_costing">
                                           <span class="sidebar-mini">APC</span>
                                           <span class="sidebar-normal">Add Project Costing</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                    if(in_array(57, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="manage/projects" || $main_controller=="manage/add_project" || $main_controller=="manage/edit_project"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/projects">
                                           <span class="sidebar-mini">P</span>
                                           <span class="sidebar-normal">Projects</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(53, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="manage/clients" || $main_controller=="manage/add_client" || $main_controller=="manage/edit_client" || $main_controller=="manage/view_client"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/clients">
                                           <span class="sidebar-mini">C</span>
                                           <span class="sidebar-normal">Clients</span>
                                        </a>
                                    </li>
                                    <?php }
                                     if(in_array(68, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="manage/components" || $main_controller=="manage/add_component" || $main_controller=="manage/edit_component"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/components">
                                           <span class="sidebar-mini">C</span>
                                           <span class="sidebar-normal">Components</span>
                                        </a>
                                    </li>
                                    <?php } 
                                       if(in_array(63, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="manage/suppliers" || $main_controller=="manage/add_supplier" || $main_controller=="manage/edit_supplier"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>manage/suppliers">
                                           <span class="sidebar-mini">S</span>
                                           <span class="sidebar-normal">Suppliers</span>
                                        </a>
                                    </li>
                                    <?php
                                      } 
                                      if(in_array(73, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="setup/stages" || $main_controller=="setup/add_stage" || $main_controller=="setup/edit_stage"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>setup/stages">
                                           <span class="sidebar-mini">S</span>
                                           <span class="sidebar-normal">Stages</span>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                      if(in_array(78, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="setup/takeoffdata" || $main_controller=="setup/add_takeoffdata" || $main_controller=="setup/edit_takeoffdata"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>setup/takeoffdata">
                                           <span class="sidebar-mini">TOD</span>
                                           <span class="sidebar-normal">Take off Data</span>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                      if(in_array(83, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="setup/templates" || $main_controller=="setup/add_template" || $main_controller=="setup/edit_template"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>setup/templates">
                                           <span class="sidebar-mini">T</span>
                                           <span class="sidebar-normal">Templates</span>
                                        </a>
                                    </li>
                                    <?php
                                     }
                                    ?>
                            </ul>
                        </div>
                    </li>
                     <?php } ?>
                     
                    <!--Buildz-->
                    <?php
                      if(in_array(134, $this->session->userdata("permissions"))) {
                      ?>
                    <li class="child1 <?php if ($main_controller == "buildz") { ?>active<?php } ?>">
                        <a class="parentMenu" href="<?php echo SURL; ?>buildz" data-toggle="collapse" data-target="#buildz" aria-expanded="<?php echo ($controller1 == "buildz") ? 'true' : 'false'; ?>">
                            <i class="material-icons">roofing</i>
                            <p>
                                Buildz
                                <b class="caret"></b>
                            </p>
                        </a>

                    <div <?php if ($controller1 == "buildz") { ?> class="collapse in" <?php } else { ?> class="collapse" <?php } ?> id="buildz">
                        <ul class="nav">
                            <?php
                            if(in_array(131, $this->session->userdata("permissions"))) {
                            ?>
                            <li <?php if (($controller1 == "buildz" && $controller2 == "tasks") || ($controller1 == "buildz" && $controller2 == "add_task") || $main_controller == "buildz/edit_task") { ?> class="active" <?php } ?>>
                                <a href="<?php echo SURL; ?>buildz/tasks">
                                    <span class="sidebar-mini">MT</span>
                                    <span class="sidebar-normal">Add/Manage Tasks</span>
                                </a>
                            </li>
                            <?php } 
                            if(in_array(138, $this->session->userdata("permissions"))) {
                            ?>
                            <li <?php if(($controller1=="buildz" && $controller2=="checklists") || ($controller1 == "buildz" && $controller2 == "add_checklist") || $main_controller == "buildz/edit_checklist") { ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>buildz/checklists">
                                           <span class="sidebar-mini">MC</span>
                                           <span class="sidebar-normal">Add/Manage Checklists</span>
                                        </a>
                                    </li>
                            <?php }
                            if(in_array(155, $this->session->userdata("permissions"))) {
                            ?>
                            <li <?php if (($controller1 == "buildz" && $controller2 == "templates") || ($controller1 == "buildz" && $controller2 == "add_template") || $main_controller == "buildz/edit_template") { ?> class="active" <?php } ?>>
                                <a href="<?php echo SURL; ?>buildz/templates">
                                    <span class="sidebar-mini">MT</span>
                                    <span class="sidebar-normal">Add/Manage Templates</span>
                                </a>
                            </li>
                            <?php 
                            }
                            if(in_array(144, $this->session->userdata("permissions"))) {
                                    ?>
                                <li <?php if ($controller1 == "buildz" && $controller2 == "reports") { ?> class="active" <?php } ?>>
                                    <a href="<?php echo SURL;?>buildz/reports">
                                        <span class="sidebar-mini">BR</span>
                                        <span class="sidebar-normal">Reports</span>
                                    </a>
                                </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </li>

                    <?php
                      }
                    ?>
                     <li class="child1 <?php if($controller1=="project_variations" || $controller1=="supplier_invoices" || $controller1=="sales_invoices" || $controller1 == "terms_and_conditions" || $controller1 == "purchase_orders" || $controller1 == "reports" || $controller1 == "timesheets" || $controller1 == "cash_transfers" || $controller1 == "supplier_credits"){ ?>active<?php } ?>">
                            <a class="parentMenu" data-toggle="collapse" href="#accountz" <?php if($controller1=="project_variations" || $controller1 == "terms_and_conditions" || $controller1 == "purchase_orders" || $controller1 == "reports" || $controller1 == "cash_transfers" || $controller1 == "manage" || $controller1 == "timesheets" || $controller1 == "supplier_credits"){ ?> aria-expanded="true" <?php } ?>>
                                <i class="material-icons">attach_money</i>
                                <p>Accountz
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div <?php if($controller1=="project_variations" || $controller1=="supplier_invoices" || $controller1=="sales_invoices" || $controller1 == "terms_and_conditions" || $controller1 == "purchase_orders" || $controller1 == "reports" || $controller1 == "cash_transfers" || $controller1 == "supplier_credits"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="accountz">
                                <ul class="nav">
                                  <!-- Variations -->
                                  <?php
                                  if(in_array(5, $this->session->userdata("permissions"))) {
                                  ?>
                                   <li <?php if($controller1=="project_variations"){ ?> class="active" <?php } ?>>
                                        <a class="childMenu" href="<?php echo SURL;?>project_variations">
                                            <i class="material-icons">trending_down</i>
                                            <p>Project Variations</p>
                                        </a>
                                    </li>
                                <?php } ?>
                                <!-- Purchase Orders -->
                                <?php
                                  if(in_array(11, $this->session->userdata("permissions"))) {
                                ?>
                                    <li <?php if($controller1=="purchase_orders"){ ?> class="active" <?php } ?>>
                                        <a class="childMenu" href="<?php echo SURL;?>purchase_orders">
                                            <i class="material-icons">shopping_cart</i>
                                                <p>Purchase Orders</p>
                                        </a>
                                    </li>
                                <?php } ?>
                    
                                <!-- Bills -->
                                 <?php
                                  if(in_array(18, $this->session->userdata("permissions"))) {
                                  ?>
                                    <li <?php if($controller1=="supplier_invoices"){ ?> class="active" <?php } ?>>
                                        <a class="childMenu" href="<?php echo SURL;?>supplier_invoices">
                                            <i class="material-icons">receipt</i>
                                            <p>Bills</p>
                                        </a>
                                    </li>
                                <?php } ?>
                                
                                <!--Credits-->
                                <?php
                                  if(in_array(26, $this->session->userdata("permissions"))) {
                                  ?>
                                    <li <?php if($controller1=="supplier_credits"){ ?> class="active" <?php } ?>>
                                        <a class="childMenu" href="<?php echo SURL;?>supplier_credits/create_supplier_credit">
                                            <i class="material-icons">credit_card</i>
                                            <p>Credits</p>
                                        </a>
                                    </li>
                                <?php } ?>
                    
                                <!-- Sales Invoices -->
                                <?php
                                  if(in_array(30, $this->session->userdata("permissions"))) {
                                  ?>
                                <li <?php if($main_controller=='sales_invoices' || $main_controller=='sales_credits_notes'){ ?> class="active" <?php } ?>>
                                    <a class="childMenu" data-toggle="collapse" href="#sales_invoices" <?php if($controller1=='sales_invoices' || $controller1=='sales_credits_notes'){ ?> aria-expanded="true" <?php } ?>>
                                        <i class="material-icons">summarize</i>
                                        <p>Sales
                                            <b class="caret"></b>
                                        </p>
                                    </a>
                                    <div <?php if($controller1=="sales_invoices" || $controller1=="sales_credits_notes"){ ?> class="collapse childCollapse in" <?php } else{ ?> class="collapse" <?php } ?> id="sales_invoices">
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
                                                <!--<li <?php if(($controller1=="sales_invoices" && $controller2=="manage_csv_files") || $main_controller=="sales_invoices/viewcsv"){ ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SURL;?>sales_invoices/manage_csv_files">
                                                       <span class="sidebar-mini">MCF</span>
                                                       <span class="sidebar-normal">Manage CSV Files</span>
                                                    </a>
                                                </li>-->
                                                <?php
                                                  }
                                                  $xero_credentials = get_xero_credentials();
                                                  //if(count($xero_credentials)>0){
                                                 if(in_array(36, $this->session->userdata("permissions"))) {
                                                ?>
                                                <?php
                                                  if(in_array(38, $this->session->userdata("permissions"))) {
                                                ?>
                                                <!--<li <?php if(($main_controller=="sales_credits_notes") || $main_controller=="sales_credits_notes/viewcreditnotes"){ ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SURL;?>sales_credits_notes">
                                                       <span class="sidebar-mini">MSC</span>
                                                       <span class="sidebar-normal">Manage Sales Credits</span>
                                                    </a>
                                                </li>-->
                                                <?php
                                                  } } 
                                                   //}
                                                ?>
                                        </ul>
                                    </div>
                                </li>
                                <?php } ?>
                    
                                <?php
                                 if(in_array(42, $this->session->userdata("permissions"))) {
                                ?>
                                <li <?php if($controller1=="cash_transfers"){ ?> class="active" <?php } ?>>
                                        <a class="childMenu" href="<?php echo SURL;?>cash_transfers">
                                            <i class="material-icons">money</i>
                                                <p>Cash Transfers</p>
                                        </a>
                                    </li>
                                <?php } ?>
                    
                                <!-- Reports -->
                                <?php
                                  if(in_array(47, $this->session->userdata("permissions"))) {
                                  ?>
                                <li <?php if($main_controller=='reports'){ ?> class="active" <?php } ?>>
                    <a class="childMenu" data-toggle="collapse" href="#reportsMenu" <?php if($controller1=='reports'){ ?> aria-expanded="true" <?php } ?>>
                                        <i class="material-icons">report</i>
                                        <p>Accountz Reports
                                            <b class="caret"></b>
                                        </p>
                    </a>
                    <div <?php if($controller2 == "view_project_report_details" || $controller2=="project_report" || $controller2 == "supplier_components" || $controller2=="project_summary" || $controller2=="component_items_unordered" || $controller2=="tracking" || $controller2=="add_tracking" || $controller2=="edit_tracking_report" || $controller2=="tracking_report" || $controller2=="project_uninvoiced_component" || $controller2=="updated_specifications_report" || $controller2=="project_suppliers_report" || $controller2=="updated_project_costing_report" || $controller2=="workInProgress" || $controller2=="budget_vs_actual" || $controller2=="project_transactions_report" || $controller2=="project_unordered_items"){ ?> class="childCollapse collapse in" <?php } else{ ?> class="childCollapse collapse" <?php } ?> id="reportsMenu">
                                        <ul class="nav">
                                               <?php
                                                  if(in_array(48, $this->session->userdata("permissions"))) {
                                                ?>
                                                <li <?php if($main_controller=="reports/project_report" || $main_controller=="reports/view_project_report_details"){ ?> class="active" <?php } ?>>
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
                                                
                                                <?php if(in_array(120, $this->session->userdata("permissions"))) {
                                                  ?>
                                                  <li <?php if($main_controller=="reports/supplier_components"){ ?> class="active" <?php } ?>>
                                                    <a href="<?php echo SURL;?>reports/supplier_components">
                                                       <span class="sidebar-mini">SC</span>
                                                       <span class="sidebar-normal">Supplier Components</span>
                                                    </a>
                                                  </li>
                                                  <?php
                                                  } ?>
                                                
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
                            </ul>
                        </div>
                    </li>
                        <?php if(in_array(126, $this->session->userdata("permissions"))) { ?>
                        <!-- Supplierz -->
                        <li class="child1 <?php if($main_controller=="supplierz" || $main_controller=="supplierz_buildz"){ ?>active<?php } ?>">
                        <a class="parentMenu" data-toggle="collapse" href="#supplierz" <?php if($controller1=="supplierz" || $controller1=="supplierz_buildz"){ ?> aria-expanded="true" <?php } ?>>
                            <i class="material-icons">airport_shuttle</i>
                            <p>Supplierz
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="supplierz" || $controller1=="supplierz_buildz"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="supplierz">
                            <ul class="nav">
                                    <?php
                                    if(in_array(149, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz" || ($controller1=="supplierz" && $controller2=="components") || $main_controller=="supplierz/add_component" || $main_controller=="supplierz/edit_component"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/components">
                                           <span class="sidebar-mini">C</span>
                                           <span class="sidebar-normal">Components</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      
                                    if(in_array(160, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz" || ($controller1=="supplierz" && $controller2=="suppliers") || $main_controller=="supplierz/add_supplier" || $main_controller=="supplierz/edit_supplier"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/suppliers">
                                           <span class="sidebar-mini">S</span>
                                           <span class="sidebar-normal">Suppliers</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(114, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz" || ($controller1=="supplierz" && $controller2=="price_books") || $main_controller=="supplierz/add_price_book" || $main_controller=="supplierz/edit_price_book"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/price_books">
                                           <span class="sidebar-mini">PB</span>
                                           <span class="sidebar-normal">Price Books</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      /*if(in_array(119, $this->session->userdata("permissions"))) {
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
                                      }*/
                                      if(in_array(122, $this->session->userdata("permissions"))) {
                                    ?>
                                    <!--<li <?php if($main_controller=="supplierz/manage_confirm_estimate_requests"){ ?> class="active" <?php } ?>>
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
                                    </li>-->
                                    <?php
                                      }
                                      if(in_array(123, $this->session->userdata("permissions"))) {
                                    ?>
                                    <!--<li <?php if($main_controller=="supplierz/manage_component_orders"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_component_orders">
                                           <span class="sidebar-mini">CO</span>
                                           <span class="sidebar-normal">Component Orders <sup class="badge badge-success"><?php echo get_component_orders_count($this->session->userdata('company_id'));?></sup></span>
                                        </a>
                                    </li>-->
                                    <?php
                                      }
                                    if(in_array(162, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz" || ($controller1=="supplierz" && $controller2=="project_costing") || $main_controller=="supplierz/add_project_costing" || $main_controller=="supplierz/edit_project_costing"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/project_costing">
                                           <span class="sidebar-mini">PC</span>
                                           <span class="sidebar-normal">Project Costing</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(129, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/manage_templates" || $main_controller=="supplierz/add_template" || $main_controller=="supplierz/edit_template"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_templates">
                                           <span class="sidebar-mini">CT</span>
                                           <span class="sidebar-normal">Costing Templates</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(163, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($controller1=="supplierz_buildz" || $main_controller=="supplierz_buildz/templates" || $main_controller=="supplierz_buildz/add_template" || $main_controller=="supplierz_buildz/edit_template"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz_buildz/templates">
                                           <span class="sidebar-mini">BT</span>
                                           <span class="sidebar-normal">Buildz Templates</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(161, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/manage_designz" || $main_controller=="supplierz/add_designz" || $main_controller=="supplierz/edit_designz"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_designz">
                                           <span class="sidebar-mini">DB</span>
                                           <span class="sidebar-normal">Design Books</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      /*if(in_array(130, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="supplierz/manage_template_requests"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_template_requests">
                                           <span class="sidebar-mini">MTR</span>
                                           <span class="sidebar-normal">Template Requests <sup class="badge badge-success"><?php echo get_template_requests_count($this->session->userdata('company_id'));?></sup></span>
                                        </a>
                                    </li>
                                    <?php
                                      }*/
                                      if(in_array(123, $this->session->userdata("permissions"))) {
                                    ?>
                                    <!--<li <?php if($main_controller=="supplierz/manage_online_store_orders"){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>supplierz/manage_online_store_orders">
                                           <span class="sidebar-mini">OSO</span>
                                           <span class="sidebar-normal">Online Store Orders <sup class="badge badge-success"><?php echo get_online_store_orders_count($this->session->userdata('company_id'));?></sup></span>
                                        </a>
                                    </li>-->
                                    <?php
                                      }
                                    ?>
                            </ul>
                        </div>
                    </li>
                    <?php
                        }
                        /*if(in_array(134, $this->session->userdata("permissions"))) {
                    ?>
                        <!-- Scheduling -->
                        <li class="child1 <?php if($main_controller=="scheduling/dashboard" || $main_controller=="scheduling/whats_new" || $main_controller=="scheduling/reports" || $main_controller=="scheduling/tasks" || $main_controller=="scheduling/checklists" || $main_controller=="scheduling/public_holidays" || $main_controller=="scheduling/reminders" || $main_controller=="scheduling/templates"){ ?>active<?php } ?>">
                        <a class="parentMenu" data-toggle="collapse" href="#scheduling" <?php if($main_controller=="scheduling/dashboard" || $main_controller=="scheduling/reports" || $main_controller=="scheduling/tasks" || $main_controller=="scheduling/checklists" || $main_controller=="scheduling/public_holidays" || $main_controller=="scheduling/reminders" || $main_controller=="scheduling/templates"){ ?> aria-expanded="true" <?php } ?>>
                            <i class="material-icons">schedule</i>
                            <p>Scheduling
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="scheduling"){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="scheduling">
                            <ul class="nav">
                                    <?php
                                      if(in_array(152, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="scheduling" || ($controller1=="scheduling" && $controller2=="dashboard") || ($controller1=="scheduling" && $controller2=="whats_new")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>scheduling/dashboard">
                                           <span class="sidebar-mini">DWN</span>
                                           <span class="sidebar-normal">Dashboard and Whats New</span>
                                        </a>
                                    </li>
                                    <?php
                                      }
                                      if(in_array(153, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="scheduling" || ($controller1=="scheduling" && $controller2=="projects")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>scheduling/projects">
                                           <span class="sidebar-mini">CM</span>
                                           <span class="sidebar-normal">Construction Management</span>
                                        </a>
                                    </li>
                                    <?php
                                      }

                                    ?>
                                    <?php
                                    if(in_array(154, $this->session->userdata("permissions"))) {
                                    ?>
                                       <li <?php if($controller1=="scheduling" && ($controller2=="notifications" || $controller2=="tasks" || $controller2=="public_holidays" || $controller2=="checklists" || $controller2=="reminders" || $controller2=="templates")){ ?> class="active" <?php } ?>>
                        <a class="childMenu" data-toggle="collapse" href="#schedulingSetup" <?php if($controller1=="scheduling" && ($controller2=="notifications" || $controller2=="tasks" || $controller2=="public_holidays" || $controller2=="templates" || $controller2=="checklists" || $controller2=="reminders")){ ?> aria-expanded="true" <?php } ?>>
                            <i class="material-icons">settings</i>
                            <p>Setup
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="scheduling" && ($controller2=="notifications" || $controller2=="tasks" || $controller2=="public_holidays" || $controller2=="checklists" || $controller2=="reminders" || $controller2=="templates")){ ?> class="collapse in childCollapse" <?php } else{ ?> class="collapse childCollapse" <?php } ?> id="schedulingSetup">
                            <ul class="nav">
                                    <?php
                                      if(in_array(131, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="scheduling" || ($controller1=="scheduling" && $controller2=="tasks")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>scheduling/tasks">
                                           <span class="sidebar-mini">ST</span>
                                           <span class="sidebar-normal">Tasks</span>
                                        </a>
                                    </li>
                                    <?php }
                                     if(in_array(138, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="scheduling" || ($controller1=="scheduling" && $controller2=="checklists")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>scheduling/checklists">
                                           <span class="sidebar-mini">SC</span>
                                           <span class="sidebar-normal">Checklists</span>
                                        </a>
                                    </li>
                                    <?php } 
                                    if(in_array(135, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="scheduling" || ($controller1=="scheduling" && $controller2=="public_holidays")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>scheduling/public_holidays">
                                           <span class="sidebar-mini">SPH</span>
                                           <span class="sidebar-normal">Public Holidays</span>
                                        </a>
                                    </li>
                                    <?php }
                                    if(in_array(141, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="scheduling" || ($controller1=="scheduling" && $controller2=="reminders")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>scheduling/reminders">
                                           <span class="sidebar-mini">SR</span>
                                           <span class="sidebar-normal">Reminders</span>
                                        </a>
                                    </li>
                                    <?php }
                                    if(in_array(155, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="scheduling" || ($controller1=="scheduling" && $controller2=="templates")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>scheduling/templates">
                                           <span class="sidebar-mini">ST</span>
                                           <span class="sidebar-normal">Templates</span>
                                        </a>
                                    </li>
                                    <?php }
                                    if(in_array(158, $this->session->userdata("permissions"))) {
                                    ?>
                                    <li <?php if($main_controller=="scheduling" || ($controller1=="scheduling" && $controller2=="notifications")){ ?> class="active" <?php } ?>>
                                        <a href="<?php echo SURL;?>scheduling/notifications">
                                           <span class="sidebar-mini">SN</span>
                                           <span class="sidebar-normal">Notifications</span>
                                        </a>
                                    </li>
                                    <?php }
                                    ?>
                                </ul>
                        </div>
                    </li>
                                    <?php } ?>
                                    <?php if(in_array(144, $this->session->userdata("permissions"))) { ?>
                                       <li <?php if($controller1=="scheduling" && $controller2=="reports"){ ?> class="active" <?php } ?>>
                                        <a class="childMenu" data-toggle="collapse" href="#schedulingReports" <?php if($controller1=="scheduling" && $controller2=="reports"){ ?> aria-expanded="true" <?php } ?>>
                                            <i class="material-icons">report</i>
                                            <p>Reports
                                                <b class="caret"></b>
                                            </p>
                                        </a>
                                        <div <?php if($controller1=="scheduling" && $controller2=="reports"){ ?> class="collapse in childCollapse" <?php } else{ ?> class="collapse childCollapse" <?php } ?> id="schedulingReports">
                                            <ul class="nav">
                                                    <?php
                                                      if(in_array(145, $this->session->userdata("permissions"))) {
                                                    ?>
                                                    <li <?php if($controller1=="scheduling" && $controller2=="reports" && $controller3=="project_summary"){ ?> class="active" <?php } ?>>
                                                        <a href="<?php echo SURL;?>scheduling/reports/project_summary">
                                                           <span class="sidebar-mini">PSR</span>
                                                           <span class="sidebar-normal">Project Summary</span>
                                                        </a>
                                                    </li>
                                                    <?php }
                                                     if(in_array(146, $this->session->userdata("permissions"))) {
                                                    ?>
                                                    <li <?php if($controller1=="scheduling" && $controller2=="reports" && $controller3=="daily_summary"){ ?> class="active" <?php } ?>>
                                                        <a href="<?php echo SURL;?>scheduling/reports/daily_summary">
                                                           <span class="sidebar-mini">DES</span>
                                                           <span class="sidebar-normal">Daily Email Summaries</span>
                                                        </a>
                                                    </li>
                                                    <?php } 
                                                    if(in_array(147, $this->session->userdata("permissions"))) {
                                                    ?>
                                                    <li <?php if($controller1=="scheduling" && $controller2=="reports" && $controller3=="project_schedule"){ ?> class="active" <?php } ?>>
                                                        <a href="<?php echo SURL;?>scheduling/reports/project_schedule">
                                                           <span class="sidebar-mini">PS</span>
                                                           <span class="sidebar-normal">Project Schedule</span>
                                                        </a>
                                                    </li>
                                                    <?php }
                                                    if(in_array(148, $this->session->userdata("permissions"))) {
                                                    ?>
                                                    <li <?php if($controller1=="scheduling" && $controller2=="reports" && $controller3=="send_project_schedule"){ ?> class="active" <?php } ?>>
                                                        <a href="<?php echo SURL;?>scheduling/reports/send_project_schedule">
                                                           <span class="sidebar-mini">SPS</span>
                                                           <span class="sidebar-normal">Send Project Schedule</span>
                                                        </a>
                                                    </li>
                                                    <?php }
                                                    ?>
                                                </ul>
                                        </div>
                                    </li>
                                    <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php } */?>
                    <!-- Setup -->
                    <li class="child1 <?php if($main_controller=="setup" && in_array($controller2, $excludeSetupPages)){ ?>active<?php } ?>">
                        <a class="parentMenu" data-toggle="collapse" href="#setup">
                            <i class="material-icons">settings</i>
                            <p>Setup
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div <?php if($controller1=="setup" && in_array($controller2, $excludeSetupPages)){ ?> class="collapse in" <?php } else{ ?> class="collapse" <?php } ?> id="setup">
                            <ul class="nav">
                                    <?php
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
                </ul>
                <?php } ?>
            </div>
        </div>