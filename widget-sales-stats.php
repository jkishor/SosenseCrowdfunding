<?php
/****
Sosense Sidebar Sales Stats Widget
****/

function sosense_sidebar() {

    wp_enqueue_style( 'myprefix-style2', plugins_url('salesstyle.css', __FILE__));

}
add_action( 'wp_enqueue_scripts', 'sosense_sidebar' );

class Child_Marketify_Widget_Download_Details extends WP_Widget {
	public function __construct() {
		parent::__construct(
				'child_marketify_widget_download_details',
				__( 'Sosense Sidebar Sales Stats', 'marketify' ),
				array( 
					'description' => __( 'Display information related to the current download', 'marketify' ),
					'classname'   => 'marketify_widget_download_details'
				)
			);	
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$settings = array(
					'title' => array(
						'type'  => 'text',
						'std'   => 'Product Details',
						'label' => __( 'Title:', 'marketify' )
					),
					
					'goal_name' => array(
						'type'  => 'text',
						'std'   => 'Goal',
						'label' => __( 'Rename Goal to:', 'marketify' )
					),
					'raised_name' => array(
						'type'  => 'text',
						'std'   => 'Raised',
						'label' => __( 'Rename Raised to:', 'marketify' )
					),
					'purchase_name' => array(
						'type'  => 'text',
						'std'   => 'Purchases',
						'label' => __( 'Rename Purchases to:', 'marketify' )
					),
					'comment_name' => array(
						'type'  => 'text',
						'std'   => 'Comments',
						'label' => __( 'Rename Comments to:', 'marketify' )
					),
					'purchase-count' => array(
						'type'  => 'checkbox',
						'std'   => '',
						'label' => __( 'Hide Prchases & Comments', 'marketify' )
					),'hide-avatar' => array(
						'type'  => 'checkbox',
						'std'   => '',
						'label' => __( 'Hide Avatar', 'marketify' )
					),
					'author-name' => array(
						'type'  => 'checkbox',
						'std'   => '',
						'label' => __( 'Hide author name', 'marketify' )
					),
					'show-feature' => array(
						'type'  => 'checkbox',
						'std'   => '',
						'label' => __( 'Show Feature image', 'marketify' )
					)
				);

		foreach ( $settings as $key => $setting ) {
			switch ( $setting[ 'type' ] ) {
				case 'textarea' :
					if ( current_user_can( 'unfiltered_html' ) )
						$instance[ $key ] = $new_instance[ $key ];
					else
						$instance[ $key ] = wp_kses_data( $new_instance[ $key ] );
				break;
				case 'number' :
					$instance[ $key ] = absint( $new_instance[ $key ] );
				break;
				default :
					$instance[ $key ] = sanitize_text_field( $new_instance[ $key ] );
				break;
			}
		}
			$instance[ 'payment_status' ] = sanitize_text_field( $new_instance[ 'payment_status' ] );


         
		return $instance;
		
	}
	
	function form( $instance ) {
		
		$settings = array(
					'title' => array(
						'type'  => 'text',
						'std'   => 'Product Details',
						'label' => __( 'Title:', 'marketify' )
					),
					'goal_name' => array(
						'type'  => 'text',
						'std'   => 'Goal',
						'label' => __( 'Rename Goal to:', 'marketify' )
					),
					'raised_name' => array(
						'type'  => 'text',
						'std'   => 'Raised',
						'label' => __( 'Rename Raised to:', 'marketify' )
					),
					'purchase_name' => array(
						'type'  => 'text',
						'std'   => 'Purchases',
						'label' => __( 'Rename Purchases to:', 'marketify' )
					),
					'comment_name' => array(
						'type'  => 'text',
						'std'   => 'Comments',
						'label' => __( 'Rename Comments to:', 'marketify' )
					),
					'purchase-count' => array(
						'type'  => 'checkbox',
						'std'   => '',
						'label' => __( 'Hide Prchases & Comments', 'marketify' )
					),
					'hide-avatar' => array(
						'type'  => 'checkbox',
						'std'   => '',
						'label' => __( 'Hide Avatar', 'marketify' )
					),
					'author-name' => array(
						'type'  => 'checkbox',
						'std'   => '',
						'label' => __( 'Hide author name', 'marketify' )
					),
					'show-feature' => array(
						'type'  => 'checkbox',
						'std'   => '',
						'label' => __( 'Hide Feature image', 'marketify' )
					)
				);
		foreach ( $settings as $key => $setting ) {

			$value = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting[ 'std' ];
           
			switch ( $setting[ 'type' ] ) {
				case 'text' :
				
				
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting[ 'label' ]; ?></label>
						<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
					</p>
					<?php
				break;
				case 'checkbox' :
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>">
							<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="1" <?php checked( 1, esc_attr( $value ) ); ?>/>
							<?php echo $setting[ 'label' ]; ?>
						</label>
					</p>
					<?php
				break;
			}
		}?>
		 <p>
			<?php  $key = 'payment_status'; ?>
			<label for="<?php echo $this->get_field_id( $key ); ?>">Payment Status</label><br/>
			<input type="radio"  id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" value="publish" checked='checked'  /> Complete<br /> 
			<input type="radio"   id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" value="pending" <?php if(isset($instance['payment_status']) && ($instance['payment_status']=='pending')) echo "checked='checked'"; ?>/> Pending <br /> 
			<input type="radio"   id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" value="publish,pending" <?php if(isset($instance['payment_status']) && ($instance['payment_status']=='publish,pending')) echo "checked='checked'"; ?>/> Complete and Pending both<br />
			<input type="radio"  id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" value="discount"<?php if(isset($instance['payment_status']) && ($instance['payment_status']=='discount')) echo "checked='checked'"; ?> /> include discount codes on completed<br /> 
		 </p>
		<?php
	}
	
