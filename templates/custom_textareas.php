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

$entered_data = isset($_POST['custom-variation'][sanitize_title( $options['name'] )])?$_POST['custom-variation'][sanitize_title( $options['name'] )]:'';

$hhyttarw_val=isset($options['name'])?strtolower(str_replace(' ','-',$options['name'] )):'';
?>

<p class="phoen_minss phoenwwe_<?php echo $variation_ids; ?> form-row form-row-wide custom_<?php echo sanitize_title( $options['name'] ); ?>" style="display:none;">
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
	<textarea class="input-text custom-variation custom_textarea" data-price="<?php echo $options['price'] ? $options['price'] : '0'; ?>" name="custom-variation[<?php echo $variation_ids; ?>][<?php echo sanitize_title( $hhyttarw_val ); ?>]"  <?php if ( ! empty( $options['max'] ) ) echo 'maxlength="' . $options['max'] .'"'; ?> ><?php if( ! empty($entered_data) ){ echo $entered_data; } ?></textarea>
</p>