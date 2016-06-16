<?php
	/*
	 Plugin Name: Export wpSEO
	 Description: Export wpSEO data using the SEO data transporter
	 Plugin URI: https://krautpress.de/plugins/export-wpseo
	 Text Domain: export-wpseo
	 Version: 0.1
	 Tags: wpseo, seo, export, import
	 Author: KrautPress
	 Author URI: https://krautpress.de
	 License: GPLv2 or later
	 License URI: http://www.gnu.org/licenses/gpl-2.0.html

	 Export wpSEO is free software: you can redistribute it and/or modify
	 it under the terms of the GNU General Public License as published by
	 the Free Software Foundation, either version 2 of the License, or
	 any later version.

	 Export wpSEO is distributed in the hope that it will be useful,
	 but WITHOUT ANY WARRANTY; without even the implied warranty of
	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	 GNU General Public License for more details.
 
	 You should have received a copy of the GNU General Public License
	 along with Export wpSEO. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
	 */


	/**
	 * Adds wpSEO to the SEO data transporter
	 **/
	add_action( 'seodt_init', 'add_wpseo_to_seo_data_transporter' );
	function add_wpseo_to_seo_data_transporter() {
		global $_seodt_themes, $_seodt_plugins, $_seodt_platforms;

		$_seodt_plugins['wpSEO'] = array(
			'Custom Doctitle'        => '_wpseo_edit_title',
			'META Description'       => '_wpseo_edit_description',
			'Open Graph Title'       => '_wpseo_edit_og_title',
			'Open Graph Description' => '_wpseo_edit_og_description',
			'Open Graph Image'       => '_wpseo_edit_og_image',
			'Twitter Title'          => '_wpseo_edit_twittercard_title',
			'Twitter Description'    => '_wpseo_edit_twittercard_description',
			'Twitter Image'          => '_wpseo_edit_twittercard_image',
			'Canonical URI'          => '_wpseo_edit_canonical',
			'Redirect URI'           => '_wpseo_edit_redirect',
		);

		//Add open graph title/description/image to Yoast WordPress SEO
		$_seodt_plugins['WordPress SEO']['Open Graph Title']       = '_yoast_wpseo_opengraph-title';
		$_seodt_plugins['WordPress SEO']['Open Graph Description'] = '_yoast_wpseo_opengraph-description';
		$_seodt_plugins['WordPress SEO']['Open Graph Image']       = '_yoast_wpseo_opengraph-image';

		//Add twitter title/description/image to Yoast WordPress SEO
		$_seodt_plugins['WordPress SEO']['Twitter Title']       = '_yoast_wpseo_twitter-title';
		$_seodt_plugins['WordPress SEO']['Twitter Description'] = '_yoast_wpseo_twitter-description';
		$_seodt_plugins['WordPress SEO']['Twitter Image']       = '_yoast_wpseo_twitter-image';
		$_seodt_platforms = array_merge( $_seodt_themes, $_seodt_plugins );

	}

	/**
	 * Checks on activation, if the SEO data transporter is acitiavted
	 * and returns an admin notice, if it's not activated
	 **/
	register_activation_hook( __FILE__, 'add_wpseo_on_activation' );
	function add_wpseo_on_activation() {
		if ( ! is_plugin_active( 'seo-data-transporter/plugin.php' ) ) {
			update_option( 'add_wpseo_needs_seo_data_transporter_notice', 1 );
		}
	}

	add_action( 'admin_init', 'add_wpseo_needs_seo_data_transporter_notice_deferred' );
	function add_wpseo_needs_seo_data_transporter_notice_deferred(){
		if( ! get_option( 'add_wpseo_needs_seo_data_transporter_notice' ) )
			return;

		delete_option( 'add_wpseo_needs_seo_data_transporter_notice' );
		add_action( 'admin_notices', 'add_wpseo_needs_seo_data_transporter_notice' );
	}

	function add_wpseo_needs_seo_data_transporter_notice() {
		?>
			<div class="notice notice-warning is-dismissible">
				<p><?php _e( 'The Plugin SEO Data Transporter needs to be active in order for Export wpSEO to run.', 'export-wpseo' ); ?></p>
			</div>
		<?php
	}

?>