	function get_earning_stats($dealId,$status) {
		$pays = 0;
		$purchase_count=0;
		$pstatus = $status;
		if($pstatus == 'discount')  {
			$status = 'publish';
		}
		$args = array(
				'post_type'       => 'edd_payment',
				'post_status'     => $status,
				'posts_per_page' => -1
			);
	  //echo '<pre>';print_r($args);exit;
		query_posts( $args );		
		while ( have_posts() ) : the_post();
			
			$cart_values = edd_get_payment_meta_cart_details( get_the_ID(), true );
			foreach($cart_values as $cart) {
			//echo '<pre>';print_r($cart);
				if($dealId == $cart['id']) {
					if($pstatus == 'discount' && isset($cart['discount']))  {
						$pays = $pays + ($cart['subtotal'] + $cart['discount']);
					} else {
						$pays = $pays + $cart['subtotal'];
					}
					$purchase_count++;
				}
					
			}
           
		endwhile;
        // Reset Query
		wp_reset_query();
		$return['pays'] = $pays;
		$return['purchase'] = $purchase_count;
		
		return $return;
	}
	
	
	function widget( $args, $instance ) {

		global $post;
		
		ob_start();

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$count = isset( $instance[ 'purchase-count' ] ) && 1 == $instance[ 'purchase-count' ]  && $instance[ 'purchase-count' ] ? false : true;
		$avatar=isset( $instance[ 'hide-avatar' ] ) && 1 == $instance[ 'hide-avatar' ] ? false : true;
		$author=isset( $instance[ 'author-name' ] ) && 1 == $instance[ 'author-name' ] ? false : true;
		$feature=isset( $instance[ 'show-feature' ] ) && 1 == $instance[ 'show-feature' ] ? false : true;
		
	    $status = isset($instance[ 'payment_status' ]) ? $instance[ 'payment_status' ] : 'publish';

		echo $before_widget;

		if ( $title ) echo '<h1 class="section-title"><span>' . $title . '</span></h1>';

		//do_action( 'marketify_product_details_widget_before', $instance );

				$post = get_post(); 
				$pmeta = get_post_meta( get_the_ID(), 'sales_goal'); 
				$goaldata = $pmeta[0];
				
				$dealId = get_the_ID();
				//echo $dealId;
				$pays = $this->get_earning_stats($dealId,$status);
				$raised = $pays['pays']; //edd_get_download_earnings_stats( get_the_ID() );
				$percent = round(($raised/$goaldata) * 100);
				
			?>
			<script>
				function setProgress(progress){           
					var progressBarWidth =progress*jQuery(".progressbarcontainer").width()/ 100;
					if(progress < 1) {
						jQuery(".progressbar").width(progressBarWidth).html("<1%");
					} else if(progress >= 100) {
						progressBarWidth = parseInt(jQuery(".progressbarcontainer").width()) + parseInt(7);
						
						jQuery(".progressbar").width(progressBarWidth).html(progress + "% ");
					} else {
						jQuery(".progressbar").width(progressBarWidth).html(progress + "% ");
					}	
				}
				jQuery(document).ready(function() {
					setProgress(<?php echo $percent; ?>);	
				});
				
			</script>
			<div class="download-product-details">
				
				<?php if ($avatar){ 
					$authorUrl = home_url() . '/author/'. get_the_author_meta('ID'); 
				?>
				<div class="download-author">
				<?php printf( '<a class="author-link" href="%s" rel="author">%s</a>', $authorUrl, get_avatar( get_the_author_meta( 'ID' ), 130 ) ); ?>
				</div>
				<?php } ?>
				
				<?php if ($author){ 
				$authorUrl = home_url() . '/author/'. get_the_author_meta('ID'); 
				?>
				<div class="download-author">
				<?php printf( '<a class="author-link" href="%s" rel="author">%s</a>', $authorUrl, get_the_author() ); ?>
					<span class="author-joined"><?php printf( __( 'Author since: %s', 'marketify' ), date_i18n( get_option( 'date_format' ), strtotime( get_the_author_meta( 'user_registered' ) ) ) ); ?></span>
				</div>
				<?php } ?>
				<?php if ($feature){ ?>
				<div>
				<?php echo get_the_post_thumbnail( get_the_ID()); ?>
				</div>
				<?php } ?>
				<!--<div class="download-author">
					<?php //do_action( 'marketify_download_author_before' ); ?>
					<?php //printf( '<a class="author-link" href="%s" rel="author">%s</a>', get_the_author_link(), get_avatar( get_the_author_meta( 'ID' ), 130 ) ); ?>
					<?php //printf( '<a class="author-link" href="%s" rel="author">%s</a>', get_the_author_link(), get_the_author() ); ?>
					<span class="author-joined"><?php //printf( __( 'Author since: %s', 'marketify' ), date_i18n( get_option( 'date_format' ), strtotime( get_the_author_meta( 'user_registered' ) ) ) ); ?></span>
					<?php //do_action( 'marketify_download_author_after' ); ?>
				</div-->
				<div class="progressbarcontainer"><div class="progressbar"></div></div>
				<div class="download-purchases widget-border-bottom">
					<strong><?php $goaldata = edd_format_amount($goaldata);  
						$pos = strpos($goaldata, '.');
						if ($pos === false) {
							$goaldata = $goaldata;
						} else {
							$goaldata = substr($goaldata,0,$pos);
						}
						echo edd_currency_filter($goaldata);
					?>
					</strong>
					<?php 
						if($instance['goal_name'] != "") {
							$goalname = $instance['goal_name'];
						} else {
							$goalname = 'Goal';
						}						
					
					_e( $goalname, 'marketify' ); ?>					
				</div>	
				<div class="download-comments widget-border-bottom">
					<strong><?php 
						$raised = edd_format_amount($raised);  
						$pos = strpos($raised, '.');
						if ($pos === false) {
							$raised = $raised;
						} else {
							$raised = substr($raised,0,$pos);
						}
						echo edd_currency_filter($raised);
						?></strong>
					<?php
						if($instance['raised_name'] != "") {
							$raisedname = $instance['raised_name'];
						} else {
							$raisedname = 'Raised';
						}

					echo _n( $raisedname, $raisedname, edd_get_download_earnings_stats( get_the_ID() ), 'marketify' ); ?>
				</div>
				<?php if ( $count ) {?>
				<div class="download-purchases">
					<strong><?php echo $pays['purchase']; ?></strong>
					<?php 
						if($instance['purchase_name'] != "") {
							$purchasename = $instance['purchase_name'];
						} else {
							$purchasename = 'Purchases';
						}
					
					echo _n( $purchasename, $purchasename, edd_get_download_sales_stats( get_the_ID() ), 'marketify' ); ?>
				</div>
				

				<div class="download-comments <?php echo ! $count ? 'full' : ''; ?>">
					<a href="#comments"><strong><?php echo get_comments_number(); ?></strong>
					<?php 
						if($instance['comment_name'] != "") {
							$commentname = $instance['comment_name'];
						} else {
							$commentname = 'Comments';
						}
					
					
					echo _n( 'Comment', $commentname, get_comments_number(), 'marketify' ); ?></a>
				</div>
<?php } ?>
				<?php //do_action( 'marketify_product_details_after', $instance ); ?>
			</div>
		<?php

		//do_action( 'marketify_product_details_widget_after', $instance );

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		//$this->cache_widget( $args, $content );
	}
}
