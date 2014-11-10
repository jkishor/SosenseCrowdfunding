<?php 
/********************                  Function  to include js                     ************************/

function eddstat_scripts() {
    wp_enqueue_script(
		'eddstatfunding_script',plugins_url('js/funding_stat.js', __FILE__),
		 array('jquery')
	);
	
}


function campaigning_scripts() {
    wp_enqueue_script(
		'campaigning_script',plugins_url('js/campaigning.js', __FILE__),
		 array('jquery')
	);
}
/********************                  Function  to include Css                    ************************/

function sosense_funding() {

	wp_enqueue_style( 'funding_sosensee', plugins_url('salesstyle.css', __FILE__));

}

function campaigning_css() {
	wp_enqueue_style( 'campaigning', plugins_url('campaigning.css', __FILE__));
}

/*********************************************************************/

function child_marketify_edd_widgets_init(){
 register_widget( 'Child_Marketify_Widget_Download_Details' );
}

function my_child_theme_setup() {
	$my_theme = wp_get_theme();
	$my_theme =  $my_theme->get( 'Template' );
	$includewfile = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/'.$my_theme.'-child/widgets.php';
	//echo dirname(__FILE__).'/widgets.php'; exit;
	require_once dirname(__FILE__).'/widgets.php';

}

/************************** Function to Show raised price through shortcode ************************************/

function payments_init() {
	add_shortcode('showpayments', 'load_payments');
	
}

function sosense_campaiging($atts){
	$id =  $atts['id'];
	$boxcolor = $atts['boxcolor'];
	$height= $atts['height'];
	ob_start();
	include(plugin_dir_path( __FILE__ ) . 'sosense_campaign_html.php');
	$var = ob_get_contents();
	ob_end_clean();
	$return = $var;
	return $return;
}

function load_payments($atts) {
	$dealId = $atts['dealid'];
	$pays = 0;
	$args = array(
			'post_type'       => 'edd_payment',
			'post_status'     => 'publish',
			'posts_per_page' => -1
		);
	query_posts( $args );		
	while ( have_posts() ) : the_post();
		$meta_values = get_post_meta( get_the_ID(),'_edd_payment_total' );
		//$dealId = 645;
		if($dealId != 0) {
			$pays = edd_get_download_earnings_stats( $dealId );
		} else {
			$pays = $pays + $meta_values[0];
		}		
		//echo get_the_ID()." - ".$meta_values[0]."<br/>";
		
	endwhile;

	// Reset Query
	wp_reset_query();		
	return $pays;
}



/***********************             Function for Sosense funding stat               ************************/


function payments_init_2() {
	add_shortcode('ShowFundingstat', 'load_payments2');
	add_shortcode('EDD-pricing-options','sosense_campaiging');
}


function load_payments2($atts) {
  
	$dealId = get_the_ID();
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
		//echo 'jugal kishor';
		$post = get_post(); 
					$pmeta = get_post_meta($dealId); 
					$goaldata = $pmeta['sales_goal'][0];
					//echo($goaldata);
					$country = $pmeta['ecpt_country'][0];
					//echo '<pre>';print_r($goaldata).'<br>';?>
					<!--<div class="country"><?php //echo $country.'<br>';?></div>-->
					
					<div class="progressbarcontainer1"><div id="progess_bar_<?php echo $dealId; ?>" class="progressbar1"></div></div>
					<?php
					 $raised = $pays; //edd_get_download_earnings_stats( get_the_ID() );
	?><div>
				<div style="width:30%;float: left;font-weight: bold;">
				<?php  $percent = round(($raised/$goaldata) * 100); echo $percent.'%'.'<div style="font-weight: normal;color: #ADAFB0;">'.$rename_funded.'</div>' ;?>
				</div>
				<div style="font-weight: bold;"><?php
						$pays = edd_format_amount($pays);  
						$pos = strpos($pays, '.');
						if ($pos === false) {
							$pays = $pays;
						} else {
							$pays = substr($pays,0,$pos);
						}
						echo edd_currency_filter($pays);
				
						echo '<div style="font-weight: normal;color: #ADAFB0;">'.$rename_raised.'</div>';?>
				</div>
		<script>
		jQuery(document).ready(function() {
			setProgress(<?php echo $percent; ?>, <?php echo $dealId; ?> );	
		});
		</script>	
		</div>
				<?php
	}
}	

function cd_meta_box_add()
{
    add_meta_box( 'my-meta-box-id', 'Grid statistic', 'cd_meta_box_cb', 'download', 'side', 'high' );
}

function cd_meta_box_cb($post)
{
 
	$enable_grid = get_post_meta( $post->ID, 'enable_grid', true );
	$rename_raised = get_post_meta( $post->ID, 'rename_raised', true );
	$rename_funded = get_post_meta( $post->ID, 'rename_funded', true );
	$payement_status = get_post_meta( $post->ID, 'payement_status', true );
	
?>

                   
					<p>
						<label for="">
						
							<input type="checkbox" id="enable_grid" name="enable_grid" type="text" value="1" <?php if($enable_grid == 1) echo "checked='checked'"; ?>/><b>Enable GRID stats on this download</b>
						</label>
					</p>
					
					<p>
						<label for="">Rename Raised to:</label>
						<input class="widefat" id="rename_raised" name="rename_raised" type="text" value="<?php echo $rename_raised ; ?>" />
					</p>
					
					<p>
						<label for="">Rename Funded (%):</label>
						<input class="widefat" id="rename_funded" name="rename_funded" type="text" value="<?php echo $rename_funded ; ?>" />
					</p>

					
					
		 <p>
			<label for="">Payment Status</label><br/>
			<input type="radio"  id="" name="payement_status" value="publish" <?php if($payement_status == 'publish') echo "checked='checked'";?>/> Complete<br /> 
			<input type="radio"   id="" name="payement_status" value="pending" <?php if($payement_status == 'pending') echo "checked='checked'";?>/> Pending <br /> 
			<input type="radio"   id="" name="payement_status" value="publish,pending" <?php if($payement_status =="publish,pending") echo "checked='checked'";?> /> Complete and Pending both<br />
			<input type="radio"  id="" name="payement_status" value="discount" <?php if($payement_status == "discount") echo "checked='checked'";?>/> include discount codes on completed<br /> 
		 </p>
		 
    <?php  
	
}

function cd_meta_box_save( $post_id )
	{
		 
		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;
		 
		// now we can actually save the data
		$allowed = array( 
			'a' => array( // on allow a tags
				'href' => array() // and those anchors can only have href attribute
			)
		);
		 
		// Make sure your data is set before trying to save it
		if( isset( $_POST['enable_grid'] ) )
			update_post_meta( $post_id, 'enable_grid', wp_kses( $_POST['enable_grid'], $allowed ) );
		else 
			update_post_meta( $post_id, 'enable_grid', wp_kses( 0, $allowed ) );
		
		if( isset( $_POST['rename_raised'] ) )
			update_post_meta( $post_id, 'rename_raised', esc_attr( $_POST['rename_raised'] ) );
			 
			 
		if( isset( $_POST['rename_funded'] ) )
			update_post_meta( $post_id, 'rename_funded', esc_attr( $_POST['rename_funded'] ) ); 
		

		if( isset( $_POST['payement_status'] ) )
			update_post_meta( $post_id, 'payement_status', esc_attr( $_POST['payement_status'] ) ); 
		// This is purely my personal preference for saving check-boxes
		
	}
	
/**********************************END **********************************/	

?>