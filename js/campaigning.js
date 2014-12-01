
jQuery(function(){
	jQuery('.option_value').click(function(){
		var get_option_value = jQuery(this).val();
		jQuery('#atcf_custom_price').val(get_option_value);
	});
	
	jQuery('.black_div').click(function(){
		jQuery('.black_div').hide();
		jQuery('.white_div').hide();
	});
});

function close_popup(){
	jQuery('.black_div').hide();
	jQuery('.white_div').hide();
}

function show_pop_up(id,op,name){
    //alert(name);
    name = name.replace(/[^\w\s]/gi, '');
	jQuery('.black_div').show();
	jQuery('#white_div_'+id).show();
	jQuery('#edd_price_option_'+id+'_'+op).attr('checked','checked');
}
