<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


	$woo_var_option_plugin =  get_option( 'woo_var_option_plugin' );

	if($woo_var_option_plugin == 1) {
		
		add_filter( 'woocommerce_add_cart_item',  'phoen_add_var_cart_item' , 20, 1 );

		// Load cart data per page load
		add_filter( 'woocommerce_get_cart_item_from_session', 'phoen_get_cart_item_var_from_session' , 20, 2 );

		// Get item data to display
		add_filter( 'woocommerce_get_item_data',  'phoen_get_item_var_data' , 10, 2 );

		// Add item data to the cart
		add_filter( 'woocommerce_add_cart_item_data',  'phoen_add_to_var_cart_product' , 10, 2 );

		// Validate when adding to cart
		add_filter( 'woocommerce_add_to_cart_validation',  'phoen_validate_add_var_cart_product' , 10, 3 );

		// Add meta to order
		add_action( 'woocommerce_add_order_item_meta',  'phoen_order_item_var_meta' , 10, 2 );
	
	}
		
		add_action('admin_menu', 'phoen_register_custom_variation',99);
		
		function phoen_register_custom_variation() {
		
			add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, PHOEN_CUSTOM_VARIATION_DIR_URL.'assets/images/logo-wp.png', 57 );
        
			add_submenu_page( 'phoeniixx', 'Variation Options', 'Variation Options', 'manage_options', 'phoen_variation_options_setting', 'phoen_variation_options_setting' ); 
		
		}
		
		function phoen_variation_options_setting() {
			
			if( !empty( $_POST['submit'] )  && sanitize_text_field( $_POST['submit'] ) ) {
				
				
				if ( ! isset( $_POST['phoe_custom_options_var_setting_nonce'] ) || ! wp_verify_nonce( $_POST['phoe_custom_options_var_setting_nonce'], 'phoe_custom_var_setting_submit' ) ) 
				{

				   print 'Sorry, your nonce did not verify.';
				   exit;

				}
				else
				{
					
					
						
						$checkco =isset($_POST['checkco'] )? sanitize_text_field(  $_POST['checkco'] ):0;
												
						update_option( 'woo_var_option_plugin', $checkco );
				
						$showot =isset($_POST['showot'] )? sanitize_text_field(  $_POST['showot'] ):0;
						
						update_option( 'woo_custom_var_option_optn_total', $showot );
						
						$showft =isset($_POST['showft'] )? sanitize_text_field(  $_POST['showft'] ):0;
						
						update_option( 'woo_custom_var_option_fnl_total', $showft );
					
				}

			}

			?>
			
			<div id="profile-page" class="wrap">
			
				<?php
				
					$woo_var_option_plugin =  get_option( 'woo_var_option_plugin' );
					
					$woo_custom_var_option_optn_total =  get_option( 'woo_custom_var_option_optn_total' );
					
					$woo_custom_var_option_fnl_total =  get_option( 'woo_custom_var_option_fnl_total' );
					
					if( isset( $_GET['tab'] ) ) {
	
						$tab = sanitize_text_field( $_GET['tab'] );
						
					}
					else
					{
						
						$tab = '';
						
					}

				?>
				<h2>
					
					<?php _e('Woocommerce Custom Fields For Variation - Plugin Options', 'custom-variation'); ?>
					
				</h2>
				<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
					<a class="nav-tab <?php if($tab == 'general' || $tab == ''){ echo ( "nav-tab-active" ); } ?>" href="?page=phoen_variation_options_setting&amp;tab=general"><?php _e('General', 'custom-variation'); ?></a>
					<a class="nav-tab <?php if($tab == 'Premium' || $tab == ''){ echo ( "nav-tab-active" ); } ?>" href="?page=phoen_variation_options_setting&amp;tab=Premium"><?php _e('Premium', 'custom-variation'); ?></a>
				</h2>
					
					<?php 
                        
                        $plugin_dir_url =  plugin_dir_url( __DIR__ );
                        
						if($tab == 'general' || $tab == '')
						{
						  
                          
							?>
							
							<div class="meta-box-sortables" id="normal-sortables">
									<div class="postbox " id="pho_wcpc_box">
										<h3><span class="upgrade-setting">Upgrade to the PREMIUM VERSION</span></h3>
										<div class="inside">
											<div class="pho_check_pin">

												<div class="column two">
													<!----<h2>Get access to Pro Features</h2>----->

													<p>Switch to the premium version of Woocommerce Custom Fields For Variation - Plugin Options</p>

														<div class="pho-upgrade-btn">
															<a href="https://www.phoeniixx.com/product/woocommerce-custom-fields-for-variation/" target="_blank"><img src="<?php echo $plugin_dir_url; ?>assets/images/premium-btn.png" /></a>
														<a target="blank" href="http://customvariationpro.phoeniixxdemo.com/shop/"><img src="<?php echo $plugin_dir_url; ?>assets/images/button2.png" /></a>
														</div>
												</div>
											</div>
										</div>
									</div>
								</div>	
  
							<form novalidate="novalidate" method="post" action="" >
							<?php wp_nonce_field( 'phoe_custom_var_setting_submit', 'phoe_custom_options_var_setting_nonce' ); ?>
							<table class="form-table">

								<tbody>

									<h3><?php _e('General Options', 'custom-variation'); ?></h3>
									
									<tr class="user-nickname-wrap">

										<th><label for="checkco"><?php _e('Enable Custom Options', 'custom-variation'); ?></label></th>

										<td><input type="checkbox" value="1" <?php if($woo_var_option_plugin == 1){ echo "checked"; }  ?> id="checkco" name="checkco" ></label></td>

									</tr>
									
									<tr class="user-nickname-wrap">

										<th><label for="showot"><?php _e('Show Options Total', 'custom-variation'); ?></label></th>

										<td><input type="checkbox" value="1" <?php if($woo_custom_var_option_optn_total == 1){ echo "checked"; } ?> id="showot" name="showot" ></label></td>

									</tr>
									
									<tr class="user-nickname-wrap">

										<th><label for="showft"><?php _e('Show Final Total', 'custom-variation'); ?></label></th>

										<td><input type="checkbox" value="1" <?php if($woo_custom_var_option_fnl_total == 1){ echo "checked"; } ?> id="showft" name="showft" ></label></td>

									</tr>
									
								</tbody>	

							</table>
							
							
							<p class="submit"><input type="submit" value="Save" class="button button-primary" id="submit" name="submit"></p>
							</form>
							
							<style>
							h3 {
								padding: 10px;
							}

								.phoe_video_main {
									padding: 20px;
									text-align: center;
								}
								
								.phoe_video_main h3 {
									color: #02c277;
									font-size: 28px;
									font-weight: bolder;
									margin: 20px 0;
									text-transform: capitalize
									display: inline-block;
								}
							</style>
								
							<?php
						}elseif($tab == 'Premium' ){
							include_once(plugin_dir_path(  __FILE__).'pro_tab_inn.php');
						} 
						
						
						
						?>
				</div>
				
			<?php
		
		}
		
		function phoen_add_to_var_cart_product( $cart_item_data,$product_id ) {
				
				
				if ( empty( $cart_item_data['options'] ) ) {
					
					$cart_item_data['options'] = array();
					
				}
					$variations_id=isset($_POST['variation_id'])?$_POST['variation_id']:'';
		
				
				$vart_data=get_post_meta( $variations_id, 'phoen_variation_data', true);
				
				
				if(isset($vart_data) && is_array($vart_data)){
					
					foreach ( $vart_data as $options ) {
				
							$hhyttarw_val=strtolower(str_replace(' ','-',$options['name'] ));
							
							$val_post =  isset($_POST['custom-variation'][$variations_id][$hhyttarw_val])?$_POST['custom-variation'][$variations_id][$hhyttarw_val]:'';
					
						if($val_post != '')
						{
							$data[] = array(
								'name'  => $options['label'],
								'value' => $val_post,
								'price' => $options['price']
							);
						
							$cart_item_data['options'] =  $data;
						}
							
					}
					
				}
					
				return $cart_item_data;
					
		}
			
		function phoen_validate_add_var_cart_product(  $passed, $product_id, $quantity ) {
		
			global $woocommerce;
			
			$variations_id=isset($_POST['variation_id'])?$_POST['variation_id']:'';
			
			$vart_data=get_post_meta( $variations_id, 'phoen_variation_data', true);
			
			if(isset($vart_data) && is_array($vart_data)){
				
				foreach ( $vart_data as $options_key => $options ) {
			
						
					$post_data =  isset($_POST['custom-variation'][$variations_id][sanitize_title( $options['name'] )])?$_POST['custom-variation'][$variations_id][sanitize_title( $options['name'] )]:'';
					
					if( $options['required'] == 1  )
					{
						if ( $post_data == "" && strlen( $post_data ) == 0 ) {
							
							$data = new WP_Error( 'error', sprintf( __( '"%s" is a required field.', 'custom-variation' ), $options['label'] ) );
							
								wc_add_notice( $data->get_error_message(), 'error' );
								
								$data_msg = 1;
						}
						
					}
					if ( strlen( $post_data ) > $options['max'] && $options['max']!='' ) {
						
						$data = new WP_Error( 'error', sprintf( __( 'The maximum allowed length for "%s" is %s letters.', 'custom-variation' ), $options['label'], $options['max'] ) );
						
						wc_add_notice( $data->get_error_message(), 'error' );
						
						$data_msg = 1;
					}
						
				}
				
			}
			
			if(isset($data_msg) && $data_msg == 1)
			{
				return false;
			}
						
				return $passed;
					
		}
		
		function phoen_get_item_var_data( $other_data, $cart_item_data ) {
			
			if ( ! empty( $cart_item_data['options'] ) ) {
				
				foreach ( $cart_item_data['options'] as $options ) {
									
					$name = $options['name'];

					if ( $options['price'] > 0 ) {
						
						$name .= ' (' . wc_price( get_var_product_addition_options_price ( $options['price'] ) ) . ')';
					
					}

					$other_data[] = array(
						'name'    => $name,
						'value'   => $options['value'],
						'display' => ''
					);
				}
			}
			return $other_data;
		}
		

		function phoen_add_var_cart_item($cart_item_data) {
		
			if ( ! empty( $cart_item_data['options'] ) ) {

				$extra_cost = 0;

				foreach ( $cart_item_data['options'] as $options ) {
					
					if ( $options['price'] > 0 ) {
						
						$extra_cost += $options['price'];
						
					}
				}

				// $cart_item_data['data']->adjust_price( $extra_cost );
				
				$cart_item_data['data']->set_price( $extra_cost +$cart_item_data['data']->get_price());
			}

			return $cart_item_data;
		}


		function phoen_get_cart_item_var_from_session($cart_item_data, $values) {
			
			if ( ! empty( $values['options'] ) ) {
				
				$cart_item_data['options'] = $values['options'];
				
				$cart_item_data = phoen_add_var_cart_item( $cart_item_data );
				
			}
			return $cart_item_data;
		}

		

		function phoen_order_item_var_meta($item_id,$values) {
					
			if ( ! empty( $values['options'] ) ) {
				
				foreach ( $values['options'] as $options ) {

					$name = $options['name'];

					if ( $options['price'] > 0 ) {
						
						$name .= ' (' . wc_price( get_var_product_addition_options_price( $options['price'] ) ) . ')';
					}

					  woocommerce_add_order_item_meta( $item_id, $name, $options['value'] );
					
				}
				
			}
			
		}
		
		function get_var_product_addition_options_price( $price ) {
			
			global $product;

			if ( $price === '' || $price == '0' ) {
				
				return;
				
			}

			if ( is_object( $product ) ) {
				
				$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
				
				$display_price    = $tax_display_mode == 'incl' ? $product->get_price_including_tax( 1, $price ) : $product->get_price_excluding_tax( 1, $price );
			
			} else {
				
				$display_price = $price;
				
			}

			return $display_price;
		}
?>