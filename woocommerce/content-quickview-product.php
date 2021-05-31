<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $quickview, $post, $product, $woocommerce;
$quickview = true;
$attachment_ids = $product->get_gallery_image_ids();
$product_type = '';
if ( ! $product->is_type( 'simple' ) || ! $product->is_type( 'grouped' ) || ! $product->is_type( 'external' ) ) {
    $product_type = 'product-type-variable';
}

$is_rtl = '';
if(is_rtl()) {
    $is_rtl = 'true';
} else {
    $is_rtl = 'false';
}

?>
<div id="product-<?php the_ID(); ?>" class="product-quickview pr mfp-with-anim <?php echo esc_attr($product_type); ?>">
	<div class="wc-single-product-1 wc-single-product row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 column-left">
			<div class="single-product-thumbnail pr clearfix outside">
				<div class="single-product-thumbnail-inner pr">
					<div class="p-thumb images thumbnail-slider" data-slick='{"slidesToShow": 1, "rtl": <?php echo esc_attr($is_rtl); ?>, "slidesToScroll": 1, "asNavFor": ".p-nav", "fade":true,}'>
						<?php
							if ( has_post_thumbnail() ) {
								$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
								$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
								$thumbnail_post    = get_post( $post_thumbnail_id );
								$image_title       = $thumbnail_post->post_content;

								$attributes = array(
									'title'                   => $image_title,
									'data-src'                => $full_size_image[0],
									'data-large_image'        => $full_size_image[0],
									'data-zoom-image'  		  => $full_size_image[0],
									'data-large_image_width'  => $full_size_image[1],
									'data-large_image_height' => $full_size_image[2],
								);

								$html = '<div class="p-item woocommerce-product-gallery__image' . $zoom . '">';
									$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
								$html .= '</div>';

							} else {
								$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
									$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_attr__( 'Awaiting product image', 'koganic' ) );
								$html .= '</div>';
							}

							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

							$attachment_ids = $product->get_gallery_image_ids();

							if ( $attachment_ids ) {
								foreach ( $attachment_ids as $attachment_id ) {
									$full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
									$thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
									$thumbnail_post   = get_post( $attachment_id );
									$image_title      = $thumbnail_post->post_content;

									$attributes = array(
										'title'                   => $image_title,
										'data-src'                => $full_size_image[0],
										'data-large_image'        => $full_size_image[0],
										'data-large_image_width'  => $full_size_image[1],
										'data-large_image_height' => $full_size_image[2],
									);

									$html = '<div class="p-item woocommerce-product-gallery__image' . $zoom . '">';
											$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
									$html .= '</div>';

									echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
								}
							}
						?>
					</div>
				</div>

                <?php 
                    if ( $attachment_ids && has_post_thumbnail() ) {
                        ?>
                        <div class="p-nav oh thumbnail-slider" data-slick='{"slidesToShow": 6, "rtl": <?php echo esc_attr($is_rtl); ?>, "slidesToScroll": 1,"asNavFor": ".p-thumb","arrows": false, "focusOnSelect": true, "responsive":[{"breakpoint": 991,"settings":{"slidesToShow": 4, "rtl": <?php echo esc_attr($is_rtl); ?>, "vertical":false}}]}'>
                            <?php
                                $image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'woocommerce_thumbnail' ), array(
                                    'title' => get_the_title( get_post_thumbnail_id() )
                                ) );

                                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="p-item-thumb">%s</div>', $image ), $post->ID );

                                foreach ( $attachment_ids as $attachment_id ) {
                                    $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' );
                                    $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' );

                                    $attributes = array(
                                        'data-src'                => $full_size_image[0],
                                        'data-large_image'        => $full_size_image[0],
                                        'data-large_image_width'  => $full_size_image[1],
                                        'data-large_image_height' => $full_size_image[2],
                                    );
                                    $html = '<div class="p-item-thumb">' . wp_get_attachment_image( $attachment_id, 'woocommerce_thumbnail', false, $attributes ) . '</div>';
                                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
                                }
                            ?>
                        </div>
                        <?php
                    }
                ?>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 column-right">
			<div class="summary entry-summary">

				<?php
                    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
                    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
                    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15);
                    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 6);
                    add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 3);

					/**
					 * woocommerce_single_product_summary hook.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_meta - 15
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_price - 25
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_sharing - 50
					 * @hooked WC_Structured_Data::generate_product_data() - 60
					 */
                    /* get swatch html */
                    add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'koganic_get_swatch_html', 10, 2 );
                    function koganic_get_swatch_html( $html, $args ) {

                        /* return `$html` when `WooCommerce Variation Swatches` plugin not installed */
                        if(!function_exists('TA_WCVS')) return $html;

                        $swatch_types = TA_WCVS()->types;
                        $attr         = TA_WCVS()->get_tax_attribute( $args['attribute'] );
                
                        /* Return if this is normal attribute */
                        if ( empty( $attr ) ) {
                            return $html;
                        }
                
                        if ( ! array_key_exists( $attr->attribute_type, $swatch_types ) ) {
                            return $html;
                        }
                
                        $options   = $args['options'];
                        $product   = $args['product'];
                        $attribute = $args['attribute'];
                        $class     = "variation-selector variation-select-{$attr->attribute_type}";
                        $swatches  = '';
                
                        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
                            $attributes = $product->get_variation_attributes();
                            $options    = $attributes[$attribute];
                        }

                        if ( array_key_exists( $attr->attribute_type, $swatch_types ) ) {
                            if ( ! empty( $options ) && $product && taxonomy_exists( $attribute ) ) {
                                /* Get terms if this is a taxonomy - ordered. We need the names too. */
                                $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );
                
                                foreach ( $terms as $term ) {
                                    if ( in_array( $term->slug, $options ) ) {
                                        $swatches .= apply_filters( 'tawcvs_swatch_html', '', $term, $attr, $args );
                                    }
                                }
                            }
                
                            if ( ! empty( $swatches ) ) {
                                $class .= ' hidden';
                
                                $swatches = '<div class="tawcvs-swatches" data-attribute_name="attribute_' . esc_attr( $attribute ) . '">' . $swatches . '</div>';
                                $html     = '<div class="' . esc_attr( $class ) . '">' . $html . '</div>' . $swatches;
                            }
                        }
                
                        return $html;
                    }

                    /* print html watch */
                    add_filter( 'tawcvs_swatch_html', 'koganic_swatch_html', 5, 4 );
                    function koganic_swatch_html( $html, $term, $attr, $args ) {
                        /* return `$html` when `WooCommerce Variation Swatches` plugin not installed */
                        if(!function_exists('TA_WCVS')) return $html;

                        $selected = sanitize_title( $args['selected'] ) == $term->slug ? 'selected' : '';
                        $name     = esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );
                
                        switch ( $attr->attribute_type ) {
                            case 'color':
                                $color = get_term_meta( $term->term_id, 'color', true );
                                list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
                                $html = sprintf(
                                    '<span class="swatch swatch-color swatch-%s %s" style="background-color:%s;color:%s;" title="%s" data-value="%s">%s</span>',
                                    esc_attr( $term->slug ),
                                    esc_attr( $selected ),
                                    esc_attr( $color ),
                                    "rgba($r,$g,$b,0.5)",
                                    esc_attr( $name ),
                                    esc_attr( $term->slug ),
                                    esc_html( $name )
                                );
                                break;
                
                            case 'image':
                                $image = get_term_meta( $term->term_id, 'image', true );
                                $image = $image ? wp_get_attachment_image_src( $image ) : '';
                                $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
                                $html  = sprintf(
                                    '<span class="swatch swatch-image swatch-%s %s" title="%s" data-value="%s"><img src="%s" alt="%s">%s</span>',
                                    esc_attr( $term->slug ),
                                    esc_attr( $selected ),
                                    esc_attr( $name ),
                                    esc_attr( $term->slug ),
                                    esc_url( $image ),
                                    esc_attr( $name ),
                                    esc_html( $name )
                                );
                                break;
                
                            case 'label':
                                $label = get_term_meta( $term->term_id, 'label', true );
                                $label = $label ? $label : $name;
                                $html  = sprintf(
                                    '<span class="swatch swatch-label swatch-%s %s" title="%s" data-value="%s">%s</span>',
                                    esc_attr( $term->slug ),
                                    esc_attr( $selected ),
                                    esc_attr( $name ),
                                    esc_attr( $term->slug ),
                                    esc_html( $label )
                                );
                                break;
                        }
                
                        return $html;
                    }
					do_action( 'woocommerce_single_product_summary' );
				?>

			</div><!-- .summary -->
		</div>
	</div>
</div>
<!-- .product-quickview -->
