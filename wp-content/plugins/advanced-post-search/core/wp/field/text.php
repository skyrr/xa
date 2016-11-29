<?php

namespace AdvancedPostSearch\WP\Field;

/**
 * AdvancedPostSearch\WP\Field\Text class.
 */
class Text extends \AdvancedPostSearch\WP\Field {

	/** **************************************************************************************************** */

	/**
	 * Creates a new Text field.
	 *
	 * @access public
	 * @param string $key
	 * @param string $label
	 * @return void
	 */
	public function __construct($key, $label) {
		parent::__construct($key, $label);
	}

	/**
	 * Renders the field.
	 *
	 * @access public
	 * @return void
	 */
	public function render() {
		$settings = $this->getFieldSettings($this->key, ['LIKE', '=']);
		?><input class="input-prepend" type="text" name="<?= $settings['compare']['name']; ?>" readonly="readonly" value="<?= $settings['compare']['value']; ?>" data-options="<?= $settings['compare']['options']; ?>" />
		<input class="input-prepended" type="text" id="<?= $settings['value']['id']; ?>" name="<?= $settings['value']['name']; ?>" value="<?= $settings['value']['value']; ?>" /><?php
	}

	/**
	 * Gets where.
	 *
	 * @access public
	 * @return string
	 */
	public function getWhere() {
		if ($filter = $this->getFilter($this->key, ['LIKE', '='], true)) {
			return ' AND ('.$this->key.' '.$filter['compare'].' "'.$filter['value'].'")';
		}
		return false;
	}

	/** **************************************************************************************************** */

}