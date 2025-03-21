<div class="row">
    <div class="col-md-12">
        <div class="card"> 
                <div class="card-header card-header-icon" data-background-color="orange">
                    <i class="material-icons">draw</i>
                </div>
            <div class="card-content"> 
               <h4 class="card-title">Designz Details</h4>
               <div class="row">
                   <div class="col-md-12 cosmo-main-content-right">
            <div class="row custom-right-border">
                <div class="col-md-4 cosmo-main-content-header-section-left">	
                    <h3><?php echo $designz_details['builderz_designz_name']; ?></h3>		
                </div>
                
                <div class="col-md-8 cosmo-main-content-header-section-right">
                    <ul class="nav custom-nav">
                        <?php 
                            $my_class ='';
                            if (isset($designz_details['floor_area']) && $designz_details['floor_area']!='' ) {
                                $my_class = 'first_child';
                            } 
                        ?>
                        <li class="<?php echo $my_class; ?>">
                            <a>Floor area: <?php echo $designz_details['floor_area'] ?>m²</a>
                        </li>
                        <li>
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/images/icon-right-1.png" alt="...">	
                            <a><?php echo $designz_details['bedrooms']; ?></a>	
                        </li>	
                        <li>
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/images/icon-right-2.png" alt="...">
                            <a><?php echo $designz_details['bathrooms']; ?></a>	
                        </li>
                        <li>
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/images/icon-right-3.png" alt="...">
                            <a><?php echo $designz_details['garage']; ?></a>	
                        </li>
                        <li>
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/images/icon-right-4.png" alt="...">
                            <a><?php echo $designz_details['living_areas']; ?></a>	
                        </li>	
                    </ul>	
                </div>	
            </div>
            <div class="row cosmo-right-slider-area">
                <br>
                <div class="col-md-12">
                <div class="col-md-7">
                    <h4 class="card-title">Images</h4>
                    
					<?php if (count($uploadedBuilderzImages) > 0) { ?>

                        <div id="carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner custom-carousel-hh j_carousel">
                                <?php
                                $itemactive = "active";

                                foreach ($uploadedBuilderzImages as $row) {
                                    ?>

                                    <div class="item <?php echo $itemactive; ?>">
                                        <a href="<?php echo SURL . "assets/builderz_designz_uploads/" . $row['file_name']; ?>" data-lightbox="example-set-1">
                                        <img class="rv-thumbnail" src="<?php echo SURL . "assets/builderz_designz_uploads/" . $row['file_name']; ?>" >
                                        </a>
                                    </div>
                                    <?php
                                    $itemactive = "";
                                }
                                ?>
                            </div>

                            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                                <img class="rv-thumbnail" src="<?php echo base_url() ?>assets/images/arrow-left.png">
                            </a>
                            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                                <img class="rv-thumbnail" src="<?php echo base_url() ?>assets/images/arrow-right.png">
                            </a>

                        </div>
                        <div class="clearfix">
                            <div id="thumbcarousel" class="carousel slide" data-interval="false">
                                <div class="carousel-inner">
    <?php
    $count=0;
    foreach ($uploadedBuilderzImages as $row) { ?>

                                        <div class="item active">
                                            <div data-target="#carousel" data-slide-to="<?php echo $count ?>" class="thumb">
                                                <img src='<?php echo SURL . "assets/builderz_designz_uploads/thumbnail/" . $row['file_name']; ?>'></div>
                                        </div>
    <?php  $count++; } ?>
                                </div>
                            </div> 
                        </div>


                    <?php } else { ?>
                        <h4>No Images Found</h4>
<?php } ?>

                    <h4 class="card-title mg-top-20">Plan</h4>
<?php if (count($uploadedBuilderzPlans) > 0) { ?>
                        <div id="carousel-1" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner carousel-inner-2 custom-carousel-hh">
                                <?php
                                $itemactive = "active";

                                foreach ($uploadedBuilderzPlans as $row) {
                                    ?>
                                    <div class="item <?php echo $itemactive; ?>">
                                        <a href="<?php echo SURL . "assets/builderz_designz_uploads/" . $row['file_name']; ?>" data-lightbox="example-set" >
                                    
                                            <img class="rv-thumbnail" src="<?php echo SURL . "assets/builderz_designz_uploads/" . $row['file_name']; ?>">
                                        </a>
                                        
                                        
                                    </div>

                                    <?php
                                    $itemactive = "";
                                }
                                ?>
                            </div>

                            <a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev">
                                <img class="rv-thumbnail" src="<?php echo base_url() ?>assets/images/arrow-left.png">
                            </a>
                            <a class="right carousel-control" href="#carousel-1" role="button" data-slide="next">
                                <img class="rv-thumbnail" src="<?php echo base_url() ?>assets/images/arrow-right.png">
                            </a>

                        </div>


                        <div class="clearfix">
                            <div id="thumb carousel-1" class="carousel slide" data-interval="false">
                                <div class="carousel-inner">
    <?php 
    $count2=0;
    foreach ($uploadedBuilderzPlans as $row) { ?>
                                        <div class="item active">
                                            <div data-target="#carousel-1" data-slide-to="<?php echo $count2 ;?>" class="thumb thumb-2">

                                                <img src='<?php echo SURL . "assets/builderz_designz_uploads/thumbnail/" . $row['file_name']; ?>'>
                                            </div>
                                        </div>
    <?php $count2++; } ?>
                                </div>
                            </div> 
                        </div>
                    <?php } else { ?>
                        <h4>No Plans found</h4>
                    <?php } ?>
                    <?php if($designz_details['movies']!=""){ ?>
                       <h4 class="card-title mg-top-20">Movie</h4>
                       <?php echo $designz_details['movies']; ?>
                    <?php } ?>
                    <?php if($designz_details['3D']!=""){ ?>
                      <h4 class="card-title mg-top-20">3D</h4>
                      <?php echo $designz_details['3D']; ?>
                    <?php } ?>
                </div>	
                </div>
            </div>	


        </div>
               </div>
            </div>
        </div>
    </div>
</div>