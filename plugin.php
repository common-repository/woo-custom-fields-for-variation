<?php
/*
Plugin Name: Woocommerce Custom Fields For Variation
Plugin URI: https://www.phoeniixx.com/product/woocommerce-custom-fields-for-variation/
Description:The plugin helps to create the custom fields for variations in woocommerce.
Version: 1.1.5
Text Domain: custom-variation
Author: phoeniixx
Author URI: http://www.phoeniixx.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
WC requires at least: 2.6.0
WC tested up to: 4.1.0
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Check if WooCommerce is active 
**/

	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
	{
	 
		define("PHOEN_CUSTOM_VARIATION_DIR_URL", esc_url( plugin_dir_url( __FILE__ ) ) );
		
		define('PHOEN_ARBPRPLUGURL',plugins_url(  "/", __FILE__));
		
		include_once( 'classes/class-product-add-to-cart.php' );

		add_action( 'woocommerce_product_after_variable_attributes', 'phoen_variation_options_tab_options', 10, 3 );
		
		function phoen_variation_options_tab_options( $loop, $variation_data, $variation ) {
				
			phoen_css_min();

			global $post;

			$variation_id  = absint($variation->ID);
			
			$variation_id_jh = absint($variation->ID);

			$vart_data = get_post_meta( $variation_id, 'phoen_variation_data', true);
			
			?>
			
			<div id="custom_tab_data_<?php echo  $variation_id;?>" class="panel phoen_new_min woocommerce_options_panel wc-metaboxes-wrapper">
					
					<div id="custom_tab_data_options_<?php echo $variation_id; ?>" class="wc-metaboxes">
					<input type="hidden" name="variation_id[]" value="<?php echo  $variation_id;?>" />
					<?php
						
							$loop = 0;

							foreach ( $vart_data as $option ) {
								
								include( 'custom_options_html.php' );
								//print_r( $option );
								
								$loop++;
							}
						?>

					</div>

				<div class="toolbar">
					
					<button type="button" data-id="<?php echo $variation_id; ?>" class="button add_new_custom_option button-primary"><?php _e( 'New Custom Option', 'custom-variation' ); ?></button>
				
				</div>
				
			</div>
			
			<style>
				#custom_tab_data_<?php echo $variation_id; ?> input {
					
					min-width: 139px;
					
				}
				#custom_tab_data_<?php echo $variation_id; ?> label {
					
					margin: 0;
					
				}
				
				#variable_product_options .phoen_new_min {
					width: 100%;
				}
				
				#variable_product_options .phoen_new_min h3 {
					background-color: #eee;
				}
				
				#variable_product_options .phoen_new_min .woocommerce_product_option {
					margin-bottom: 10px !important;
				}
				
				#variable_product_options .phoen_new_min .woocommerce_product_option table.wc-metabox-content {
					border: 1px solid #eee;
					border-top: none;
				}
				
				#variable_product_options .phoen_new_min .woocommerce_product_option table input[type="checkbox"] {
					min-width: auto;
					width: 18px;
				}
				
				</style>				
			<script type="text/javascript">
				jQuery(function(){

					jQuery('#custom_tab_data_<?php echo $variation_id; ?>').on( 'click', '.add_new_custom_option', function() {
						
						var loop = jQuery('#custom_tab_data_options_<?php echo $variation_id; ?> .woocommerce_product_option').size();
						
						var var_id=jQuery(this).attr('data-id')

						var html = '<?php
							
							ob_start();

							$option['name'] 			= '';
							
							$option['required'] 		= '';
							
							$option['type'] 			= 'custom';
							
							$option['options'] 		= array();
							
							$loop = "{loop}";
							
							$variation_id = "{variation_id}";

							include( 'custom_options_html.php' );
						
							$html = ob_get_clean();
							
							echo str_replace( array( "\n", "\r" ), '', str_replace( "'", '"', $html ) );
						
						?>';
						html = html.replace( /{loop}/g, loop );
						html = html.replace( /{variation_id}/g, var_id );
						//alert(html);
						jQuery('#custom_tab_data_options_<?php echo $variation_id_jh; ?>').append( html );
						
						jQuery('.clear_class'+var_id+loop).val( '' );
					});
					
					
					jQuery('#custom_tab_data_<?php echo $variation->ID ?>').on( 'click', '.remove_option', function() {

							var conf = confirm('<?php _e('Are you sure you want remove this option?', 'custom-variation'); ?>');

							if (conf) {
								
								var option = jQuery(this).closest('.woocommerce_product_option');
								
								//alert( option );
								
								jQuery(option).find('input').val('');
								
								jQuery(option).hide();
								
							}

							return false;
					});
					
				
				});
			</script>
			
		
			<?php
				
		}
		
		
		function phoen_css_min(){
			?>
			<style>
				#variable_product_options .phoen_new_min {
					width: 100%;
				}
				
				#variable_product_options .phoen_new_min h3 {
					background-color: #eee;
				}
				
				#variable_product_options .phoen_new_min .woocommerce_product_option {
					margin-bottom: 10px !important;
				}
				
				#variable_product_options .phoen_new_min .woocommerce_product_option table.wc-metabox-content {
					border: 1px solid #eee;
					border-top: none;
				}
				
				#variable_product_options .phoen_new_min .woocommerce_product_option table input[type="checkbox"] {
					min-width: auto;
					width: 18px;
				}
				
				.phoen_new_min label {
					margin: 0;
					width: 190px;
					text-align: right !important;
					padding-right: 20px;
				}

				.wc-metaboxes-wrapper .woocommerce_product_option h3 select{
					width: 200px !important;
					max-width: 40%;
				}
				</style>
			
			
			<?php
		}
		
		add_action( 'woocommerce_save_product_variation', 'PHOEN_variable_fields_process', 10, 2 ); 
		
		add_action( 'woocommerce_process_product_meta_variable', 'PHOEN_variable_fields_process', 10, 1 );
		
		function PHOEN_variable_fields_process($post_id){
			
			$variation_id= isset($_POST['variation_id'])?array_map( 'sanitize_text_field', $_POST['variation_id'] ):'';
			
			if(isset($_POST) && is_array($variation_id)){
				
				for($m=0;$m <= count($variation_id);$m++){
			
					$vvgat_id=$variation_id[$m];
					
					$product_custom_options=array();
					
					if ( isset( $_POST[ 'product_option_name' ][$vvgat_id] ) && !empty($_POST[ 'product_option_name' ][$vvgat_id]) ) 
					{
						
							
						$option_name  =isset($_POST['product_option_name'][$vvgat_id])? array_map( 'sanitize_text_field', $_POST['product_option_name'][$vvgat_id] ):'';
						
						$option_type  =isset($_POST['product_option_type'][$vvgat_id])? array_map( 'sanitize_text_field', $_POST['product_option_type'][$vvgat_id] ):'';
						
						$option_position  = isset($_POST['product_option_position'][$vvgat_id])?array_map( 'sanitize_text_field', $_POST['product_option_position'][$vvgat_id]):'';
						
						$option_required   =  isset( $_POST['product_option_required'][$vvgat_id] ) ? $_POST['product_option_required'][$vvgat_id] : array();
						
						$option_required = array_map( 'sanitize_text_field', $option_required);
							
						$option_label = isset($_POST['product_option_label'][$vvgat_id])?array_map( 'sanitize_text_field', $_POST['product_option_label'][$vvgat_id]):'';
						
						$option_price = isset($_POST['product_option_price'][$vvgat_id])?array_map( 'sanitize_text_field', $_POST['product_option_price'][$vvgat_id]):'';
						
						$option_max   = isset($_POST['product_option_max'][$vvgat_id])?array_map( 'sanitize_text_field', $_POST['product_option_max'][$vvgat_id]):'';
						 
						
								for ( $i = 0; $i < sizeof( $option_name ); $i++ ) 
								{

									if ( ! isset( $option_name[ $i ] ) || ( '' == $option_name[ $i ] ) ) {
										
										continue;
										
									}
										
										$product_custom_options[]=array(
										'name' => sanitize_text_field( stripslashes( $option_name[ $i ] ) ),
										'type' => sanitize_text_field( stripslashes( $option_type[ $i ] ) ),
										'position' => absint( $option_position[ $i ] ),
										'required' => isset( $option_required[ $i ] ) ? 1 : 0,
										'label' => sanitize_text_field( stripslashes( $option_label[ $i ] ) ),
										'price' => wc_format_decimal( sanitize_text_field( stripslashes( $option_price[ $i ] ) ) ),
										'max' =>  sanitize_text_field( stripslashes( $option_max[ $i ] ) )
										);
		
								}
						
						
						$product_custom_options=array_values($product_custom_options);
				
						update_post_meta( $vvgat_id, 'phoen_variation_data', $product_custom_options);
						
					}
						
					
				}
				
			}
				
				
		} 
	
		        // define the woocommerce_after_variations_form callback 
        function phoen_woocommerce_after_variations_form(  ) { 
		
			$woo_var_option_plugin =  get_option( 'woo_var_option_plugin' );
		
			global $product;
			
			$pro_type = $product->get_type();
			
			$post_id = $product->get_id();
		
			if($pro_type === 'variable' && $woo_var_option_plugin ==1)
			{
			
				phoen_script_var_add();
			
				 $variation_ids = $product->get_children();
				 
				foreach($variation_ids as $variation_ids){
					 
					$vart_data=get_post_meta( $variation_ids, 'phoen_variation_data', true);
					  
					if(isset($vart_data) && is_array($vart_data)){
						  						  
						foreach($vart_data as $key => $options){
						  
							if ( isset($options['name']) && empty( $options['name'] ) ) {
						
								unset( $vart_data[ $key ] );
								
								continue;
										
							}
								
							if( isset($options['type']) && $options['type'] === 'custom_field' )
							{
								
								include('templates/custom_fields.php');
														
							}
							elseif( isset($options['type']) && $options['type'] === 'custom_textarea' )
							{
								
								include('templates/custom_textareas.php');
							
							}
							  
						}
					}
					   
				}
				
				if ( ! isset( $product ) || $product->get_id() != $post_id ) {
					
					$the_product = wc_get_product( $post_id );
					
				} else {
					
					$the_product = $product;
					
				}

				if ( is_object( $the_product ) ) {
					
					$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
					
					$display_price    = $tax_display_mode == 'incl' ? wc_get_price_including_tax($the_product) : wc_get_price_excluding_tax($the_product);
				
				} else {
					
					$display_price    = '';
					
				}

				echo '<div id="product-options-var-total" product-type="' . $the_product->get_type() . '" product-price="' . $display_price . '"></div>';
				
			}
			 
        }
                 
        // add the action 
        add_action( 'woocommerce_before_add_to_cart_button', 'phoen_woocommerce_after_variations_form', 10, 0 ); 
		
        add_action( 'admin_head', 'phoen_script_var_add'); 
		
		function phoen_script_var_add()
		{
					
			$woo_custom_var_option_optn_total =  get_option( 'woo_custom_var_option_optn_total' );
			
			$woo_custom_var_option_fnl_total =  get_option( 'woo_custom_var_option_fnl_total' );

			?>
			<script>
			
			
				var  woocommerce_custom_var_options_params = {
					
					currency_symbol : "<?php echo get_woocommerce_currency_symbol() ?>",
					op_show : "<?php _e('Options Total', 'custom-variation'); ?>",
					ft_show : "<?php _e('Final Total', 'custom-variation'); ?>",
					show_op : "<?php echo $woo_custom_var_option_optn_total ?>",
					show_ft : "<?php echo $woo_custom_var_option_fnl_total ?>",
					num_decimals : "<?php echo absint( get_option( 'woocommerce_price_num_decimals' ) ) ?>",
					decimal_separator : "<?php echo esc_attr( stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ) ) ?>",
					thousand_separator : "<?php echo esc_attr( stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) ) ?>"
					
					
				}
				
				
				
			</script>
			<?php
				wp_enqueue_script( 'phoeniixx_arbpw_min', PHOEN_ARBPRPLUGURL. "assets/js/options.js",array('jquery'),'1.1.0',false);

			// echo "<script src=". plugin_dir_url( __FILE__ ). '/assets/js/options.js' ."></script>";
			
		}
		
		//add_action( 'woocommerce_before_add_to_cart_button', 'my_theme_function_woocommerce_before_add_to_cart_form', 5 );
		
		function phoen_custom_options_var_activate() {

			if(get_option( 'woo_var_option_plugin') == ''){
			
				update_option( 'woo_var_option_plugin', '1');
			}
			if(get_option( 'woo_custom_var_option_optn_total') == ''){
			
				update_option( 'woo_custom_var_option_optn_total', '1');
			}
			if(get_option( 'woo_custom_var_option_fnl_total') == ''){
			
				update_option( 'woo_custom_var_option_fnl_total', '1');
			}
			
		}
		register_activation_hook( __FILE__, 'phoen_custom_options_var_activate' );
		
	}
	else 
	{
		
		add_action('admin_notices', 'phoen_custom_var_options_admin_notice');

		function phoen_custom_var_options_admin_notice() {
			global $current_user ;
				$user_id = $current_user->ID;
				/* Check that the user hasn't already clicked to ignore the message */
			if ( ! get_user_meta($user_id, 'custom_options_ignore_notice') ) {
				echo '<div class="error"><p>'; 
				printf(__('Woocommerce Custom Fields For Variation could not detect an active Woocommerce plugin. Make sure you have activated it. | <a href="%1$s">Hide Notice</a>'), '?phoen_custom_options_nag_ignore=0');
				echo "</p></div>";
			}
		}

		add_action('admin_init', 'phoen_custom_options_var_nag_ignore');

		function phoen_custom_options_var_nag_ignore() {
			global $current_user;
				$user_id = $current_user->ID;
				/* If user clicks to ignore the notice, add that to their user meta */
				if ( isset($_GET['phoen_custom_options_nag_ignore']) && '0' == $_GET['phoen_custom_options_nag_ignore'] ) {
					 add_user_meta($user_id, 'custom_options_ignore_notice', 'true', true);
			}
		}
	}
?>
