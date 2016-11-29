<?php

namespace AdvancedPostSearch\WP;

/**
 * AdvancedPostSearch\WP\Field class.
 *
 * @abstract
 */
abstract class Field extends \AdvancedPostSearch\Field {

	/** **************************************************************************************************** */

	/**
	 * Wordpress field key (default value: false)
	 *
	 * @var bool
	 * @access protected
	 */
	protected $key = false;

	/**
	 * Wordpress field label (default value: false)
	 *
	 * @var bool
	 * @access protected
	 */
	protected $label = false;

	/** **************************************************************************************************** */

	/**
	 * Creates a new Field subclass.
	 *
	 * @access public
	 * @param string $key
	 * @param string $label
	 * @return void
	 */
	public function __construct($key, $label) {
		parent::__construct();
		$this->label = $label;
		$this->key = $key;
	}

	/**
	 * Gets the field id.
	 *
	 * @access public
	 * @return void
	 */
	public function id() {
		$settings = $this->getFieldSettings($this->key);
		return $settings['value']['id'];
	}

	/**
	 * Checks if a field is valid.
	 *
	 * @access public
	 * @final
	 * @return void
	 */
	public final function isValid() {
		return true;
	}

	/**
	 * Gets meta_query.
	 *
	 * @access public
	 * @return bool|string
	 */
	public function getMetaQuery() {
		return false;
	}

	/**
	 * Gets a field configuration for submission.
	 *
	 * @access public
	 * @param string $path field path
	 * @param array $acceptedCompares compare types (default: false)
	 * @return array
	 */
	public function getFieldSettings($path, $acceptedCompares = false) {
		return parent::getFieldSettings((0 !== strpos($path, 'wp.') ? 'wp.' : '').$path, $acceptedCompares);
	}

	/**
	 * Gets a filter for a specific field.
	 *
	 * @access public
	 * @static
	 * @param string $path filter path
	 * @param array $acceptedCompares compare types (default: [])
	 * @param bool $processLike process like by adding "%"
	 * @return array
	 */
	public function getFilter($path, $acceptedCompares = [], $processLike = false) {
		return parent::getFilter((0 !== strpos($path, 'wp.') ? 'wp.' : '').$path, $acceptedCompares, $processLike);
	}

	/**
	 * Gets a field attribute.
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
	 * Gets a field by key
	 *
	 * @access public
	 * @static
	 * @param string $type
	 * @param string $key
	 * @param string $label
	 * @return void
	 */
	public static function get($type, $key, $label, $extra) {
		return parent::get(__CLASS__, $type, $key, $label, $extra);
	}

	/** **************************************************************************************************** */

}