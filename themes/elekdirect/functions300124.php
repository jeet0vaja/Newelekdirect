<?php
/**
 * ElekDirect Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ElekDirect
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ELEKDIRECT_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'elekdirect-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ELEKDIRECT_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

add_filter( 'wp_all_import_auto_create_csv_headers', 'wpai_wp_all_import_auto_create_csv_headers', 10, 2 ); 
function wpai_wp_all_import_auto_create_csv_headers( $create_headers, $import_id ){ 
    // Return true to auto-generate header, or false to use the header in the file.
    $create_headers = false;
    return $create_headers;
}

add_filter( 'dgwt/wcas/indexer/searchable_set_items_count', function ( $count ) {
    return 10;
} );
add_filter( 'dgwt/wcas/indexer/readable_set_items_count', function ( $count ) {
    return 5;
} );
add_filter( 'dgwt/wcas/indexer/taxonomy_set_items_count', function ( $count ) {
    return 10;
} );
add_filter( 'dgwt/wcas/indexer/variations_set_items_count', function ( $count ) {
    return 5;
} );

function icecatlive_product_page() {
    global $product;
    if ($product && (is_product() || is_product_category())) { 
        $product_id = $product->get_id();
        $sku = $product->get_sku();
        $mpn = get_field('bmg_mpn', $product_id);
        $ean = get_field('bmg_ean', $product_id);
    
        $terms = get_the_terms($product_id, 'product_brand');
    
        if ($terms && !is_wp_error($terms)) {
            $brand = $terms[0]->name;
        }
        ?>
    
        <script type="text/javascript"> 
            window.addEventListener('liveload', function() {
                IcecatLive.getDatasheet(
                    {
                        //'title':'#Container1',
                        'essentialinfo':'#bmg-essentialinfo',
                        'bulletpoints':'#bmg-bulletpoints',
                        // 'marketingtext':'#Container3',
                        'manuals':'#bmg-manuals',
                        'reasonstobuy':'#bmg-reasonstobuy',
                        // 'reviews':'#Container6',
                        'featuregroups':'#bmg-featuregroups',
                        // 'gallery':'#Container8', 
                        'featurelogos':'#bmg-featurelogos', 
                        // 'tours3d':'#Container10',
                        'videos':'#bmg-videos'
                        // 'productstory':'#Container12'
                    }, 
                    {
                    Brand: '<?php echo $brand; ?>',
                    PartCode: '<?php echo $mpn; ?>',
                    GTIN: '<?php echo $ean; ?>',
                    UserName: 'NWDSAO'
                }, 'en');

            
                IcecatLive.getDatasheet(
                    {
                        'manuals':'#bmg-downloads'
                    }, 
                    {
                    Brand: '<?php echo $brand; ?>',
                    PartCode: '<?php echo $mpn; ?>',
                    GTIN: '<?php echo $ean; ?>'
                    UserName: 'NWDSAO'
                }, 'en');

                // IcecatLive.applyCustomCSS(
                //     'https://elek.nwdesignstudios.co.uk/wp-content/themes/elekdirect/assets/css/icecat_live_custom.css'
                // );

            });
        </script>
    
        <?php
    }
}
add_action('wp_head', 'icecatlive_product_page');

function icecatlive_product_page_footer() {
    ?>
        <script>
           jQuery(document).ready(function($) {
                $('.bmg-energy ').each(function(i) {
                    $(this).find('.-manuals-container > div:eq(0) .-icecat-ds_data.-text a').text("Product data sheet");
                    $(this).find('.-manuals-container > div:not(:eq(0))').hide();
                });
                $('.bmg-sidebar-filters-scroll').on('scroll', function() {
                    if ($(this).scrollTop() === 0) {
                        $('.bmg-sidebar-filters-header').removeClass('bmg-scroll-to-top');
                    } else {
                        $('.bmg-sidebar-filters-header').addClass('bmg-scroll-to-top');
                    }
                });
                $('.bmg-reset-button').on('click', function() {
                    $('.prdctfltr_buttons input').click();
                });
            });
            jQuery(document).on( 'prdctfltr-reload', function() {
                setTimeout(
                function() 
                    {
                    jQuery('.bmg-energy ').each(function(i) {
                    jQuery(this).find('.-manuals-container > div:eq(0) .-icecat-ds_data.-text a').text("Product data sheet");
                    jQuery(this).find('.-manuals-container > div:not(:eq(0))').hide();
                });
                }, 1500);
            });
            

        </script>
        <?php
    if (is_product()) { ?>
    <script>
        jQuery(document).ready(function($) {
             // Initially hide the collapsible divs
            $("#icecatLiveFeatureGroups .-icecat-tableRow").hide();
            
            $(".-icecat-tableRowHead").each(function() {
                // Wrap existing content in a div
                $(this).html('<div class="table-head-title">' + $(this).html() + '<span class="toggle-sign">+</div></div>');

            });

            $(".-icecat-tableRowHead").click(function() {
                // This will select the following siblings of the same parent
                // and toggle (show/hide) them when the table row head is clicked.
                $(this).nextUntil('.-icecat-tableRowHead').slideToggle('fast');

                // Change '+' to '-' when expanded and vice versa
                if ($(this).find('.toggle-sign').text() === '+') {
                    $(this).find('.toggle-sign').text('-');
                    $(this).find('.table-head-title').css('width', '200%');
                } else {
                    $(this).find('.toggle-sign').text('+');
                    $(this).find('.table-head-title').css('width', '100%');
                }
            });

            if (($("#bmg-reasonstobuy:empty").length > 0) || ($("#bmg-videos:empty").length > 0)) {
                $('.bmg-features-title').hide();
            }else{
                $('.bmg-features-title').show();
            }
    
        });
        </script>
        <?php
    } ?>
    <script src="https://live.icecat.biz/js/live-current-2.js"></script>
    <?php
}
add_action('wp_footer', 'icecatlive_product_page_footer');

add_action( 'woocommerce_product_options_pricing', 'bmg_add_RRP_to_products' );      
 
function bmg_add_RRP_to_products() {          
woocommerce_wp_text_input( array( 
'id' => 'rrp', 
'class' => 'short wc_input_price', 
'label' => __( 'RRP', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
'data_type' => 'price', 
) 
);      
}

add_action( 'save_post_product', 'bmg_save_RRP' );
  
function bmg_save_RRP( $product_id ) {
    global $typenow;
    if ( 'product' === $typenow ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( isset( $_POST['rrp'] ) ) {
            update_post_meta( $product_id, 'rrp', $_POST['rrp'] );
        }
    }
}

//add_action( 'woocommerce_after_shop_loop_item_title', 'bmg_display_RRP', 9 );
add_shortcode( 'rrp_display', 'bmg_display_RRP' ); 
function bmg_display_RRP() {
    global $post;
    $output = '';
    if (is_product()) {
        $product = wc_get_product($post->ID);
        if ( $product->get_type() <> 'variable' && $rrp = get_post_meta( $product->get_id(), 'rrp', true ) ) {
            $output .= '<div class="woocommerce_rrp">';
            $output .= _e( 'RRP: ', 'woocommerce' );
            $output .= '<span>' . wc_price( $rrp ) . '</span>';
            $output .= '</div>';
        }
    }
   return $output;
}

/**
 * Custom Archive Product Shortcode
 */
