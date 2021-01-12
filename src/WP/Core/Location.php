<?php

namespace AWSM\LibWP\WP\Core;

/**
 * Class WP_Location.
 * 
 * This class determines at which part of the site we are.
 *
 * @since 1.0.0
 *
 * @package SvenWagener\WP_Plugin
 */
class Location {
	/**
	 * Are we in wp-admin?
	 *
	 * @return bool True on WordPress admin, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function admin() {
		return is_admin();
	}

	/**
	 * Are we running in an AJAX script?
	 *
	 * @return bool True on WordPress ajax, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function ajax() {
		return defined( 'DOING_AJAX' ) && DOING_AJAX;
	}

	/**
	 * Are we on the frontend, of the page?
	 *
	 * @return bool True on WordPress frontend, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function frontend() {
		return ! self::admin() && ! self::ajax();
	}

	/**
	 * Are we on the home page?
     * 
	 * @return bool True on WordPress home, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function home() {
		return is_front_page();
	}

	/**
	 * Are we on a page?
	 *
	 * @return bool True on WordPress page, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function page() : bool {
		return is_page();
    }

	/**
	 * Are we on a single post/post-type?
	 *
	 * @return bool True on WordPress page, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function single() : bool {
		return is_single();
	}

	/**
	 * Are we on a specifig post?
	 *
	 * @param int $page_id Post id.
	 * @return bool True on WordPress page, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function postId( int $postId ) : bool {
		global $post;
		return $postId === $post->ID;
	}

	/**
	 * Are we on the blog home?
	 *
	 * @return bool True on WordPress blog home, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function blogHome() : bool {
		return is_home();
	}

	/**
	 * Are wie in a blog post?
	 *
	 * @return bool True on WordPress blog home, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function blogPost() : bool {
		return is_single() && 'post' == get_post_type();
	}

	/**
	 * Are we in a specific post type?
	 *
	 * @return bool True on WordPress blog home, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function postType( string $postType ) : bool {
		return is_single() && $post_type == get_post_type();
	}
}
