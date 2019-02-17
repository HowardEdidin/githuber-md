<?php
/**
 * Class RichEditing
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Githuber
 * @since 1.6.0
 * @version 1.6.0
 */

namespace Githuber\Controller;

class RichEditing extends ControllerAbstract {

    const MD_POST_META_DISABLED = '_is_githuber_md_disabled';

	/**
	 * Constructer.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Initialize.
	 */

	public function init() {

    }

	/**
	 * Register CSS style files.
	 */
	public function admin_enqueue_styles( $hook_suffix ) {

    }

	/**
	 * Register JS files.
	 */
    public function admin_enqueue_scripts( $hook_suffix ) {

    }

	/**
	 * Enable rich editor.
	 */
	function enable() {
		add_action( 'admin_init', array( $this, '_rich_editing_true' ) );
    }
    
	/**
	 * Enable rich editor.
	 */
	function disable() {
		add_action( 'admin_init', array( $this, '_rich_editing_false' ) );
    }
    
    /**
	 * Get current postmeta.
	 */
    function is_current_post_markdown_enabled() {
        $post_id = githuber_get_current_post_id();

		$markdown_per_post = get_metadata( 'post', $post_id, self::MD_POST_META_DISABLED, true );
        $is_markdowin      = (bool) $markdown_per_post;

        return $is_markdowin;
    }

	/**
	 * Apply hook for enabling rich editor.
	 */
	function _rich_editing_true() {
		global $current_user;

		if ( ! user_can_richedit() ) {
			update_user_option( $current_user->ID, 'rich_editing', 'true', true );
		}
		add_filter( 'user_can_richedit' , '__return_true', 50 );
	}

    /**
	 * Apply hook for disabling rich editor.
	 */
	function _rich_editing_false() {
		global $current_user;

		if ( user_can_richedit() ) {
			update_user_option( $current_user->ID, 'rich_editing', 'false', true );
		}
		add_filter( 'user_can_richedit' , '__return_false', 50 );
    }  
}