function bmg_archive_product_shortcode($atts) {
    ob_start();
    global $product;
    // Query parameters

    $category_id = get_queried_object_id();

    $atts = shortcode_atts(
        array(
            //'category' => '',
            'per_page' => '12',
            'columns' => '4'
        ),
        $atts,
        'custom_product_archive'
    );

    $query_args = array(
        'post_type'      => 'product',
        'posts_per_page' => $atts['per_page'],
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
            ),
        ),
    );

    $query = new WP_Query($query_args);

    // Output the products
    if ($query->have_posts()) {
        woocommerce_product_loop_start();

        while ($query->have_posts()) {
            $query->the_post(); 

            $link = get_permalink( $query->post->ID );
            $product = wc_get_product(get_the_ID()); 
            $stock_status = $product->get_stock_status();
            $key_features = get_field('bmg_key_features');
            $energy_image = get_field('bmg_energy_rating_badges');
            $energy_doc = get_field('bmg_energy_rating_doc');
            $sku = $product->get_sku();
            $mpn = get_field('bmg_mpn', $product->get_id());
            $ean = get_field('bmg_ean', $product->get_id());
            $rrp = get_post_meta( $product->get_id(), 'rrp', true );
            $terms = get_the_terms( $product->get_id(), 'product_brand' );
            $damage = get_field('bmg_condition_of_product');
            $categories = get_the_terms( get_the_ID(), 'product_cat' );
    
            if ( $terms && ! is_wp_error( $terms ) ) {
                $brand = $terms[0]->name;
            }
            ?>
        <!-- <script type="text/javascript"> 
                window.addEventListener('liveload', function() {
                    IcecatLive.getDatasheet(
                        {
                            'bulletpoints':'#bullet-<?php echo $ean; ?>',
                            'manuals':'#manuals-<?php echo $ean; ?>',
                            'featurelogos':'#featurelogos-<?php echo $ean; ?>'
                        }, 
                        {
                        Brand: '<?php echo $brand; ?>',
                        PartCode: '<?php echo $mpn; ?>',
                        GTIN: '<?php echo $ean; ?>',
                        UserName: 'NWDSAO'
                    }, 'en');
    
                });
            </script> -->
        <li class="product-listing__item" <?php wc_product_class( '', $product ); ?>>  
            <div class="product-item product-item--b2c product-card product-card--b2c">
                <!-- <a class="whitespace-link" href="<?php echo esc_url( $link ); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> -->
                <div class="flex align-items-center">
                    <div class="flex-25 bmg-mobile-first half-width-padding position-relative">
                        <div class="product-item__thumb">
                            <a class="product-card__image-wrap" href="<?php echo esc_url( $link ); ?>" title="<?php the_title(); ?>">
                                <div class="product-card__border-wrap">
                                    <div class="image-placeholder image-placeholder--1-1">
                                        <picture> <?php
                                        if (has_post_thumbnail()) {
                                            $image_id = get_post_thumbnail_id();
                                            $image_url = wp_get_attachment_image_src($image_id, 'full');
                                            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                        ?>
                                            <img class="product-item__thumb-img" alt="<?php the_title(); ?>" src="<?php echo $image_url[0]; ?>">
                                            <?php 
                                        }
                                        ?>
                                        </picture>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="flex align-items-center justify-content-between">
                            <div class="bmg-energy-wrap">
                                <div id="featurelogos-<?php echo $ean; ?>"></div>
                                <div id="manuals-<?php echo $ean; ?>" class="bmg-energy"></div>
                            </div>
                        </div>
                    </div>
                        <div class="flex-50 bmg-mobile-second">
                            <div class="flex align-items-start justify-content-between mb-2">
                                <div class="flex-100">
                                    <div class="product-item__brand-logo justify-content-flex-start mb-0">
                                        <?php echo do_shortcode('[product_brand]'); ?>
                                    </div>
                                    <a class="product-card__heading-wrap pr-1 mb-0" href="<?php echo esc_url( $link ); ?>" title="<?php the_title(); ?>">
                                        <h3 class="product-card__heading product-name product-name--two-lines js-truncate-lines">
                                            <span class="ellip"><?php the_title(); ?></span>
                                        </h3>
                                    </a>
                                    <div id="bullet-<?php echo $ean; ?>"></div>
                                    <div class="bmg-meta flex justify-content-flex-star">
                                        <?php if ($sku) { ?>
                                        <div class="bmg-meta__item flex">
                                            <div class="bmg-meta__label">SKU: </div>
                                            <div class="bmg-meta__value"> <?php echo $sku; ?></div>
                                        </div>
                                        <?php } ?>
                                        <?php if ( $categories && ! is_wp_error( $categories ) ) { ?>
                                        <div class="bmg-meta__item flex">
                                            <div class="bmg-meta__label">Categories: 
                                                <span class="bmg-meta__value">
                                                <?php foreach ( $categories as $category ) { 
                                                    echo ' <a href="' . get_term_link( $category->term_id, 'product_cat' ) . '">' . $category->name . '</a>, ';
                                                } ?>
                                                </span>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="flex justify-content-between detail-containers">
                                <div class="flex-55 mb-0">
                                    <div id="bullet-<?php //echo $ean; ?>"></div>
                                </div>
                              
                            </div> -->
                        </div>
                        <div class="flex-25 mb-0 bmg-mobile-third">
                        <div class="ml-auto flex-45 flex-shrink product-item__price-container">
                                    <div class="product-item__details">
                                        <div class="ml-auto">
                                            <ul class="prd-price prd-price--default justify-content-flex-start">
                                                <li class="prd-price__now">
                                                <?php
                                                 if ( ! $product->get_price_html() ) {
                                                    echo 'Price not available';
                                                } else {
                                                    echo $product->get_price_html();
                                                }
                                                ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="woocommerce_rrp"> <?php echo _e( 'RRP: ', 'woocommerce' ); ?>
                                    <span><?php echo wc_price( $rrp ); ?></span>
                                </div>
                                <div class="bmg-damage">
                                    <h3>Product damage</h3>
                                    <?php echo do_shortcode('[condition_product]'); ?>
                                </div> 
                                <div id="bmg-cart-btn" class="flex align-items-center ">
                                    <div class="product-item__actions">
                                        <div class="product-item__action product-item__action--add-to-cart">
                                            <div class="actions-container-for-ProductGridComponent">
                                                <?php
                                                    echo apply_filters('woocommerce_loop_add_to_cart_link',
                                                    sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
                                                        esc_url($product->add_to_cart_url()),
                                                        esc_attr($product->get_id()),
                                                        esc_attr($product->get_sku()),
                                                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                        esc_attr($product->get_type()),
                                                        esc_html($product->add_to_cart_text())
                                                    ),
                                                    $product);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bmg-more-details">
                                        <a href="<?php esc_url(get_permalink($product->get_id())) ?>" class="button">More Info</a>';
                                    </div>
                                </div>              
                        </div>
                </div>
            </div>
            
        </li>
        <?php
  }

  woocommerce_product_loop_end();
} else {
  echo __('No products found', 'woocommerce');
}

