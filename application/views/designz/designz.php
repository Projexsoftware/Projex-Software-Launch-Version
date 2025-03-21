<div class="row">
    <div class="col-md-12">
        <div class="card"> 
            <div class="card-content"> 
                <form>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php if(isset($_POST['search_filter']) && $_POST['search_filter']!=''){?>
                               <input type="text" class="form-control" id="search_design" placeholder="Search Design" value="<?php echo $_POST['search_filter']?>">	
                            <?php } else {?>
                            <input type="text" class="form-control" id="search_design" placeholder="Search Design">	
                            <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card"> 
                <div class="card-header card-header-icon" data-background-color="orange">
                    <i class="material-icons">search</i>
                </div>
            <div class="card-content"> 
            <h4 class="card-title">Filters</h4>
            <div class="row cosmo-main-content-range-slider">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">
                            <h4>Sort Order</h4>
                        </label>
                        <select class="selectpicker" data-style="select-with-transition" id="sort_order" name="sort_order" onchange="filterdata();">
                            <option value="">Select Sort Order</option>
                             <option <?php if($this->session->userdata('sort_order')=="Alphabetical"){ ?> selected <?php } ?> value="Alphabetical">Alphabetical</option>
                            <option <?php if($this->session->userdata('sort_order')=="Biggest Size"){ ?> selected <?php } ?> value="Biggest Size">Biggest Size</option>
                            <option <?php if($this->session->userdata('sort_order')=="Smallest Size"){ ?> selected <?php } ?> value="Smallest Size">Smallest Size</option>
                        </select>
                        
        			</div>
                </div>
                <div class="col-md-12 col-sm-12">
                <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                        <label class="control-label connect">
                            <h4>Bedroom:</h4>
                            <h4><span id="slider-snap-value-lower2"></span> -	
                            <span id="slider-snap-value-upper3"></span></h4>
                        </label>
                        <br>
                        <div id="connect2"></div>
                        
        			</div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                        <label class="control-label connect">
                            <h4>Bathroom:</h4>
                            <h4>
                            <span id="slider-snap-value-lower4"></span> -	
                            <span id="slider-snap-value-upper5"></span>
                            </h4>
                        </label>
                        <br>
                        <div id="connect3"></div>
                        
        			</div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                        <label class="control-label connect">
                            <h4>Garage:</h4>
                            <h4>
                            <span id="slider-snap-value-lower6"></span> -	
                            <span id="slider-snap-value-upper7"></span>
                            </h4>
                        </label>
                        <br>
                        <div id="connect4"></div>
                        
        			</div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                        <label class="control-label connect">
                            <h4> Living Areas:</h4>
                            <h4>
                            <span id="slider-snap-value-lower10"></span> -	
                            <span id="slider-snap-value-upper11"></span>
                            </h4>
                        </label>
                        <br>
                        <div id="connect6"></div>
                        
        			</div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label class="control-label connect">
                            <h4>Floor Area:</h4>
                            <h4><span id="slider-snap-value-lower1"></span>m² -	
                            <span id="slider-snap-value-upper2"></span>m²</h4>
                        </label>
                        <br>
                        <div id="connect1"></div>
                        
        			</div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group label-floating">
                    <div class="form-footer text-right">
                        <a href="<?php echo SURL;?>designz" class="btn btn-warning btn-fill reset-text">Reset</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
            <?php 
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}
										?>
			</div>
            <div class="row" id="fdata"></div>
            </div>
            </div>
        </div>
    </div>
</div>
      
                   