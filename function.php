<?php 



// Remove the additional information tab
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
	unset( $tabs['reviews'] ); 
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

 /**
 * Show savings at the cart.
 */
function my_custom_buy_now_save_x_cart() {
	$savings = 0;
	$price_regular = 0;
	foreach ( WC()->cart->get_cart() as $key => $cart_item ) {
		/** @var WC_Product $product */
		$product = $cart_item['data'];
		if ( $product->is_on_sale() ) {
			$savings += ( $product->get_regular_price() - $product->get_sale_price() ) * $cart_item['quantity'];
			$price_regular += ($product->get_regular_price() + 0) * $cart_item['quantity'];
		}
	}
	if ( ! empty( $savings ) ) {
		?>
<tr class="order-regular">
			<th class="order-regular"><?php _e( 'Regular Price :' ); ?></th>
	<td data-title="<?php _e( 'Regular Price :' ); ?>"><span class="order-regular price-regular-total"><?php echo sprintf(wc_price( $price_regular ) ); ?></span></td>
		</tr>
<tr class="order-savings">
			<th class="order-savings"><?php _e( 'Total Savings' ); ?></th>
			<td data-title="<?php _e( 'Total Savings' ); ?>" class="order-savings"><?php echo sprintf( wc_price( $savings ) ); ?></td>
		</tr><?php
	}
}
add_action( 'woocommerce_cart_totals_before_order_total', 'my_custom_buy_now_save_x_cart' );

/*
 * Update quality cart page
 * */ 
add_action( 'woocommerce_after_cart', function() {
   ?>
      <script>
         jQuery(function($) {
            var timeout;
            $('div.woocommerce').on('change textInput input', 'form.woocommerce-cart-form input.qty', function(){
               if(typeof timeout !== undefined) clearTimeout(timeout);
 
               //Not if empty
               if ($(this).val() == '') return;
 
               timeout = setTimeout(function() {
				    $("[name='update_cart']").trigger("click");
				   
               }, 100);
				$( document.body ).on( 'updated_cart_totals', function(){
					//re-do your jquery
					$('.woocommerce-message').hide();
					location.reload();
				});
            }); 
         });
      </script>
   <?php
} );