wp_reset_postdata();

return '<div class="woocommerce">' . ob_get_clean() . '</div>';
}
add_shortcode('custom_archive_product', 'bmg_archive_product_shortcode');

add_shortcode( 'condition_product', 'bmg_condition_product' ); 
function bmg_condition_product() {
    global $post;

    $condition = get_field('bmg_condition_of_product');
    $front = get_field('bmg_front');
    $front_custom = get_field('bmg_front_custom_field');
    $top = get_field('bmg_top');
    $top_custom = get_field('bmg_top_custom_field');
    $left = get_field('bmg_left');
    $left_custom = get_field('bmg_left_custom_field');
    $right = get_field('bmg_right');
    $right_custom = get_field('bmg_right_custom_field');
    $other_conditions = get_field('bmg_other_condition');
    $other_condition_custom = get_field('bmg_other_condition_custom_field');

    $output = '';
    $output .= '<ul class="bmg-product-cond">';
    if ($condition && in_array('front', $condition)) {
        if($front_custom) {
            $output .= '<li><strong>Front: </strong>' . $front_custom . '</li>';
        } else {
            $output .= '<li><strong>Front: </strong>' . $front . '</li>';
        }
    }
    if ($condition && in_array('top', $condition)) {
        if($top_custom) {
            $output .= '<li><strong>Top: </strong>' . $top_custom . '</li>';
        } else {
            $output .= '<li><strong>Top: </strong>' . $top . '</li>';
        }
    }
    if ($condition && in_array('left', $condition)) {
        if($left_custom) {
            $output .= '<li><strong>Left: </strong>' . $left_custom . '</li>';
        } else {
            $output .= '<li><strong>Left: </strong>' . $left . '</li>';
        }
    }
    if ($condition && in_array('right', $condition)) {
        if($right_custom) {
            $output .= '<li><strong>Right: </strong>' . $right_custom . '</li>';
        } else {
            $output .= '<li><strong>Right: </strong>' . $right . '</li>';
        }
    }
    if ($other_conditions) {
        $output .= '<li><strong>Other: </strong>';
        foreach ($other_conditions as $other_condition) {
            if ($other_condition == 'Custom Field') {
                continue;
            }
            $output .= $other_condition . ', ';
  
            }
            $output .= '</li>';
    }   
    if ($other_conditions && in_array('Custom Field', $other_conditions)) {
        $output .= '<li><strong>Other: </strong>' . $other_condition_custom . '</li>';
    }

    $output .= '</ul>';
   return $output;
}

