<style>
     #<?php echo $id ?> .flexslider_event .slides > li {
        margin-right: <?php echo $car_itemmargin ?>px;
     }    
 </style>
<?php global $post; 
    if (!have_posts()) return;
?>
    <div class="flexslider_event eosa_minicarousel <?php echo $skin ?>">
        <div id="<?php echo $id; ?>_box_card" class="eosa_box_card"></div>
        <div id="box_arrow_s4" class="box_arrow">
             <span id="eo_s1_arrowLeft" class="eo_s4b_arrow eo_sx"><i class="fa fa-angle-left"></i></span>
             <span id="eo_s1_arrowRight" class="eo_s4b_arrow eo_dx"><i class="fa fa-angle-right"></i></span>
        </div>
        <ul class="slides">
            <?php 
          while(have_posts()):
              the_post();  
              $optionArr = array("slider_type" => $slider_type,"c_open_type" => $c_open_type,"open_type" => $open_type, "cover" => $cover);
              $item_array = readEventData($date_out, $date_in, $lan, $optionArr);
              
              // MIKE
              $featured = get_post_meta(get_the_Id(), '_featured', true);
              $in = inDateRange($item_array[15],$featured,$meta_query_arr);
              if ($in) array_push($global_array, $item_array);   

              $arrRepeats = createEventRepeats($slider_type,$date_out,$date_in,$lan,$meta_query_arr,$item_array,$optionArr);
              $global_array = array_merge($global_array,$arrRepeats);
            
          endwhile;  wp_reset_query();               
              
            // MIKE: SORT ARRAY based on start_date
            if ($orderby == 'asc') usort($global_array, 'sort_by_date_in_asc');
            else usort($global_array, 'sort_by_date_in_desc');
                
            foreach($global_array as $item_array)   {              
            ?> 
            <li>
                 <?php $fullid = $id . '_' . $eo_index. "_eo_s3_item" ?>
               <div id="<?php echo $fullid ?>" class="eo_s4b_main"  style="border-top: 1px solid #<?php echo $item_array[10]; ?>; border-bottom: 1px solid #<?php echo $item_array[10]; ?>">
                 <div class="eo_s4b_box" onclick="showEventOESAinit('<?php echo $eo_index ?>','<?php echo $id; ?>',<?php echo $id. "_eo_js_array"; ?>,'<?php echo $open_type ?>','<?php echo $c_dir ?>','<?php echo $fullid ?>')">
                  <div class="eo_s4b_month"><?php echo mb_substr($item_array[1],0,3) ?></div>
                  <div class="eo_s4b_day"><?php echo $item_array[0]; ?></div>
                 </div>
               </div>
            </li>
            <?php 
                $eo_index = $eo_index + 1;
            }
            ?>         
            </ul>
        <div class="clear"></div>
        <script type='text/javascript'>
                <?php
          echo "var " .$id. "_eo_js_array = ". json_encode_arr($global_array) . ";\n";
                ?>
            jQuery(document).ready(function () {
                jQuery("#<?php echo $id; ?> .flexslider_event").flexslider({
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav: false,
                    animation: "slide",  
                    itemWidth: <?php echo $car_itemwidth; ?>, 
                    itemMargin: <?php echo $car_itemmargin; ?>,   
                    slideshow: true,          
                    move: <?php echo $car_move; ?>,
                    minItems: getGridSize(<?php echo "'" . $id . "','" . $car_itemwidth . "'"; ?>),
                    maxItems: getGridSize(<?php echo "'" . $id . "','" . $car_itemwidth . "'"; ?>),     
                    start: function (slider) {
                        showSlider('<?php echo $id; ?>');
                        hideNavigationArrow('#<?php echo $id; ?>');
                    }
                });
            });
            jQuery("#<?php echo $id; ?> #eo_s1_arrowRight").click(function () {
                jQuery("#<?php echo $id; ?> .flexslider_event").flexslider("next");
            });
            jQuery("#<?php echo $id; ?> #eo_s1_arrowLeft").click(function () {
                jQuery("#<?php echo $id; ?> .flexslider_event").flexslider("prev");
            });
        </script>
    </div>
    <div class="clear"></div>
    <div id="<?php echo $id; ?>_box_dropdown" class="eosa_box_dropdown"></div>