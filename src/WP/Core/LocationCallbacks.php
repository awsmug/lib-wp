<?php

namespace AWSM\LibWP\WP\Core;

/**
 * Class LocationCallbacks.
 * 
 * This class determines at which part of the site we are.
 *
 * @since 1.0.0
 *
 * @package SvenWagener\WP_Plugin
 */
class LocationCallbacks {
	/**
	 * Are we in wp-admin?
	 *
	 * @return bool True on WordPress admin, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function admin() : array {
		return [ ['Location', 'admin' ] ];
	}

	/**
	 * Are we running in an AJAX script?
	 *
	 * @return bool True on WordPress ajax, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function ajax() : array {
		return [ ['Location', 'ajax' ] ];
	}

	/**
	 * Are we on the frontend, of the page?
	 *
	 * @return bool True on WordPress frontend, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function frontend() : array {
		return [ ['Location', 'frontend' ] ];
	}

	/**
	 * Are we on the home page?
     * 
	 * @return bool True on WordPress home, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function home() : array {
		return [ ['Location', 'home' ] ];
	}

	/**
	 * Are we on a page?
	 *
	 * @return bool True on WordPress page, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function page() : array {
		return [ ['Location', 'page' ] ];
    }

	/**
	 * Are we on a single post/post-type?
	 *
	 * @return bool True on WordPress page, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function single() : array {
		return [ [ 'Location', 'single' ] ];
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
		return [ [ 'Location', 'postId' ], $postId ];
    }

	/**
	 * Are we on the blog home?
	 *
	 * @return bool True on WordPress blog home, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function blogHome() : array {
		return [ [ 'Location', 'blogHome' ] ];
	}

	/**
	 * Are wie in a blog post?
	 *
	 * @return bool True on WordPress blog home, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function blogPost() : array {
		return [ [ 'Location', 'blogPost' ] ];
    }
    
    /**
	 * Are we in a specific post type?
	 *
	 * @return bool True on WordPress blog home, false if not.
	 *
	 * @since 1.0.0
	 */
	public static function postType( string $postType ) : array {
		return [ [ 'Location', 'postId' ], $postType ];
	}
}
