<ul>
    <?php if(count($categories)>0){foreach($categories as $category){?>
    <li class="category-item" id="<?php echo $category["id"];?>"><?php echo $category["name"];?></li>
    <?php } } else{?>
    <li class="text-danger">No Categories Found</li>
    <?php } ?>
</ul>