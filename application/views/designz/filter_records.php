<?php
if ($get_data_count > 0) {
    foreach ($get_data as $row) {
        ?>	
        <div class="col-md-12 col-sm-12">	
            <div class="thumbnail custom-thumbnail homepage-thumbnail">
                <div class="col-md-12 col-sm-12">
                <div class="caption">
                    <h3><a href="<?php echo base_url('designz/details/'.$row['designz_type'].'/'. $row['designz_id']); ?>"><?php echo $row['builderz_designz_name']; ?></a></h3>
                </div>	
                </div>
                <div class="col-md-6 col-sm-6">
                <?php $thumbnail = get_thumbnail($row['designz_id'], $row['designz_type'], 'image');?>
                    <a href="<?php echo base_url('designz/details/'.$row['designz_type'].'/'. $row['designz_id']); ?>"><img class="img-responsive custom-main-image" src='<?php echo count($thumbnail)>0?'assets/builderz_designz_uploads/'.$thumbnail['file_name']:SURL . "assets/images/default_image.png"; ?>'></a>
                </div>
                <div class="col-md-6 col-sm-6">
                <?php $plan_thumbnail = get_thumbnail($row['designz_id'], $row['designz_type'], 'plan');?>
                    <a href="<?php echo base_url('designz/details/'.$row['designz_type'].'/'. $row['designz_id']); ?>"><img class="img-responsive custom-main-image" src='<?php echo count($plan_thumbnail)>0?'assets/builderz_designz_uploads/'.$plan_thumbnail['file_name']:SURL . "assets/images/default_image.png"; ?>'></a>
                </div>
                <div class="col-md-12 col-sm-12">
                <div class="caption">
                    <h4 class="text-warning">Floor Area : <?php echo $row['floor_area'];?>m²</h4>
                    <ul class="nav custom-nav col-md-4 col-sm-12">
                        <li>
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/images/icon-1.png" alt="...">	
                            <a><?php echo $row['bedrooms']; ?></a>	
                        </li>	
                        <li>
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/images/icon-2.png" alt="...">
                            <a><?php echo $row['bathrooms']; ?></a>	
                        </li>
                        <li>
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/images/icon-3.png" alt="...">
                            <a><?php echo $row['garage']; ?></a>	
                        </li>
                        <li>
                            <img class="img-responsive" src="<?php echo base_url() ?>assets/images/icon-4.png" alt="...">
                            <a><?php echo $row['living_areas']; ?></a>	
                        </li>	
                    </ul>				
                </div>	
                </div>
                
            </div>	
        </div>	
        <?php
    }
} else {
    ?>
    <h2  align="center">No Designz Founds.</h2>
    <?php
}
?>
         