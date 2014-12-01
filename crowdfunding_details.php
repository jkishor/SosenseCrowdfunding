<?php 

function Sales_Goal_add()
{
    add_meta_box( 'Sales-Goal-box-id', 'Crowdfunding Details', 'Sales_Goal_box_cb', 'download', 'side', 'high' );
}

function Sales_Goal_box_cb($post) {
 
	$sales_goal=get_post_meta( $post->ID, 'sales_goal', true );
?>
<p>
						<label for="">Sales Goal:</label>
						<input class="widefat" id="sales_goal" name="sales_goal" type="text" value="<?php echo $sales_goal ; ?>" />
					</p>
					
<?php }


function Sales_Goal_save($post_id){
 
	if( isset( $_POST['sales_goal'] ) )
	update_post_meta( $post_id, 'sales_goal', esc_attr( $_POST['sales_goal'] ) );

}


?>