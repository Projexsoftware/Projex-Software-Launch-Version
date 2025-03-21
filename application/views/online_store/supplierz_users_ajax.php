<ul>
    <?php if(count($supplierz_users)>0){foreach($supplierz_users as $supplierz){?>
    <li class="supplierz_user" id="<?php echo $supplierz["user_id"];?>"><?php echo $supplierz["com_name"];?></li>
    <?php } } else{?>
    <li class="text-danger">No Suppliers Found</li>
    <?php } ?>
</ul>