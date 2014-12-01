<?php 
$enable_grid = get_post_meta( $dealId, 'enable_grid' ,true);
	if($enable_grid == 1) {
	 $rename_raised = get_post_meta( $dealId, 'rename_raised', true ) ;
	$rename_raised = $rename_raised ? $rename_raised : 'Raised';
	
	$rename_funded = get_post_meta( $dealId, 'rename_funded', true );
	
	$rename_funded = $rename_funded ? $rename_funded : 'Funded';
	
	$payement_status = get_post_meta( $dealId, 'payement_status', true );
	$payement_status = $payement_status ? $payement_status : 'publish';
	
		$status = $payement_status;
		$purchase_count=0;
		$pstatus = $status;
		if($pstatus == 'discount')  {
			$status = 'publish';
		}
		$pays = 0;
		$args = array(
				'post_type'       => 'edd_payment',
				'post_status'     => $status,
				'posts_per_page' => -1
			);
		query_posts( $args );		
		while ( have_posts() ) : the_post();
			$meta_values = get_post_meta( get_the_ID(),'_edd_payment_total' );
			//$dealId = 645;
			$cart_values = edd_get_payment_meta_cart_details( get_the_ID(), true );
			foreach($cart_values as $cart) {
				
				if($dealId == $cart['id']) {
					if($pstatus == 'discount' && isset($cart['discount']))  {
							$pays = $pays + ($cart['subtotal'] + $cart['discount']);
						} else {
							$pays = $pays + $cart['subtotal'];
						}
						$purchase_count++;
				}
			}			
			//echo get_the_ID()." - ".$meta_values[0]."<br/>";
			
		endwhile;

		// Reset Query
		wp_reset_query();?>

	<?php	
		global $post;
		$post = get_post(); 
					$pmeta = get_post_meta($dealId); 
					$goaldata = $pmeta['sales_goal'][0];
					//echo($goaldata);
					$country = $pmeta['ecpt_country'][0];
					//echo '<pre>';print_r($goaldata).'<br>';?>
					<!--<div class="country"><?php //echo $country.'<br>';?></div>-->
					
					<div class="progressbarcontainer1"><div id="progess_only_bar_<?php echo $dealId; ?>" class="progressbar2"></div></div>
					<?php
					 $raised = $pays; //edd_get_download_earnings_stats( get_the_ID() );
					 $percent = round(($raised/$goaldata) * 100);
	?><div>
		<script>
		jQuery(document).ready(function() {
			setonlyProgress(<?php echo $percent; ?>, <?php echo $dealId; ?> );	
		});
		</script>	
		</div>
				<?php
	}