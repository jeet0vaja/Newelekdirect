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
define('CHILD_THEME_ELEKDIRECT_VERSION', '1.0.0');

/**
 * Enqueue styles
 */
function child_enqueue_styles()
{

    wp_enqueue_style('elekdirect-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ELEKDIRECT_VERSION, 'all');
}

add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);
function defer_parsing_of_js($url)
{
    if (is_user_logged_in()) return $url; // Don't break WP Admin
    if (FALSE === strpos($url, '.js')) return $url;
    return str_replace(' src', ' defer="defer" src', $url);
}
//add_filter('script_loader_tag', 'defer_parsing_of_js', 10);
function load_google_fonts_async()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap', array(), null);
    add_filter('style_loader_tag', 'add_async_attribute', 10, 2);
}
//add_action('wp_enqueue_scripts', 'load_google_fonts_async');

function add_async_attribute($tag, $handle)
{
    if ('google-fonts' !== $handle)
        return $tag;
    return str_replace("rel='stylesheet'", "rel='stylesheet' media='print' onload='this.media=\"all\"'", $tag);
}



add_filter('wp_all_import_auto_create_csv_headers', 'wpai_wp_all_import_auto_create_csv_headers', 10, 2);
function wpai_wp_all_import_auto_create_csv_headers($create_headers, $import_id)
{
    // Return true to auto-generate header, or false to use the header in the file.
    $create_headers = false;
    return $create_headers;
}

add_filter('dgwt/wcas/indexer/searchable_set_items_count', function ($count) {
    return 10;
});
add_filter('dgwt/wcas/indexer/readable_set_items_count', function ($count) {
    return 5;
});
add_filter('dgwt/wcas/indexer/taxonomy_set_items_count', function ($count) {
    return 10;
});
add_filter('dgwt/wcas/indexer/variations_set_items_count', function ($count) {
    return 5;
});

function icecatlive_product_page()
{
    //global $product;
    if (is_product()) {
        $product_id = get_queried_object_id();
        $product = wc_get_product($product_id);

        if ($product instanceof WC_Product) {
            $sku = $product->get_sku();
            $mpn = get_field('bmg_mpn', $product_id);
            $ean = get_field('bmg_ean', $product_id);

            $terms = get_the_terms($product_id, 'product_brand');

            if ($terms && !is_wp_error($terms)) {
                $brand = $terms[0]->name;
            }
            // if ($product instanceof WC_Product) {
            //     $product_id = $product->get_id();
            // if (is_product() || is_product_category()) { 

            //     $sku = $product->get_sku();
            //     $mpn = get_field('bmg_mpn', $product_id);
            //     $ean = get_field('bmg_ean', $product_id);

            //     $terms = get_the_terms($product_id, 'product_brand');

            //     if ($terms && !is_wp_error($terms)) {
            //         $brand = $terms[0]->name;
            //     }
?>

            <script type="text/javascript">
                window.addEventListener('liveload', function() {
                    IcecatLive.getDatasheet({
                        //'title':'#Container1',
                        'essentialinfo': '#bmg-essentialinfo',
                        'bulletpoints': '#bmg-bulletpoints',
                        // 'marketingtext':'#Container3',
                        'manuals': '#bmg-manual',
                        'reasonstobuy': '#bmg-reasonstobuy',
                        // 'reviews':'#Container6',
                        'featuregroups': '#bmg-featuregroups',
                        // 'gallery':'#Container8', 
                        'featurelogos': '#bmg-featurelogo',
                        // 'tours3d':'#Container10',
                        'videos': '#bmg-videos'
                        // 'productstory':'#Container12'
                    }, {
                        Brand: '<?php echo $brand; ?>',
                        PartCode: '<?php echo $mpn; ?>',
                        GTIN: '<?php echo $ean; ?>',
                        UserName: 'NWDSAO',
                    }, 'en');


                    IcecatLive.getDatasheet({
                        'manuals': '#bmg-downloads'
                    }, {
                        Brand: '<?php echo $brand; ?>',
                        PartCode: '<?php echo $mpn; ?>',
                        GTIN: '<?php echo $ean; ?>',
                        UserName: 'NWDSAO',
                    }, 'en');

                    // IcecatLive.applyCustomCSS(
                    //     'https://elek.nwdesignstudios.co.uk/wp-content/themes/elekdirect/assets/css/icecat_live_custom.css'
                    // );

                });
            </script>

            <script type="text/javascript">
                window.addEventListener('liveload', function() {
                    IcecatLive.getDatasheet({
                        //'title':'#Container1',
                        'essentialinfo': '#bmg-essentialinfo_desktop',
                        'bulletpoints': '#bmg-bulletpoints_desktop',
                        // 'marketingtext':'#Container3',
                        'manuals': '#bmg-manual_desktop',
                        'reasonstobuy': '#bmg-reasonstobuy_desktop',
                        // 'reviews':'#Container6',
                        'featuregroups': '#bmg-featuregroups_desktop',
                        // 'gallery':'#Container8', 
                        'featurelogos': '#bmg-featurelogo_desktop',
                        // 'tours3d':'#Container10',
                        'videos': '#bmg-videos_desktop'
                        // 'productstory':'#Container12'
                    }, {
                        Brand: '<?php echo $brand; ?>',
                        PartCode: '<?php echo $mpn; ?>',
                        GTIN: '<?php echo $ean; ?>',
                        UserName: 'NWDSAO',
                    }, 'en');


                    IcecatLive.getDatasheet({
                        'manuals': '#bmg-downloads_desktop'
                    }, {
                        Brand: '<?php echo $brand; ?>',
                        PartCode: '<?php echo $mpn; ?>',
                        GTIN: '<?php echo $ean; ?>',
                        UserName: 'NWDSAO',
                    }, 'en');

                    // IcecatLive.applyCustomCSS(
                    //     'https://elek.nwdesignstudios.co.uk/wp-content/themes/elekdirect/assets/css/icecat_live_custom.css'
                    // );

                });
            </script>
            <style>
                #bmg-featurelogo_desktop .swiper-slide {
                    width: 100% !important;
                    height: auto !important;
                }

                #bmg-featurelogo_desktop .IcecatLive .-icecat-tooltip-containeer>div {
                    position: relative !important;
                    box-shadow: none !important;
                    opacity: 1 !important
                }

                #bmg-featurelogo_desktop .IcecatLive.swiper-container {
                    width: 100% !important;
                }
            </style>

    <?php
        }
    }
}
add_action('wp_head', 'icecatlive_product_page');

