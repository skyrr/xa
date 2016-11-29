<?php

namespace AdvancedPostSearch\WP\Field;

/**
 * AdvancedPostSearch\WP\Field\Select class.
 */
class Select extends \AdvancedPostSearch\WP\Field {

	/** **************************************************************************************************** */

	/**
	 * choices (default value: [])
	 *
	 * @var mixed
	 * @access private
	 */
	private $choices = [];

	/** **************************************************************************************************** */

	/**
	 * Creates a new Select field.
	 *
	 * @access public
	 * @param string $key
	 * @return void
	 */
	public function __construct($key, $label, $args) {
		parent::__construct($key, $label);
		$this->choices = $args['choices'] ?: [];
	}

	/**
	 * Renders the field.
	 *
	 * @access public
	 * @return void
	 */
	public function render() {
		$settings = $this->getFieldSettings($this->key, ['=', '!=']);
		?><input class="input-prepend" type="text" name="<?= $settings['compare']['name']; ?>" readonly="readonly" value="<?= $settings['compare']['value']; ?>" data-options="<?= $settings['compare']['options']; ?>" />
		<select class="input-prepended" id="<?= $settings['value']['id']; ?>" name="<?= $settings['value']['name']; ?>">
			<option value=""<?= ($settings['value']['value'] == '' ? ' selected="selected"' : ''); ?>>&nbsp;</option>
			<?php foreach ($this->choices as $key => $value): ?>
			<option value="<?= $key; ?>"<?= ($key == $settings['value']['value'] ? ' selected="selected"' : ''); ?>><?= $value; ?></option>
			<?php endforeach; ?>
		</select><?php
	}

	/**
	 * Gets where.
	 *
	 * @access public
	 * @return array
	 */
	public function getWhere() {
		if ($filter = $this->getFilter($this->key, ['=', '!='])) {
		 return ' AND ('.$this->key.' '.$filter['compare'].' "'.$filter['value'].'")';
		}
		return false;
	}

	/** **************************************************************************************************** */

}
