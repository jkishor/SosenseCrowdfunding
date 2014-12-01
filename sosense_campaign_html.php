<?php 
$download=edd_get_download($id);
$prices = edd_get_variable_prices($id);
$i=1;
?>
 <div class="cont">
 <?php
 //echo $id.'<pre>';print_r($prices);
if( $prices ) {
	foreach( $prices as $price_id => $price ) {
	$price_name2 = $price['name'];
	$price_name2= str_replace(' ','',$price_name2);
	$price_name2= str_replace(':','',$price_name2);
  ?>
  
  <div class="main_div" style="background:<?php echo $boxcolor;?>; height:<?php echo $height;?>" onclick="show_pop_up('<?php echo $id;?>','<?php echo $i;?>','<?php echo strtolower($price_name2);?>');">
  
	<div class="download_title" style="font: normal 22px/1 'Crete Round', serif;margin: 0;"><h3 style="color: #ffffff;"><?php echo $price_name=$price['name']; ?></h3></div>
	
	<div class="download_price" style="font: normal 22px/1 'Crete Round', serif;color: #ffffff;
		margin: 0;">
		<h3 style="color: #ffffff;"><?php 
		//echo '<pre>';print_r($price);
		$price_amount=$price['amount'];
		$price_description=$price['description'];
		echo  edd_currency_filter(edd_format_amount($price_amount)); ?>
		</h3>
	</div>
	
	<div class="download_content" style="margin: 15px 0 0;color: #ffffff;">
	<?php echo $price_description; ?></div>
	
  </div>

  <?php
  $i++;
	}
}
?>
</div>
	<div class="black_div" style="display:none;"></div>
	<?php //echo $id.'<pre>';print_r($prices); ?>
	<div class="white_div" id="white_div_<?php echo $id;?>" style="display:none;">
		<button type="button" class="close" onclick="close_popup()">×</button>
		<div class="pop_heading"><h3 style="color:#E61630;"><?php echo $download->post_title; ?></h3></div>
		<div class="input_and_button">
			<div class="purchase_form">
			<?php 
			$arg=array(
				'download_id' => $id,
				'price'       => (bool) true
				);
			echo edd_get_purchase_link($arg); ?>
			</div>
		</div>

	</div>
