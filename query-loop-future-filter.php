<?php
/**
 * Plugin Name: Query Loop Future Filter
 * Description: Adds a relative date filtering options to the core Query Loop Block
 * Version: 1.0.0
 * Author: Sandy McFadden
 * Author URI: https://sandy.mcfadden.blog
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register block editor assets.
 *
 * @return void
 */
function register_query_block_settings() {
	$asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
	
	wp_register_script(
		'custom-query-settings',
		plugins_url( 'build/index.js', __FILE__ ),
		array_merge(
			$asset_file['dependencies'],
			array(
				'wp-blocks',
				'wp-components',
				'wp-compose',
				'wp-hooks',
				'wp-block-editor',
				'wp-i18n',
			)
		),
		$asset_file['version'],
		true
	);

	wp_enqueue_script( 'custom-query-settings' );
}
add_action( 'enqueue_block_editor_assets', 'register_query_block_settings' );

/**
 * Initialize plugin functionality.
 */
function sm_query_loop_init() {
	$post_types = get_post_types( array( 'show_in_rest' => true, 'public' => true ) );
	
	foreach ( $post_types as $post_type ) {
		add_filter( "rest_{$post_type}_query", 'sm_query_loop_rest_query', 10, 2 );
	}
}
add_action( 'init', 'sm_query_loop_init' );

/**
 * Modify REST API query for date filtering.
 *
 * @param array           $args    Query arguments.
 * @param WP_REST_Request $request Request object.
 * @return array Modified query arguments.
 */
function sm_query_loop_rest_query( $args, $request ) {
	$date_range = $request->get_param( 'dateRange' );
	
	if ( 'future' === $date_range ) {
		$args['date_query'] = array(
			'after' => date( 'Y-m-d' ),
		);
	} elseif ( 'past' === $date_range ) {
		$args['date_query'] = array(
			'before' => date( 'Y-m-d' ),
		);
	}
	
	return $args;
}

/**
 * Modify block rendering.
 *
 * @param string|null $pre_render Pre-render content.
 * @param array       $block      Block data.
 * @return string|null
 */
function sm_query_loop_pre_render_block( $pre_render, $block ) {
	if ( 'core/query' === $block['blockName'] ) {
		add_filter(
			'query_loop_block_query_vars',
			function( $query ) use ( $block ) {
				if ( isset( $block['attrs']['query']['dateRange'] ) && $block['attrs']['query']['dateRange'] ) {
					$date_range = $block['attrs']['query']['dateRange'];

					if ( 'future' === $date_range ) {
						$query['date_query'] = array(
							'after' => date( 'Y-m-d' ),
						);
					} elseif ( 'past' === $date_range ) {
						$query['date_query'] = array(
							'before' => date( 'Y-m-d' ),
						);
					}
				}
				return $query;
			}
		);
	}
	return $pre_render;
}add_filter( 'pre_render_block', 'sm_query_loop_pre_render_block', 10, 2 );