add_shortcode( 'warranty_product', 'bmg_warranty_product' ); 
function bmg_warranty_product() {
    global $post;

    $warranty = get_field('bmg_waranty');
    $custom_warranty = get_field('bmg_custom_warranty');

    $output = '';
    $output .= '<ul class="bmg-product-cond">';
    if ($warranty) {
        if($custom_warranty) {
            $output .= '<li><strong>Warranty: </strong>' . $custom_warranty . '</li>';
        } else {
            $output .= '<li><strong>Warranty: </strong>' .  $warranty . '</li>';
        }
    }   

    $output .= '</ul>';
   return $output;
}

add_shortcode( 'packaging_product', 'bmg_packaging_product' ); 
function bmg_packaging_product() {
    global $post;

    $packaging = get_field('bmg_packaging');
    $custom_packaging = get_field('bmg_custom_packaging');

    $output = '';
    $output .= '<ul class="bmg-product-cond">';
    if ($packaging) {
        if($custom_packaging) {
            $output .= '<li><strong>Packaging: </strong>' . $custom_packaging . '</li>';
        } else {
            $output .= '<li><strong>Packaging: </strong>' .  $packaging . '</li>';
        }
    }   

    $output .= '</ul>';
   return $output;
}

add_shortcode( 'features_product', 'bmg_features_product' ); 
function bmg_features_product() {
    global $post;

    $key_features = get_field('bmg_key_features');

    $output = '';
    $output .= '<div class="bmg-key-features">';
    
    if ( $key_features ) :
        $output .= '<h3>Key Features</h3>';
        $output .= '<ul class="bmg-key-features__list">';
        foreach ( $key_features as $key_feature ) :
            $output .= '<li>';
                                                      
            $text = $key_feature['bmg_key_features_list'];
                                                        
            $output .= $text;
                                                         
            $output .= '</li>';
            endforeach;
        $output .= '</ul>';
    endif;
    $output .= '</div>';
    return $output;
}

