<?php

namespace AdvancedPostSearch\WP\Field;

/**
 * AdvancedPostSearch\WP\Field\DateRange class.
 */
class DateRange extends \AdvancedPostSearch\WP\Field {

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
			$settings = $this->getFieldSettings($this->key.'.from', ['>=', '>', '=']);
			?><input class="input-prepend" type="text" name="<?= $settings['compare']['name']; ?>" readonly="readonly" value="<?= $settings['compare']['value']; ?>" data-options="<?= $settings['compare']['options']; ?>" />
			<input class="input-prepended" type="text" id="<?= $settings['value']['id']; ?>" name="<?= $settings['value']['name']; ?>" value="<?= $settings['value']['value']; ?>" data-date-format="yy-mm-dd" />
			<div class="field-joiner">&amp;</div>
		</div>
		<div class="aps-filter"><?php
			$settings = $this->getFieldSettings($this->key.'.to', ['<=', '<', '=']);
			?><label for="aps_wp_<?= $this->key; ?>_to">&nbsp;</label>
			<input class="input-prepend" type="text" name="<?= $settings['compare']['name']; ?>" readonly="readonly" value="<?= $settings['compare']['value']; ?>" data-options="<?= $settings['compare']['options']; ?>" />
			<input class="input-prepended" type="text" id="<?= $settings['value']['id']; ?>" name="<?= $settings['value']['name']; ?>" value="<?= $settings['value']['value']; ?>" data-date-format="yy-mm-dd" /><?php
	}

	/**
	 * Gets where.
	 *
	 * @access public
	 * @return array
	 */
	public function getWhere() {
		$where = '';
		if ($filter = $this->getFilter($this->key.'.from', ['>=', '>', '='])) {
			$where .= ' AND ('.$this->key.' '.$filter['compare'].' "'.$filter['value'].'")';
		}
		if ($filter = $this->getFilter($this->key.'.to', ['<=', '<', '='])) {
			$where .= ' AND ('.$this->key.' '.$filter['compare'].' "'.$filter['value'].'")';
		}
		return $where;
	}

	/** **************************************************************************************************** */

}