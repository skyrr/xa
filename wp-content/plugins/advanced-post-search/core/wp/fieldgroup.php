<?php

namespace AdvancedPostSearch\WP;

/**
 * \AdvancedPostSearch\WP\FieldGroup class.
 */
class FieldGroup extends \AdvancedPostSearch\FieldGroup {

	/** **************************************************************************************************** */

	/**
	 * Creates a new \AdvancedPostSearch\ACF\FieldGroup.
	 *
	 * @access public
	 * @param string $key
	 * @return void
	 */
	public function __construct($key, $label) {
		parent::__construct($key, $label);
	}

	/**
	 * Gets default group status for a post type.
	 *
	 * @access public
	 * @param string $post_type post type
	 * @return bool
	 */
	public function defaultStatus($post_type) {
		return true;
	}

	/** **************************************************************************************************** */

}