//BMG from old elekdirect START
// Display the ACF field in the order edit page
//add_action( 'woocommerce_admin_order_item_headers', 'admin_order_item_headers' );
function admin_order_item_headers() {
    echo '<th>RC Number</th>';
	echo '<th>Online Only</th>';
}

//add_action( 'woocommerce_admin_order_item_values', 'admin_order_item_values', 10, 3 );
function admin_order_item_values( $_product, $item, $item_id = null ) {
    // Get the product
	if(!empty($_product)){  
    	$product_id = $_product->get_id();
	}
    // Get the field value
    $rc_number = get_field( 'rc_number', $product_id );
	$online_only = get_field('bmg_online_only', $product_id);
    // Display the field value
	if( $rc_number ) {
    	echo '<td>' . $rc_number . '</td>';
	}else{
		echo '<td> - </td>';
	}

	if( $online_only && in_array('yes', $online_only) ) {
		echo '<td> Yes </td>';
	}else{
		echo '<td> No </td>';
	}
}

add_action( 'woocommerce_checkout_update_order_meta', 'bmg_custom_checkout_field_update_order_meta' );

function bmg_custom_checkout_field_update_order_meta( $order_id ) {

    $order = wc_get_order( $order_id );
    
    foreach( $order->get_items() as $item_id => $item ) {

        $product_id = $item->get_product_id();

        $rc_number = get_field('rc_number', $product_id);
		$online_only = get_field('bmg_online_only', $product_id);
		$alpha_stock = get_field('bmg_alpha_stock', $product_id); 
		$product_global_identifiers = get_post_meta($product_id, 'sp_wc_barcode_field', true);

        if ( ! empty( $rc_number ) ) {
            update_post_meta( $order_id, 'rc_number_order', $rc_number ); 
			update_post_meta( $order_id, 'bmg_online_only_order', $online_only );
			update_post_meta( $order_id, 'product_global_identifiers_order', $product_global_identifiers );
			update_post_meta( $order_id, 'bmg_alpha_stock_order', $alpha_stock );
        }

    }
}

