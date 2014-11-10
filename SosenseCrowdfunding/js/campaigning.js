
jQuery(function(){
	jQuery('.option_value').click(function(){
		var get_option_value = jQuery(this).val();
		jQuery('#atcf_custom_price').val(get_option_value);
	});

});

function close_popup(){
	jQuery('.black_div').hide();
	jQuery('.white_div').hide();
}

function show_pop_up(id,op,name){
    //alert(name);
	jQuery('.black_div').show();
	jQuery('#white_div_'+id).show();
	jQuery('#edd_price_option_'+id+'_'+name+' .edd_price_option_'+id).attr('checked','checked');
}