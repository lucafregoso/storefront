<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require locate_template('inc/class-storefront.php'),
	'customizer' => require locate_template('inc/customizer/class-storefront-customizer.php'),
);

require locate_template('inc/storefront-functions.php');
require locate_template('inc/storefront-template-hooks.php');
require locate_template('inc/storefront-template-functions.php');
require locate_template('inc/wordpress-shims.php');

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require locate_template('inc/jetpack/class-storefront-jetpack.php');
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require locate_template('inc/woocommerce/class-storefront-woocommerce.php');
	$storefront->woocommerce_customizer = require locate_template('inc/woocommerce/class-storefront-woocommerce-customizer.php');

	require locate_template('inc/woocommerce/class-storefront-woocommerce-adjacent-products.php');

	require locate_template('inc/woocommerce/storefront-woocommerce-template-hooks.php');
	require locate_template('inc/woocommerce/storefront-woocommerce-template-functions.php');
	require locate_template('inc/woocommerce/storefront-woocommerce-functions.php');
}

if ( is_admin() ) {
	$storefront->admin = require locate_template('inc/admin/class-storefront-admin.php');

	require locate_template('inc/admin/class-storefront-plugin-install.php');
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require locate_template('inc/nux/class-storefront-nux-admin.php');
	require locate_template('inc/nux/class-storefront-nux-guided-tour.php');
	require locate_template('inc/nux/class-storefront-nux-starter-content.php');
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
