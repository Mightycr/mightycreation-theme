<?php
/**
 * generate-descriptions.php
 *
 * Generates professional 2-sentence descriptions for WooCommerce products
 * that currently have no description, using template strings (no external API).
 *
 * Usage: php generate-descriptions.php
 *        (place in WordPress root, or anywhere inside the WP directory tree)
 */

// ── 1. Bootstrap WordPress ────────────────────────────────────────────────────
$dir = __DIR__;
while ( ! file_exists( $dir . '/wp-load.php' ) ) {
    $parent = dirname( $dir );
    if ( $parent === $dir ) {
        die( "ERROR: Could not find wp-load.php. Make sure this script is inside your WordPress directory.\n" );
    }
    $dir = $parent;
}
define( 'WP_USE_THEMES', false );
require $dir . '/wp-load.php';

// Ensure WooCommerce is active
if ( ! function_exists( 'wc_get_products' ) ) {
    die( "ERROR: WooCommerce is not active.\n" );
}

echo "WordPress loaded from: {$dir}\n\n";

// ── 2. Description templates ──────────────────────────────────────────────────
// {title} is replaced with the product name.
$templates = [
    "{title} is a premium ready-made logo design crafted for businesses that want a bold, distinctive identity from day one. Clean composition and strong typography make this mark immediately recognisable and timelessly professional.",
    "{title} is a versatile pre-made logo concept built to give your brand instant credibility and visual impact. This thoughtfully crafted mark blends modern aesthetics with enduring style that grows with your business.",
    "{title} delivers a polished, ready-to-use logo identity for brands that want to stand out in a competitive market. The design strikes the perfect balance between creativity and professionalism.",
    "{title} is a professionally designed logo mark ready to represent your brand with confidence and clarity. Its distinctive visual language communicates quality and purpose at a single glance.",
    "{title} offers a unique, market-ready logo solution for entrepreneurs and businesses ready to make their mark. Carefully crafted with attention to detail, this design is built for lasting brand recognition.",
    "{title} is a beautifully composed logo identity that combines simplicity with strong visual character. Ideal for modern brands that value clean design and immediate impact.",
    "{title} is a striking pre-made logo designed to elevate your brand presence and communicate professionalism. The design's balanced proportions and considered details ensure it works across all media.",
];

// ── 3. Find products with empty descriptions ──────────────────────────────────
$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'meta_query'     => [],
];

// Temporarily bypass WooCommerce's stock visibility filter
$bypass = function( $q ) {
    $mq = $q->get( 'meta_query' );
    if ( is_array( $mq ) ) {
        foreach ( $mq as $k => $clause ) {
            if ( isset( $clause['key'] ) && $clause['key'] === '_stock_status' ) {
                unset( $mq[ $k ] );
            }
        }
        $q->set( 'meta_query', array_values( $mq ) );
    }
};
add_action( 'pre_get_posts', $bypass, 9999 );
$all_ids = get_posts( $args );
remove_action( 'pre_get_posts', $bypass, 9999 );

$empty_ids = [];
foreach ( $all_ids as $id ) {
    $content = get_post_field( 'post_content', $id );
    if ( trim( strip_tags( $content ) ) === '' ) {
        $empty_ids[] = $id;
    }
}

$total = count( $empty_ids );
echo "Found {$total} product(s) with empty descriptions.\n\n";

if ( $total === 0 ) {
    echo "Nothing to do. All products already have descriptions.\n";
    exit;
}

// ── 4. Generate and save descriptions ────────────────────────────────────────
$template_count = count( $templates );
$updated = 0;
$failed  = 0;

foreach ( $empty_ids as $index => $id ) {
    $title    = get_the_title( $id );
    $template = $templates[ $id % $template_count ]; // deterministic variety
    $desc     = str_replace( '{title}', $title, $template );

    $result = wp_update_post( [
        'ID'           => $id,
        'post_content' => $desc,
    ], true );

    $num = $index + 1;
    if ( is_wp_error( $result ) ) {
        echo "[{$num}/{$total}] FAILED  \"{$title}\" — " . $result->get_error_message() . "\n";
        $failed++;
    } else {
        echo "[{$num}/{$total}] Updated \"{$title}\"\n         → {$desc}\n\n";
        $updated++;
    }
}

// ── 5. Summary ────────────────────────────────────────────────────────────────
echo str_repeat( '-', 60 ) . "\n";
echo "Done. Updated: {$updated}  |  Failed: {$failed}\n";