add_action( 'woocommerce_email_order_details', 'display_alpha_stock_email_order_details', 10, 4 );
function display_alpha_stock_email_order_details( $order, $sent_to_admin, $plain_text, $email ) {
    // Only admin notifications
    if( ! $sent_to_admin )
         return; // Exit

    foreach( $order->get_items() as $item ) {
        if( $alpha_stock = get_field( "bmg_alpha_stock", $item->get_product_id() ) ){
            echo '<p><strong>'.__('Alpha Stock').': </strong>Yes</p>';
        }
    }
}

//BMG from old elekdirect START

//add_filter( 'big_image_size_threshold', '__return_false' );

add_action( 'woocommerce_before_single_product', 'set_default_product_image_from_gallery' );

function set_default_product_image_from_gallery() {
    global $product;
    
    // Get the product gallery image IDs
    $attachment_ids = $product->get_gallery_image_ids();
    
    // Check if there are any gallery images
    if ( $attachment_ids && !has_post_thumbnail( $product->get_id() ) ) {
        // Get the first image ID
        $first_image_id = reset($attachment_ids);
        
        // Set the first gallery image as the featured image (post thumbnail)
        set_post_thumbnail( $product->get_id(), $first_image_id );
    }
}

add_shortcode( 'shipping_badge', 'bmg_shipping_badge' ); 
function bmg_shipping_badge() {
    global $product;
	$product_id = $product->get_id();
	$online_only = get_field('bmg_online_only', $product_id);
    $output = '';
    $output .= '<div class="bmg-shipping-labels">';
    if ( $product->get_shipping_class() === 'free-shipping' ) {
        $output .= '<span class="shipping-badge">Free Shipping</span>';
    }
	if ( $product->get_shipping_class() === 'shipping-costs-20-00' ) {
		$output .= '<span class="shipping-badge">Shipping costs £20.00</span>';
	}
	if ( $product->get_shipping_class() === 'medium-appliances-shipping' ) {
		$output .= '<span class="shipping-badge">Shipping costs £39</span>';
	}
	if ( $product->get_shipping_class() === 'collection-only' ) {
		$output .= '<span class="shipping-badge">Collection Only</span>';
	}
	if( $online_only && in_array('yes', $online_only) ) {
		$output .= '<span class="shipping-badge">Online Only</span>';
	}
    $output .= '</div>';
    return $output;
}

add_shortcode( 'custom_badge', 'bmg_custom_badge' ); 
function bmg_custom_badge() {
	global $product;
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
    $output = '';
    $output .= '<div class="bmg-custom-labels">';
	foreach ( $terms as $term ) {
	  $product_cat = $term->name;
	  if ( $product_cat == 'Non Plumbed' ) {
		$output .= '<span class="new-badge-non-plumbed">Non Plumbed</span>';
	  }
	  if ( $product_cat == 'Plumbed' ) {
		$output .= '<span class="new-badge-plumbed">Plumbed</span>';
	  }
	}
   $output .= '</div>';    
    return $output;
}