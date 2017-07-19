 <style>
     #<?php echo $id ?> .flexslider_event .slides > li {
        margin-right: <?php echo $car_itemmargin ?>px;
     }    
 </style>
<?php 
global $post; 
global $plugin_url;
    if (!have_posts()) return;
?>
 <div class="flexslider_event eosa_minicarousel <?php echo $skin ?>">
        <div id="<?php echo $id; ?>_box_card" class="eosa_box_card"></div>
        <div id="box_arrow_s4" class="box_arrow">
            <span id="eo_s1_arrowLeft" class="eo_s3_arrow eo_sx"><i class="fa fa-angle-left"></i></span>
            <span id="eo_s1_arrowRight" class="eo_s3_arrow eo_dx"><i class="fa fa-angle-right"></i></span>
        </div>
        <div class="eosa_popup" id="<?php echo $id . "_eosa_popup"; ?>"><p id="<?php echo $id . "_eosa_popup_p"; ?>">...</p><i class="fa fa-caret-down"></i></div>
        <ul class="slides">
            <?php 
          while(have_posts()):
              the_post();  
              $optionArr = array("slider_type" => $slider_type,"c_open_type" => $c_open_type,"open_type" => $open_type, "cover" => $cover);
              $item_array = readEventData($date_out, $date_in, $lan, $optionArr);
              
              //row type
              $row_txt = "";
              $row_html = "";
              if ($mcar_row == "location") { $row_html = "<i class=\"fa fa-map-marker\"></i></span>" . $item_array[5]; $row_txt = $item_array[5]; }
              if ($mcar_row == "subtitle") { $row_html =  $item_array[3]; $row_txt = $item_array[3]; }
              if ($mcar_row == "organizer") { $row_html = "<i class=\"fa fa-headphones\" style=\"color: #" . $item_array[10] . "\"></i></span>" . $item_array[6]; $row_txt = $item_array[6]; }
              if (count($item_array[14]) > 0) {
                  if (($mcar_row == "ef1")|| ($mcar_row == "ef2")|| ($mcar_row == "ef3")) { 
                      $content = "";
                      if ($mcar_row == "ef1") $content = $item_array[14][0];
                      if ($mcar_row == "ef2") $content = $item_array[14][1];
                      if ($mcar_row == "ef3") $content = $item_array[14][2];
                      $row_html = getExtraFieldsHTML($slider_type, $style, $item_array[10],$content); 
                      if ($content["type"] == "button") {
                          $tmp = explode("|", $content["content"]);
                          $row_txt = HTMLtoText($tmp[0],100);
                      } else {
                          $row_txt = HTMLtoText($content["content"],100);
                      }
                  }
              }  
              
              // MIKE
              // push $row_html to item_array index 17
              array_push($item_array,$row_html);
              
              $featured = get_post_meta(get_the_Id(), '_featured', true);
              $in = inDateRange($item_array[15],$featured,$meta_query_arr);

              if ($in) array_push($global_array, $item_array);               

              $arrRepeats = createEventRepeats($slider_type,$date_out,$date_in,$lan,$meta_query_arr,$item_array,$optionArr);
              foreach($arrRepeats as $item_array) {
                  //row type
                  $row_txt = "";
                  $row_html = "";
                  if ($mcar_row == "location") { $row_html = "<i class=\"fa fa-map-marker\"></i></span>" . $item_array[5]; $row_txt = $item_array[5]; }
                  if ($mcar_row == "subtitle") { $row_html =  $item_array[3]; $row_txt = $item_array[3]; }
                  if ($mcar_row == "organizer") { $row_html = "<i class=\"fa fa-headphones\" style=\"color: #" . $item_array[10] . "\"></i></span>" . $item_array[6]; $row_txt = $item_array[6]; }
                  if (count($item_array[14]) > 0) {
                      if (($mcar_row == "ef1")|| ($mcar_row == "ef2")|| ($mcar_row == "ef3")) { 
                          $content = "";
                          if ($mcar_row == "ef1") $content = $item_array[14][0];
                          if ($mcar_row == "ef2") $content = $item_array[14][1];
                          if ($mcar_row == "ef3") $content = $item_array[14][2];
                          $row_html = getExtraFieldsHTML($slider_type, $style, $item_array[10],$content); 
                          if ($content["type"] == "button") {
                              $tmp = explode("|", $content["content"]);
                              $row_txt = HTMLtoText($tmp[0],100);
                          } else {
                              $row_txt = HTMLtoText($content["content"],100);
                          }
                      }
                  }
                  // push $row_html to item_array index 18
                  array_push($item_array,$row_html);
              }

              $global_array = array_merge($global_array,$arrRepeats);
          endwhile;  wp_reset_query();                             

            // MIKE: SORT ARRAY based on start_date
            if ($orderby == 'asc') usort($global_array, 'sort_by_date_in_asc');
            else usort($global_array, 'sort_by_date_in_desc');
                
            foreach($global_array as $item_array) {        
            ?> 
            <li>
                <?php $fullid = $id . '_' . $eo_index. "_eo_s3_item" ?>
                <div id="<?php echo $fullid ?>" class="eo_s3_box <?php if ($mcar_image=="yes") echo "eo_s3_img"; else echo "eo_s3_noimg"; ?>"  style="border-top: 2px solid #<?php echo $item_array[10]; ?>">
                    <div class="box_overlaybox_s3">
                       <div class="eo_s3_prebutton_open"><div class="eo_s3_button_open" onclick="showEventOESAinit('<?php echo $eo_index ?>','<?php echo $id; ?>',<?php echo $id. "_eo_js_array"; ?>,'<?php echo $open_type ?>','<?php echo $c_dir ?>','<?php echo $fullid ?>')"><?php echo $lan_arr_eosa["open_event"]; ?></div></div> 
                    </div>
                   <?php  if ($mcar_image=="yes") { ?> 
                      <div class="eo_s3_image" style="background-image:url(<?php $urlArr = wp_get_attachment_image_src( get_post_thumbnail_id($item_array[17]), array( 100,100 ), true, '' ); if (strpos($urlArr[0],'default.png') == false) echo $urlArr[0]; else echo $plugin_url . '/eventon-slider-addon/assets/images/default-cover.jpg'; ?>);"></div>
                   <?php } ?>
                    <div class="eo_s3_box0 ">
                        <div class="eo_s3_row1"><?php echo $item_array[8] ?></div>
                        <div class="row_s3_box1">
                            <div class="eo_s3_row2"><?php echo $item_array[2]; ?></div>
                            <div class="eo_s3_row3"><?php echo $item_array[18] ?></div>
                        </div>
                    </div>
                    <div class="clear"></div>
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
                    minItems: getGridSize(<?php echo "'" . $id . "','" . $car_itemwidth . "'"; ?>),
                    maxItems: getGridSize(<?php echo "'" . $id . "','" . $car_itemwidth . "'"; ?>),              
                    move: <?php echo $car_move; ?>,
                    start: function (slider) {
                        showSlider('<?php echo $id; ?>');
                        hideNavigationArrow('#<?php echo $id; ?>'); 
                    },
                    before: function (slider) {
                        jQuery('.box_overlaybox_s3').css('display', 'none');
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