function icecatlive_product_page_footer()
{
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
        jQuery(document).on('prdctfltr-reload', function() {
            setTimeout(
                function() {
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

                // if (($("#bmg-reasonstobuy:empty").length > 0) || ($("#bmg-videos:empty").length > 0)) {
                //     $('.bmg-features-title').hide();
                // }else{
                //     $('.bmg-features-title').show();
                // }

            });
        </script>
    <?php
    } ?>
    <script src="https://live.icecat.biz/js/live-current-2.js"></script>

<?php
}
add_action('wp_footer', 'icecatlive_product_page_footer');


add_action('woocommerce_product_options_pricing', 'bmg_add_RRP_to_products');

function bmg_add_RRP_to_products()
{
    woocommerce_wp_text_input(
        array(
            'id' => 'rrp',
            'class' => 'short wc_input_price',
            'label' => __('RRP', 'woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')',
            'data_type' => 'price',
        )
    );
}

add_action('save_post_product', 'bmg_save_RRP');

function bmg_save_RRP($product_id)
{
    global $typenow;
    if ('product' === $typenow) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (isset($_POST['rrp'])) {
            update_post_meta($product_id, 'rrp', $_POST['rrp']);
        }
    }
}

//add_action( 'woocommerce_after_shop_loop_item_title', 'bmg_display_RRP', 9 );
add_shortcode('rrp_display', 'bmg_display_RRP');
function bmg_display_RRP()
{
    global $post;
    $output = '';
    if (is_product()) {
        $product = wc_get_product($post->ID);
        if ($product->get_type() <> 'variable' && $rrp = get_post_meta($product->get_id(), 'rrp', true)) {
            $output .= '<div class="woocommerce_rrp">';
            $output .= _e('RRP: ', 'woocommerce');
            $output .= '<span>' . wc_price($rrp) . '</span>';
            $output .= '</div>';
        }
    }
    return $output;
}

