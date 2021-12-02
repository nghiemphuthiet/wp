// Thêm sản phẩm 
// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_fields' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_fields_save' );

function woo_add_custom_fields() {

  global $woocommerce, $post;
  
  echo '<div class="options_group">';
  

 // Text Field
woocommerce_wp_text_input( 
	array( 
		'id'          => '_text_field', 
		'label'       => __( 'Số cạnh & tỉ lệ', 'woocommerce' ), 
		'placeholder' => 'Nhập số cạnh',
		'desc_tip'    => 'true',
		'description' => __( 'Nhập số cạnh & tỉ lệ: {số cạnh}_{tỉ lệ}', 'woocommerce' ) 
	)
);
  
  echo '</div>';	
}

function woo_add_custom_fields_save( $post_id ){
	
	// Text Field
	$woocommerce_number_edge = $_POST['_text_field'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, '_text_field', esc_attr( $woocommerce_text_field ) );
}

function display_custom_field_value(){
  $value = get_post_meta( get_the_ID(), '_text_field', true);
  if(strlen($value) != null && strlen($value) > 0) {
	echo '<div class="woocommerce-number-edge" style="display:none">'.get_post_meta( get_the_ID(), '_text_field', true ).'</div>';
  }
}
add_action('woocommerce_single_product_summary', 'display_custom_field_value', 22 );

// Tùy chỉnh sản phẩm
add_action( 'woocommerce_single_variation', 'enquiry_form', 30 );
function enquiry_form() {

echo '<button type="button" id="trigger_custom" class="button alt" style="margin-bottom: 20px;">Tùy chỉnh</button>';
echo '<div id="product_custom" style="display:none"><i>Đơn vị: cạnh (mm)</i><div class="product-custom-content"></div></div>';
}
add_action( 'woocommerce_single_variation', 'enquiry_form_1', 40);
function enquiry_form_1() {
  ?>
<style>
	.product-custom-item{
		padding: 8px 16px 8px 0;
	}
	.product-custom-edge{
    width: 50px;
    outline: none;
    padding: 2px 4px;
	}
	.product-custom-content{
		display:flex;
	}
</style>
    <script type="text/javascript">
        jQuery('#trigger_custom').on('click', function(){
        if ( jQuery(this).text() == 'Tùy chỉnh' ) {
            jQuery('#product_custom').css("display","block");
            jQuery("#trigger_custom").html('Hủy');
        } else {
            jQuery('#product_custom').hide();
            jQuery("#trigger_custom").html('Tùy chỉnh');
        }
        });
		var number = jQuery('.woocommerce-number-edge').text().split('_')[0];
		var ratio = jQuery('.woocommerce-number-edge').text().split('_')[1];
		let ne = parseInt(number);
		var a = 97;
		while (ne--) {
		  var div = `<div class="product-custom-item">
						<span>` + String.fromCharCode(a) + `</span>: <input class="product-custom-edge"/>                    
					  </div>`;
                jQuery(".product-custom-content").append(div);
			a++;
		}
    </script>
    <?php    
}