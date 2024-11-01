<?php
$required = isset($options['required'])?$options['required']:'';

if($options['price'] != 0)
{
	$price = ':- ('.wc_price( $options['price'] ).')';
}
else
{
	$price = '';
}

if(isset($_POST['custom-variation'][sanitize_title( $options['name'] )])){

$entered_data = isset($_POST['custom-variation'][sanitize_title( $options['name'] )])?$_POST['custom-variation'][sanitize_title( $options['name'] )]:'';
$entered_data = str_replace('\"','"',$entered_data);
$entered_data = str_replace("\'","'",$entered_data);
	
}else{
	$entered_data = '';
}

	$hhyttarw_val=strtolower(str_replace(' ','-',$options['name'] ));
	//	$val_post =  $_POST[ $hhyttarw_val) ];
?>

<p class="phoen_minss phoenwwe_<?php echo $variation_ids; ?> form-row form-row-wide custom_<?php echo sanitize_title( $options['name'] ); ?>" style="display:none;" >
	
	<?php if ( ! empty( $options['label'] ) ) : ?>
		<label><?php echo wptexturize( $options['label'] ) . ' ' . $price; 
		if($required == 1)
		{
			?>
				<abbr title="required" class="required">*</abbr>
			<?php
		}
		?>
		</label>
	<?php endif; ?>
	<input type="text" class="input-text custom-variation custom_field" data-price="<?php echo $options['price'] ? $options['price'] : '0'; ?>" name="custom-variation[<?php echo $variation_ids; ?>][<?php echo sanitize_title( $hhyttarw_val ); ?>]" value="<?php if( ! empty($entered_data) ){ echo $entered_data; } ?>" <?php if ( ! empty( $options['max'] ) ) echo 'maxlength="' . $options['max'] .'"'; ?>  />
</p>