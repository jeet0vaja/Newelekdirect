<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<?php
$link = get_permalink( get_the_ID() );
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
$key_features = get_field('bmg_key_features');

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
$warranty = get_field('bmg_waranty');
$custom_warranty = get_field('bmg_custom_warranty');
$packaging = get_field('bmg_packaging');
$custom_packaging = get_field('bmg_custom_packaging');

    
if ( $terms && ! is_wp_error( $terms ) ) {
    $brand = $terms[0]->name;

    $brand_img = get_brand_thumbnail_url( $terms[0]->term_id );
    $brand_url = get_term_link( $terms[0]->slug, 'product_brand' );
}    
//var_dump($brand_img );
?>
<script type="text/javascript"> 
  
    window.addEventListener('liveload', function() {
        IcecatLive.getDatasheet(
            {
            //'bulletpoints':'#bullet-<?php //echo $ean; ?>',
            //'manuals':'#manuals-<?php //echo $ean; ?>',
           //'featurelogos':'#featurelogos-<?php //echo $ean; ?>'
           'essentialinfo':'#bmg-essentialinfo-<?php echo $ean; ?>'
            }, 
            {
            Brand: '<?php echo $brand; ?>',
            PartCode: '<?php echo $mpn; ?>',
            GTIN: '<?php echo $ean; ?>',
            UserName: 'NWDSAO'
            }, 'en');
        });
    
</script>
<li <?php wc_product_class( 'product-listing__item', $product ); ?>>
<script>
         jQuery(document).on( 'prdctfltr-reload', function() {
            setTimeout(
                function() 
                    {
            IcecatLive.getDatasheet(
            {
            //'bulletpoints':'#bullet-<?php //echo $ean; ?>',
            //'manuals':'#manuals-<?php //echo $ean; ?>',
           //'featurelogos':'#featurelogos-<?php //echo $ean; ?>'
           'essentialinfo':'#bmg-essentialinfo-<?php echo $ean; ?>'
            }, 
            {
            Brand: '<?php echo $brand; ?>',
            PartCode: '<?php echo $mpn; ?>',
            GTIN: '<?php echo $ean; ?>',
            UserName: 'NWDSAO'
            }, 'en');
        }, 1000);
    });
