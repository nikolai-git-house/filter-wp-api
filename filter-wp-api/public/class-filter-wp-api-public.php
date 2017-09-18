<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Filter_WP_Api
 * @subpackage Filter_WP_Api/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Filter_WP_Api
 * @subpackage Filter_WP_Api/public
 * @author     Ogulcan Orhan <ogulcanorhan@gmail.com>
 */
class Filter_WP_Api_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Filter_WP_Api    The ID of this plugin.
	 */
	private $Filter_WP_Api;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Filter_WP_Api       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Filter_WP_Api, $version ) {

		$this->Filter_WP_Api = $Filter_WP_Api;
		$this->version = $version;

	}

	/**
	 * This function will filter Wordpress REST API fields.
	 *
	 * @since 	   1.0.0
	 * @param      mixed    $data       Post objects
	 */
	public function apply_filter( $data ) {
		$options = (get_option('filter-wp-api_options') ? get_option('filter-wp-api_options') : false);

		$disabled = isset($options["disable-filter"]);
		$disabled_compact = isset($options["disable-filter-compact"]);
		$disabled_detailed = isset($options["disable-filter-detailed"]);

		if ($options == FALSE || $disabled == FALSE) {
			if (isset($_GET['_compact']) && $disabled_compact == FALSE) {
			    
			    $featured_image_id = $data->data['featured_media'];
	        	$featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'original' );
		        
		        return [
		            'id'        => $data->data['id'],
		            'title'     => $data->data['title']['rendered'],
		            'link'      => $data->data['link'],
		            'image'     => $featured_image_url[0]
		        ];
			}

			if (isset($_GET['_detailed']) && $disabled_detailed == FALSE) {
				
				$featured_image_id = $data->data['featured_media'];
	        	$featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'original' );
		        
		        return [
		            'id'        => $data->data['id'],
		            'title'     => $data->data['title']['rendered'],
		            'link'      => $data->data['link'],
		            'image'     => $featured_image_url[0],
		            'content'	=> $data->data['content']['rendered'],
		            'date'		=> $data->data['modified'],
		            'categories' => $data->data['categories']
		        ];
			}
		} 

	    return $data;		
	}
}
