<?php

namespace AdvancedPostSearch;

/**
 * \AdvancedPostSearch\FieldGroup class.
 */
abstract class FieldGroup {

	/** **************************************************************************************************** */

	/**
	 * Group key (default value: false)
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $key = false;

	/**
	 * Group label (default value: false)
	 *
	 * @var bool
	 * @access protected
	 */
	protected $label = false;

	/**
	 * Group fields objects (default value: [])
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $fields = [];

	/** **************************************************************************************************** */

	/**
	 * Gets default group status for a post type.
	 *
	 * @access public
	 * @abstract
	 * @param string $post_type post type
	 * @return bool
	 */
	abstract public function defaultStatus($post_type);

	/** **************************************************************************************************** */

	/**
	 * Creates a new \AdvancedPostSearch\FieldGroup.
	 *
	 * @access public
	 * @param string $key group key
	 * @return void
	 */
	public function __construct($key, $label = '') {
		$this->label = $label;
		$this->key = $key;
		$this->fields = [];
	}

	/**
	 * Registers a field.
	 *
	 * @access public
	 * @param \AdvancedPostSearch\Field $field field
	 * @return bool
	 */
	public function registerField(\AdvancedPostSearch\Field $field) {
		if (!in_array($field, $this->fields)) {
			$this->fields[] = $field;
			return true;
		}
		return false;
	}

	/**
	 * Checks if a group is valid.
	 *
	 * @access public
	 * @return bool
	 */
	public function isValid() {
		return ($this->key !== false);
	}

	/**
	 * Gets a group attribute.
	 *
	 * @access public
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key) {
		if (property_exists($this, $key)) {
			return $this->$key;
		}
		return null;
	}

	/** **************************************************************************************************** */

	/**
	 * Gets all ACF groups or a single grupp if key was specified.
	 *
	 * @access public
	 * @static
	 * @param mixed $key (default: null)
	 * @return \AdvancedPostSearch\FieldGroup|array
	 */
	public static function get($key = null, $label = null) {
		if (is_string($key)) {
			$group = new self($key, $label);
			return ($group->isValid() ? $group : false);
		}
		return [];
	}

	/** **************************************************************************************************** */

}