</script>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item' );
	?>
    <div class="product-item product-item--b2c product-card product-card--b2c">
                <!-- <a class="whitespace-link" href="<?php echo esc_url( $link ); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> -->
                <div class="flex align-items-center">
                    <div class="flex-25 bmg-mobile-first half-width-padding position-relative">
                        <div class="product-item__thumb">
                            <a class="product-card__image-wrap" href="<?php echo esc_url( $link ); ?>" title="<?php the_title(); ?>">
                                <div class="product-card__border-wrap"> 
                                    <div class="image-placeholder image-placeholder--1-1">
                                        <?php
                                        if (has_post_thumbnail()) {
                                            $image_id = get_post_thumbnail_id();
                                            $image_url = wp_get_attachment_image_src($image_id, 'full');
                                            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                        ?>
                                            <img class="product-item__thumb-img" alt="<?php the_title(); ?>" src="<?php echo $image_url[0]; ?>">
                                            <?php 
                                        }
                                        ?>
                                    </div>
                                </div>
                            </a>
                            <?php echo do_shortcode( '[custom_badge]' ); ?>
                            <?php echo do_shortcode( '[shipping_badge]' ); ?>

                        </div>
                        <!-- <div class="flex align-items-center justify-content-between">
                            <div class="bmg-energy-wrap">
                                <div id="featurelogos-<?php //echo $ean; ?>"></div>
                                <div id="manuals-<?php //echo $ean; ?>" class="bmg-energy"></div>
                            </div>
                        </div> -->
                    </div>
                    <div class="bmg-mobile-second-wrap">
                        <div class="flex-50 bmg-mobile-second">
                            <div class="flex align-items-start justify-content-between mb-2">
                                <div class="flex-100">
                                    <div class="product-item__brand-logo justify-content-flex-start mb-0">
                                    <a href="<?php echo $brand_url; ?>">
	                                    <img src="<?php echo $brand_img; ?>" alt="<?php echo $brand; ?>" class="bmg-brand-shop-logo"/>
                                    </a>
                                    </div>
                                    <a class="product-card__heading-wrap pr-1 mb-0" href="<?php echo esc_url( $link ); ?>" title="<?php the_title(); ?>">
                                        <h3 class="product-card__heading product-name product-name--two-lines js-truncate-lines">
                                            <?php the_title(); ?>
                                        </h3>
                                    </a>
                                    <!-- <div id="bmg-essentialinfo-<?php //echo $ean; ?>"></div> -->
                                    <div class="bmg-key-features">
                                    <?php if ( $key_features ) : ?>
                                        <h3>Key Features</h3>
                                            <ul class="bmg-key-features__list">
                                            <?php foreach ( $key_features as $key_feature ) : ?>
                                                    <li>
                                                        <?php 
                                                            $text = $key_feature['bmg_key_features_list'];
                                                            if (strlen($text) > 60) {
                                                                echo substr($text, 0, 60) . '...';
                                                            } else {
                                                                echo $text;
                                                            }
                                                        ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="bmg-meta flex justify-content-flex-star">
                                        <?php //if ($sku) { ?>
                                        <div class="bmg-meta__item flex">
                                            <div class="bmg-meta__label">SKU: </div>
                                            <div class="bmg-meta__value"> <?php //echo $sku; ?></div>
                                        </div>
                                        <?php //} ?>
                                        <?php //if ( $categories && ! is_wp_error( $categories ) ) { ?>
                                        <div class="bmg-meta__item flex">
                                            <div class="bmg-meta__label">Categories: 
                                                <span class="bmg-meta__value">
                                                <?php //foreach ( $categories as $category ) { 
                                                   // echo ' <a href="' . get_term_link( $category->term_id, 'product_cat' ) . '">' . $category->name . '</a>, ';
                                               // } ?>
                                                </span>
                                            </div>
                                        </div>
                                        <?php // } ?>
                                    </div> -->
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
                                                <div class="woocommerce_rrp"> 
                                    <?php
                                        if ($rrp > 0) {
                                            echo _e( 'RRP: ', 'woocommerce' );
                                            echo '<span> ' . wc_price($rrp, array('decimals' => 0)) . '</span>';
                                        }
                                        
                                    ?>
                                </div>
                                                    <?php
                                                    if ( ! $product->get_price_html() ) {
                                                        echo 'Price not available';
                                                    } else {
                                                        $price_class = $product->is_on_sale() ? 'sale-price' : 'regular-price';
                                                        echo '<span class="' . $price_class . '">' . $product->get_price_html() . '</span>';
                                                    }
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="woocommerce_sale"> 
                                    <?php
                                        if ( $product->is_on_sale() ) {
                                            echo '<div class="bmg-sale-labels"><span class="sale-badge">Sale</span></div>'; // You can style this in your CSS file or inline
                                        } 
                                    ?>
                                </div>
                                <!-- <div class="bmg-damage">
                                    <h3>Product damage</h3>
                                    <?php //echo do_shortcode('[condition_product]'); ?>
                                </div>  -->
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
                                    <!-- <div class="bmg-more-details">
                                        <a href="<?php //esc_url(get_permalink($product->get_id())) ?>" class="button">More Info</a>';
                                    </div> -->
                                    
                                    <div class="bmg-more-details">
                                    <h3>Product Description</h3>
                                        <?php
                                        echo '<table class="bmg-product-cond">';

                                        if ($warranty) {
                                            echo '<tr class="bmg-prod-warranty"><td><strong>Warranty: </strong></td><td>' . ($custom_warranty ? $custom_warranty : $warranty) . '</td></tr>';
                                        }

                                        if ($condition) {
                                            if (in_array('front', $condition)) {
                                                echo '<tr class="bmg-prod-condition"><td><strong>Front: </strong></td><td>' . ($front_custom ? $front_custom : $front) . '</td></tr>';
                                            }
                                            if (in_array('top', $condition)) {
                                                echo '<tr class="bmg-prod-condition"><td><strong>Top: </strong></td><td>' . ($top_custom ? $top_custom : $top) . '</td></tr>';
                                            }
                                            if (in_array('left', $condition)) {
                                                echo '<tr class="bmg-prod-condition"><td><strong>Left: </strong></td><td>' . ($left_custom ? $left_custom : $left) . '</td></tr>';
                                            }
                                            if (in_array('right', $condition)) {
                                                echo '<tr class="bmg-prod-condition"><td><strong>Right: </strong></td><td>' . ($right_custom ? $right_custom : $right) . '</td></tr>';
                                            }
                                        }

                                        if ($other_conditions) {
                                            echo '<tr class="bmg-prod-condition"><td><strong>Other: </strong></td><td>';
                                            foreach ($other_conditions as $other_condition) {
                                                if ($other_condition == 'Custom Field') {
                                                    continue;
                                                }
                                                echo $other_condition . ', ';
                                            }
                                            echo '</td></tr>';
                                        }

                                        if ($other_conditions && in_array('Custom Field', $other_conditions)) {
                                            echo '<tr class="bmg-prod-condition"><td><strong>Other: </strong></td><td>' . $other_condition_custom . '</td></tr>';
                                        }

                                        if ($packaging) {
                                            echo '<tr class="bmg-prod-packaging"><td><strong>Packaging: </strong></td><td>' . ($custom_packaging ? $custom_packaging : $packaging) . '</td></tr>';
                                        }

                                        echo '</table>';
                                        ?>
                                        </div>
                                </div>              
                        </div>
                    </div>
                </div>
            </div>
</li>