add_shortcode('condition_product', 'bmg_condition_product');
function bmg_condition_product()
{
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
    if ($condition) {
        $output .= '<a href="/glossary/#warranty" class="bmg-product-cond" target="_blank"><ul>';
        if ($condition && in_array('front', $condition)) {
            if ($front_custom) {
                $output .= '<li><strong>Front: </strong>' . $front_custom . '</li>';
            } else {
                $output .= '<li><strong>Front: </strong>' . $front . '</li>';
            }
        }
        if ($condition && in_array('top', $condition)) {
            if ($top_custom) {
                $output .= '<li><strong>Top: </strong>' . $top_custom . '</li>';
            } else {
                $output .= '<li><strong>Top: </strong>' . $top . '</li>';
            }
        }
        if ($condition && in_array('left', $condition)) {
            if ($left_custom) {
                $output .= '<li><strong>Left: </strong>' . $left_custom . '</li>';
            } else {
                $output .= '<li><strong>Left: </strong>' . $left . '</li>';
            }
        }
        if ($condition && in_array('right', $condition)) {
            if ($right_custom) {
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

        $output .= '</ul></a>';
    }
    return $output;
}

add_shortcode('warranty_product', 'bmg_warranty_product');
function bmg_warranty_product()
{
    global $post;

    $warranty = get_field('bmg_waranty');
    $custom_warranty = get_field('bmg_custom_warranty');

    $output = '';
    $output .= '<ul class="bmg-product-cond">';
    if ($warranty) {
        if ($custom_warranty) {
            $output .= '<li><strong>Warranty: </strong>' . $custom_warranty . '</li>';
        } else {
            $output .= '<li><strong>Warranty: </strong>' .  $warranty . '</li>';
        }
    }

    $output .= '</ul>';
    return $output;
}

add_shortcode('warranty_product_single', 'bmg_warranty_product_single');
function bmg_warranty_product_single()
{
    global $post;

    $warranty_single = get_field('bmg_waranty');
    $custom_warranty_single = get_field('bmg_custom_warranty');

    $output = '';
    $output .= '<a href="/glossary/#warranty" class="bmg-warranty-labels" target="_blank">';
    if ($warranty_single) {
        if ($custom_warranty_single) {
            $output .= '<span class="warranty-badge">' . $custom_warranty_single . '</span>';
        } else {
            $output .= '<span class="warranty-badge">' .  $warranty_single . '<span>';
        }
    }

    $output .= '</a>';
    return $output;
}

add_shortcode('packaging_product', 'bmg_packaging_product');
function bmg_packaging_product()
{
    global $post;

    $packaging = get_field('bmg_packaging');
    $custom_packaging = get_field('bmg_custom_packaging');

    $output = '';
    $output .= '<ul class="bmg-product-cond">';
    if ($packaging) {
        if ($custom_packaging) {
            $output .= '<li><strong>Packaging: </strong>' . $custom_packaging . '</li>';
        } else {
            $output .= '<li><strong>Packaging: </strong>' .  $packaging . '</li>';
        }
    }

    $output .= '</ul>';
    return $output;
}

add_shortcode('packaging_product_single', 'bmg_packaging_product_single');
function bmg_packaging_product_single()
{
    global $post;

    $packaging_single = get_field('bmg_packaging');
    $custom_packaging_single = get_field('bmg_custom_packaging');

    $output = '';
    $output .= '<a href="/glossary/#packaging" class="bmg-packaging-labels" target="_blank">';
    if ($packaging_single) {
        if ($custom_packaging_single) {
            $output .= '<span class="packaging-badge">' . $custom_packaging_single . '</span>';
        } else {
            $output .= '<span class="packaging-badge">' .  $packaging_single . '</span>';
        }
    }

    $output .= '</a>';
    return $output;
}

add_shortcode('features_product', 'bmg_features_product');
function bmg_features_product()
{
    global $post;

    $key_features = get_field('bmg_key_features');

    $output = '';
    $output .= '<div class="bmg-key-features">';

    if ($key_features) :
        $output .= '<h3>Key Features</h3>';
        $output .= '<ul class="bmg-key-features__list">';
        foreach ($key_features as $key_feature) :
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
function admin_order_item_headers()
{
    echo '<th>RC Number</th>';
    echo '<th>Online Only</th>';
}

//add_action( 'woocommerce_admin_order_item_values', 'admin_order_item_values', 10, 3 );
function admin_order_item_values($_product, $item, $item_id = null)
{
    // Get the product
    if (!empty($_product)) {
        $product_id = $_product->get_id();
    }
    // Get the field value
    $rc_number = get_field('rc_number', $product_id);
    $online_only = get_field('bmg_online_only', $product_id);
    // Display the field value
    if ($rc_number) {
        echo '<td>' . $rc_number . '</td>';
    } else {
        echo '<td> - </td>';
    }

    if ($online_only && in_array('yes', $online_only)) {
        echo '<td> Yes </td>';
    } else {
        echo '<td> No </td>';
    }
}

add_action('woocommerce_checkout_update_order_meta', 'bmg_custom_checkout_field_update_order_meta');

function bmg_custom_checkout_field_update_order_meta($order_id)
{

    $order = wc_get_order($order_id);

    foreach ($order->get_items() as $item_id => $item) {

        $product_id = $item->get_product_id();

        $rc_number = get_field('rc_number', $product_id);
        $online_only = get_field('bmg_online_only', $product_id);
        $alpha_stock = get_field('bmg_alpha_stock', $product_id);
        $product_global_identifiers = get_post_meta($product_id, 'sp_wc_barcode_field', true);

        if (!empty($rc_number)) {
            update_post_meta($order_id, 'rc_number_order', $rc_number);
            update_post_meta($order_id, 'bmg_online_only_order', $online_only);
            update_post_meta($order_id, 'product_global_identifiers_order', $product_global_identifiers);
            update_post_meta($order_id, 'bmg_alpha_stock_order', $alpha_stock);
        }
    }
}

add_action('woocommerce_email_order_details', 'display_alpha_stock_email_order_details', 10, 4);
function display_alpha_stock_email_order_details($order, $sent_to_admin, $plain_text, $email)
{
    // Only admin notifications
    if (!$sent_to_admin)
        return; // Exit

    foreach ($order->get_items() as $item) {
        if ($alpha_stock = get_field("bmg_alpha_stock", $item->get_product_id())) {
            echo '<p><strong>' . __('Alpha Stock') . ': </strong>Yes</p>';
        }
    }
}

//BMG from old elekdirect START

//add_filter( 'big_image_size_threshold', '__return_false' );

add_action('woocommerce_before_single_product', 'set_default_product_image_from_gallery');

function set_default_product_image_from_gallery()
{
    global $product;

    // Get the product gallery image IDs
    $attachment_ids = $product->get_gallery_image_ids();

    // Check if there are any gallery images
    if ($attachment_ids && !has_post_thumbnail($product->get_id())) {
        // Get the first image ID
        $first_image_id = reset($attachment_ids);

        // Set the first gallery image as the featured image (post thumbnail)
        set_post_thumbnail($product->get_id(), $first_image_id);
    }
}

add_shortcode('shipping_badge', 'bmg_shipping_badge');
function bmg_shipping_badge()
{
    global $product;
    if (!is_a($product, 'WC_Product')) {
        $product = wc_get_product();  // Get the product object if not set
    }
    if (!$product) {  // If product is still not set, return
        return;
    }
    $product_id = $product->get_id();
    $online_only = get_field('bmg_online_only', $product_id);
    $output = '';
    $output .= '<div class="bmg-shipping-labels">';
    if ($product->get_shipping_class() === 'free-shipping') {
        $output .= '<a href="/delivery-information/" class="shipping-badge" target="_blank" rel="noopener noreferrer"><span>Free UK Delivery</span></a>';
    }
    if ($product->get_shipping_class() === 'shipping-costs-20-00') {
        $output .= '<a href="/delivery-information/" class="shipping-badge" target="_blank" rel="noopener noreferrer"><span>UK Delivery £20.00</span></a>';
    }
    if ($product->get_shipping_class() === 'medium-appliances-shipping') {
        $output .= '<a href="/delivery-information/" class="shipping-badge" target="_blank" rel="noopener noreferrer"><span>UK Delivery £39</span></a>';
    }
    if ($product->get_shipping_class() === 'collection-only') {
        $output .= '<a href="/delivery-information/" class="shipping-badge" target="_blank" rel="noopener noreferrer"><span>Collection Only</span></a>';
    }
    if ($online_only && in_array('yes', $online_only)) {
        $output .= '<a href="/delivery-information/" class="shipping-badge" target="_blank" rel="noopener noreferrer"><span>Online Only</span></a>';
    }
    $output .= '</div>';
    return $output;
}


add_shortcode('custom_badge', 'bmg_custom_badge');
function bmg_custom_badge()
{
    global $product;
    $terms = get_the_terms($product->get_id(), 'product_cat');
    $output = '';
    $output .= '<div class="bmg-custom-labels">';
    foreach ($terms as $term) {
        $product_cat = $term->name;
        if ($product_cat == 'Non Plumbed') {
            $output .= '<span class="new-badge-non-plumbed">Non Plumbed</span>';
        }
        if ($product_cat == 'Plumbed') {
            $output .= '<span class="new-badge-plumbed">Plumbed</span>';
        }
    }
    $output .= '</div>';
    return $output;
}

function custom_category_css()
{
    // Check if we are on a product category page
    if (is_product_category()) {
        // Get the current category
        $current_category = get_queried_object();

        // Get the parent category ID you want to check against
        $parent_category_id_new_boxed = get_term_by('slug', 'new-boxed', 'product_cat')->term_id;

        // Check if the current category is a child of the parent category
        $is_child_of_parent_new_boxed = term_is_ancestor_of($parent_category_id_new_boxed, $current_category->term_id, 'product_cat');

        // If the current category is the parent or its child, output the CSS
        if ($current_category->term_id == $parent_category_id_new_boxed || $is_child_of_parent_new_boxed) {
            echo '<style type="text/css">
                .prdctfltr_pa_i_type_31_1,
                .prdctfltr_product_cat {
                    display: none !important;
                }
            </style>';
        }

        $parent_category_id_computing = get_term_by('slug', 'computing', 'product_cat')->term_id;

        // Check if the current category is a child of the parent category
        $is_child_of_parent_computing = term_is_ancestor_of($parent_category_id_computing, $current_category->term_id, 'product_cat');

        // If the current category is the parent or its child, output the CSS
        if ($current_category->term_id == $parent_category_id_computing || $is_child_of_parent_computing) {
            echo '<style type="text/css">
                .prdctfltr_pa_i_colour_46_1,
                .prdctfltr_product_cat {
                    display: none !important;
                }
            </style>';
        }

        $parent_category_id_soundbars = get_term_by('slug', 'soundbars-and-home-cinema-systems', 'product_cat')->term_id;

        // Check if the current category is a child of the parent category
        $is_child_of_parent_soundbars = term_is_ancestor_of($parent_category_id_soundbars, $current_category->term_id, 'product_cat');

        // If the current category is the parent or its child, output the CSS
        if ($current_category->term_id == $parent_category_id_soundbars || $is_child_of_parent_soundbars) {
            echo '<style type="text/css">
                .prdctfltr_product_cat {
                    display: none !important;
                }
            </style>';
        }
    }
}
add_action('wp_head', 'custom_category_css');

// Add custom field to product category
add_action('product_cat_add_form_fields', 'custom_category_image_field', 10, 2);
function custom_category_image_field()
{
?>
    <div class="form-field">
        <label for="category_image"><?php _e('Category Image', 'textdomain'); ?></label>
        <input type="text" class="custom_media_url" name="category_image" id="category_image" value="">
        <button type="button" class="button custom_media_button" id="category_image_button"><?php _e('Upload Image', 'textdomain'); ?></button>
    </div>
    <script>
        jQuery(document).ready(function($) {
            var custom_media_frame;
            $('#category_image_button').click(function(e) {
                e.preventDefault();
                if (custom_media_frame) {
                    custom_media_frame.open();
                    return;
                }
                custom_media_frame = wp.media.frames.custom_media_frame = wp.media({
                    title: '<?php _e("Choose Image", "textdomain"); ?>',
                    button: {
                        text: '<?php _e("Choose Image", "textdomain"); ?>'
                    },
                    library: {
                        type: 'image'
                    }
                });
                custom_media_frame.on('select', function() {
                    var attachment = custom_media_frame.state().get('selection').first().toJSON();
                    $('.custom_media_url').val(attachment.url);
                });
                custom_media_frame.open();
            });
        });
    </script>
<?php
}

// Edit custom field in product category
add_action('product_cat_edit_form_fields', 'edit_custom_category_image_field', 10, 2);
function edit_custom_category_image_field($term, $taxonomy)
{
    $image_url = get_term_meta($term->term_id, 'category_image', true);
?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category_image"><?php _e('Category Image', 'textdomain'); ?></label></th>
        <td>
            <input type="text" class="custom_media_url" name="category_image" id="category_image" value="<?php echo esc_attr($image_url); ?>">
            <button type="button" class="button custom_media_button" id="category_image_button"><?php _e('Upload Image', 'textdomain'); ?></button>
        </td>
    </tr>
    <script>
        jQuery(document).ready(function($) {
            var custom_media_frame;
            $('#category_image_button').click(function(e) {
                e.preventDefault();
                if (custom_media_frame) {
                    custom_media_frame.open();
                    return;
                }
                custom_media_frame = wp.media.frames.custom_media_frame = wp.media({
                    title: '<?php _e("Choose Image", "textdomain"); ?>',
                    button: {
                        text: '<?php _e("Choose Image", "textdomain"); ?>'
                    },
                    library: {
                        type: 'image'
                    }
                });
                custom_media_frame.on('select', function() {
                    var attachment = custom_media_frame.state().get('selection').first().toJSON();
                    $('.custom_media_url').val(attachment.url);
                });
                custom_media_frame.open();
            });
        });
    </script>
<?php
}

// Save custom field value
add_action('edited_product_cat', 'save_custom_category_image_field', 10, 2);
add_action('create_product_cat', 'save_custom_category_image_field', 10, 2);
function save_custom_category_image_field($term_id, $tt_id)
{
    if (isset($_POST['category_image'])) {
        update_term_meta($term_id, 'category_image', sanitize_text_field($_POST['category_image']));
    }
}

// Shortcode to display category image
add_shortcode('category_image', 'display_category_image_shortcode');
function display_category_image_shortcode()
{
    global $wp_query;
    $term = $wp_query->get_queried_object();
    $image_url = get_term_meta($term->term_id, 'category_image', true);
    if (!empty($image_url)) {
        return '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($term->name) . '">';
    } else {
        return '';
    }
}

add_filter('woocommerce_get_price_html', 'custom_price_html', 100, 2);
function custom_price_html($price, $product)
{
    if ($product->is_on_sale()) {
        return '<span class="sale-price">' . wc_price($product->get_sale_price(), array('decimals' => 0)) . '</span>';
    } else {
        return '<span class="regular-price">' . wc_price($product->get_regular_price(), array('decimals' => 0)) . '</span>';
    }
}

add_shortcode('sale_label', 'display_sale_label_shortcode');
function display_sale_label_shortcode()
{
    global $product, $post;
    if (!$product) {
        $product = wc_get_product($post->ID);
    }
    if ($product && $product->is_on_sale()) {
        $rrp_price = get_post_meta($post->ID, 'rrp', true); // Get the RRP price
        $sale_price = $product->get_sale_price();
        $savings = $rrp_price - $sale_price;
        return '<span class="sale-label">Save £' . $savings . '</span>';
    } else {
        return '';
    }
}

add_shortcode('percentage_bedge','discount_percentage_shortcode');
function discount_percentage_shortcode(){

    global $product, $post;
    if (!$product) {
        $product = wc_get_product($post->ID);
    }
    if ($product && $product->is_on_sale()) {
        $rrp_price = get_post_meta($post->ID, 'rrp', true); // Get the RRP price
        $sale_price = $product->get_sale_price();
        $savings = $rrp_price - $sale_price;
        $percentage = $savings / $rrp_price * 100;
        return '<span class="percentage-bedge">' . number_format($percentage) . '% off</span>';
    } else {
        return '';
    }

}


add_action('woocommerce_after_cart_table', 'display_additional_products');
function display_additional_products()
{
    $specific_product_id = 596176;

    $specific_product_in_cart = true;
    foreach (WC()->cart->get_cart() as $cart_item) {
        if ($cart_item['product_id'] == $specific_product_id) {
            $specific_product_in_cart = false;
            break;
        }
    }
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product_cat_ids = wc_get_product_term_ids($cart_item['product_id'], 'product_cat');

        foreach ($product_cat_ids as $cat_id) {
            $bmg_prod_category = get_field('bmg_prod_category', 'product_cat_' . $cat_id);
            if ($bmg_prod_category) {

                if ($specific_product_in_cart) {

                    $additional_products = array(546634);

                    echo '<ul class="additional-products-list">';

                    foreach ($additional_products as $product_id) {
                        $product = wc_get_product($product_id);

                        if ($product && $product->is_in_stock()) {
                            echo '<li>';
                            echo '<div class="bmg-recycling bmg-cart-prod">';
                            echo '<div class="upper-half">';
                            echo '<div class="product-image">' . get_the_post_thumbnail($product_id, 'full') . '</div>';
                            echo '<div class="bmg-rec-infor">';
                            echo '<p id="bmg-title"><span><strong>Collect</strong> and Recycle</span></p><p>Save yourself a trip to the tip </br>with our Collection service <a target="_blank" href="https://www.elekdirect.co.uk/collect-and-recycle/">Read more</a></p>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="bmg-rec-price">';
                            echo '<span class="bmg-price">£' . $product->get_price() . '</span>';
                            echo '<a href="?add-to-cart=' . $product_id . '" class="button add_to_cart_button">Add</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</li>';
                            echo '<li>';
                            echo '<div class="bmg-recycling bmg-cart-note">';
                            echo '<p>If you choose to add the <strong>Collect</strong> and Recycle service to your order, kindly ensure that the quantity of the Recycling product matches with the quantity of your main products in the cart. This is essential to ensure that each product you purchase is accounted for in the recycling process.</p>';
                            echo '<p>For example, if you are purchasing three products, you should also select three Collect and Recycle options in your cart.</p>';
                            echo '<p>We appreciate your understanding and cooperation in making our operations as sustainable as possible. Thank you for helping us contribute towards a greener planet.</p>';
                            echo '</div>';
                            echo '</li>';
                        }
                    }
                    echo '</ul>';
                    return; // If found, no need to check further
                }
            }
        }
    }
}
//add_action( 'woocommerce_product_meta_start', 'bmg_recycling_product', 5 );
function bmg_recycling_product()
{
    $parent_categories = array('clearance-american-ff', 'american-fridge-freezers', 'refrigeration', 'clearance-dishwashers', 'dishwashers-all', 'laundry', 'laundry-clearance', 'range-cookers', 'ovens', 'cookers');

    $product_cat_ids = wc_get_product_term_ids(get_the_ID(), 'product_cat');

    foreach ($product_cat_ids as $cat_id) {
        $ancestor_ids = get_ancestors($cat_id, 'product_cat');
        foreach ($ancestor_ids as $ancestor_id) {
            $term = get_term($ancestor_id, 'product_cat');
            $additional_product_id = 546634;
            $additional_product = wc_get_product($additional_product_id);
            if (in_array($term->slug, $parent_categories)) {
                echo '<div class="bmg-recycling">';
                echo '<div class="product-image">' . get_the_post_thumbnail($additional_product_id, 'full') . '</div>';
                echo '<div class="bmg-rec-infor">';
                echo '<p id="bmg-title"><span><strong>Collect</strong> and Recycle</span></p><p>Save yourself a trip to the tip </br>with our Collection service <a target="_blank" href="https://www.elekdirect.co.uk/collect-and-recycle/">Read more</a></p>';
                echo '</div>';
                echo '<div class="bmg-rec-price">';
                echo '<span class="bmg-price">£' . $additional_product->get_price() . '</span>'; // Using the get_price() method to retrieve the actual price
                echo '</div>';
                echo '</div>';
                return;
            }
        }
    }
}


add_shortcode('bmg_recycling_product', 'bmg_recycling_product_shortcode');
function bmg_recycling_product_shortcode()
{
    $product_cat_ids = wc_get_product_term_ids(get_the_ID(), 'product_cat');
    $output = '';

    foreach ($product_cat_ids as $cat_id) {
        $bmg_prod_category = get_field('bmg_prod_category', 'product_cat_' . $cat_id);
        if ($bmg_prod_category) {
            $additional_product_id = 546634;
            $additional_product = wc_get_product($additional_product_id);
            if ($additional_product !== false) { // Check if $additional_product is a valid object
                $output .= '<div class="bmg-recycling">';
                $output .= '<div class="product-image">' . get_the_post_thumbnail($additional_product_id, 'large') . '</div>';
                $output .= '<div class="bmg-rec-infor">';
                $output .= '<p id="bmg-title"><span><strong>Collect</strong> and Recycle</span></p><p>Save yourself a trip to the tip </br>with our Collection service <a target="_blank" href="https://www.elekdirect.co.uk/collect-and-recycle/">Read more</a></p>';
                $output .= '</div>';
                $output .= '<div class="bmg-rec-price">';
                $output .= '<span class="bmg-price">£' . $additional_product->get_price() . '</span>'; // Using the get_price() method to retrieve the actual price
                $output .= '</div>';
                $output .= '</div>';
                return $output;
            } else {
                // Handle the case where no product is found, e.g., return a default message or log an error
                return 'Product not found.';
            }
        }
    }
    return '';
}

add_shortcode('recycling_badge', 'bmg_custom_recycling');
function bmg_custom_recycling()
{
    global $post;
    $product = wc_get_product($post->ID);
    $product_cat_ids = $product->get_category_ids();
    $output = '';
    foreach ($product_cat_ids as $cat_id) {
        $bmg_prod_category = get_field('bmg_prod_category', 'product_cat_' . $cat_id);
        if ($bmg_prod_category) {
            $output .= '<div class="bmg-recycling-labels">';
            $output .= '<span class="new-badge-recycling">Recycling Available</span>';
            $output .= '</div>';
            break; // Exit the loop once we found a category with recycling available
        }
    }

    return $output;
}

// Add new sorting option to sort by savings
//add_filter( 'woocommerce_get_catalog_ordering_args', 'bmg_sort_by_savings_ordering_args' );
function bmg_sort_by_savings_ordering_args($args)
{
    if (isset($_GET['orderby'])) {
        if ('savings_asc' === $_GET['orderby']) {
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            $args['meta_key'] = '_saving_price';
        } elseif ('savings_desc' === $_GET['orderby']) {
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $args['meta_key'] = '_saving_price';
        }
    }

    return $args;
}

// Calculate the savings price and save it as a custom field
//add_action( 'woocommerce_product_object_updated_props', 'bmg_save_savings_price', 10, 2 );
function bmg_save_savings_price($product, $updated_props)
{
    if (in_array('price', $updated_props)) {
        $rrp = (float) $product->get_meta('rrp');
        if ($rrp) { // Check if RRP exists
            $sale_price = $product->get_sale_price();
            $regular_price = $product->get_regular_price();
            $price_to_compare = $sale_price ? $sale_price : $regular_price;
            $saving = $rrp - $price_to_compare;
            $product->update_meta_data('_saving_price', $saving);
            $product->save_meta_data();
        }
    }
}

//add_filter( 'woocommerce_default_catalog_orderby_options', 'bmg_add_new_sorting_option' );
//add_filter( 'woocommerce_catalog_orderby', 'bmg_add_new_sorting_option' );
function bmg_add_new_sorting_option($options)
{
    $options['savings_asc'] = __('Sort by savings: low to high', 'woocommerce');
    $options['savings_desc'] = __('Sort by savings: high to low', 'woocommerce');
    return $options;
}


/**\
 * Custom sorting
 */

// Add custom sorting options to WooCommerce
add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');
add_filter('woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby');
add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');

function custom_woocommerce_get_catalog_ordering_args($args)
{
    if (isset($_GET['orderby'])) {
        switch ($_GET['orderby']) {
            case 'savings_high_to_low':
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                $args['meta_key'] = '_savings';
                break;
            case 'savings_low_to_high':
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                $args['meta_key'] = '_savings';
                break;
        }
    }
    return $args;
}

function custom_woocommerce_catalog_orderby($sortby)
{
    $sortby['savings_high_to_low'] = 'Sort by Savings: High to Low';
    $sortby['savings_low_to_high'] = 'Sort by Savings: Low to High';
    return $sortby;
}

// Save the difference between the regular price and the sale price
function save_product_savings()
{
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    );
    $products = new WP_Query($args);

    while ($products->have_posts()) : $products->the_post();
        $product_id = get_the_ID();
        $regular_price = get_post_meta($product_id, '_regular_price', true);
        $sale_price = get_post_meta($product_id, '_sale_price', true);

        if ($regular_price && $sale_price) {
            $savings = $regular_price - $sale_price;
            update_post_meta($product_id, '_savings', $savings);
        } else {
            delete_post_meta($product_id, '_savings');
        }
    endwhile;
    wp_reset_postdata();
}

// Run the savings calculation when a product is saved
add_action('save_post', 'save_product_savings');

// Uncomment this line to manually run the function once to update existing products
//save_product_savings();

/**
 * Adding woocommerece product status.
 */

// Register the custom post status 'waiting_for_icecat'
function my_custom_status_creation()
{
    register_post_status('waiting_for_icecat', array(
        'label'                     => _x('Waiting for IceCat', 'post'),
        'label_count'               => _n_noop('Waiting for IceCat <span class="count">(%s)</span>', 'Waiting for IceCat <span class="count">(%s)</span>'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true
    ));
}
add_action('init', 'my_custom_status_creation');

// Add the custom status 'waiting_for_icecat' to the Quick Edit dropdown
function my_custom_status_add_in_quick_edit()
{
    echo "<script>
    jQuery(document).ready( function() {
        jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"waiting_for_icecat\">Waiting for IceCat</option>' );      
    }); 
    </script>";
}
add_action('admin_footer-edit.php', 'my_custom_status_add_in_quick_edit');

// Add the custom status 'waiting_for_icecat' to the post status dropdown in post edit page
function my_custom_status_add_in_post_page()
{
    echo "<script>
    jQuery(document).ready( function() {        
        jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"waiting_for_icecat\">Waiting for IceCat</option>' );
    });
    </script>";
}
add_action('admin_footer-post.php', 'my_custom_status_add_in_post_page');
add_action('admin_footer-post-new.php', 'my_custom_status_add_in_post_page');

// Set the default status for new products to 'waiting_for_icecat'
function set_default_product_status($post_ID, $post, $update)
{
    if (!$update && $post->post_type == 'product') {
        $post->post_status = 'waiting_for_icecat';
        remove_action('save_post', 'set_default_product_status', 10, 3);
        wp_update_post($post);
        add_action('save_post', 'set_default_product_status', 10, 3);
    }
}
add_action('save_post', 'set_default_product_status', 10, 3);
