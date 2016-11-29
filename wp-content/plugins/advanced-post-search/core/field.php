<?php

namespace AdvancedPostSearch;

/**
 * AdvancedPostSearch\Field class.
 *
 * @abstract
 */
abstract class Field {

	/** **************************************************************************************************** */

	/**
	 * Gets the field id.
	 *
	 * @access public
	 * @abstract
	 * @return void
	 */
	abstract public function id();

	/**
	 * Renders the field.
	 *
	 * @access public
	 * @abstract
	 * @return void
	 */
	abstract public function render();

	/**
	 * Checks if a field is valid.
	 *
	 * @access public
	 * @abstract
	 * @return void
	 */
	abstract public function isValid();

	/**
	 * Gets where.
	 *
	 * @access public
	 * @abstract
	 * @return void
	 */
	abstract public function getWhere();

	/**
	 * Gets meta_query.
	 *
	 * @access public
	 * @abstract
	 * @return void
	 */
	abstract public function getMetaQuery();

	/** **************************************************************************************************** */

	/**
	 * Creates a new Field subclass.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Gets autocomplete for a field.
	 *
	 * @access public
	 * @param string $search
	 * @param string $destination
	 * @return array
	 */
	public function autocomplete($search, $destination) {
		return [];
	}

	/** **************************************************************************************************** */

	/**
	 * Gets a field configuration for submission.
	 *
	 * @access public
	 * @param string $path field path
	 * @param array $acceptedCompares compare types (default: false)
	 * @return array
	 */
	public function getFieldSettings($path, $acceptedCompares = false) {
		$baseName = sprintf('%s[%s]', \AdvancedPostSearch::IDENTIFIER, str_replace('.', '][', $path));
		$defaultCompare = (is_array($acceptedCompares) ? current($acceptedCompares) : '');
		$baseId = str_replace('.', '_', \AdvancedPostSearch::IDENTIFIER.'.'.$path);
		$filter = $this->getFilter($path, $acceptedCompares);
		return [
			'value'      => [
				'value'     => ($filter ? $filter['value'] : ''),
				'name'      => $baseName.'[value]',
				'id'        => $baseId.'_value',
			],
			'compare'    => [
				'options'   => (is_array($acceptedCompares) ? implode(',', $acceptedCompares) : ''),
				'value'     => ($filter ? $filter['compare'] : $defaultCompare),
				'name'      => $baseName.'[compare]',
				'id'        => $baseId.'_compare',
			]
		];
	}

	/**
	 * Gets a filter for a specific field.
	 *
	 * @access public
	 * @param string $path filter path
	 * @param array $acceptedCompares compare types (default: [])
	 * @param bool $processLike process like by adding "%"
	 * @return array
	 */
	public function getFilter($path, $acceptedCompares = [], $processLike = false) {
		$node = array_reduce(explode('.', $path), function ($node, $key) {
			return ($node && array_key_exists($key, $node) ? $node[$key] : false);
		}, $sources = $this->buildSource($_SESSION));
		// check node
		if ($node === false) {
			return false;
		}
		// check compares
		if ($acceptedCompares !== false && !in_array($node['compare'], $acceptedCompares)) {
			return false;
		}
		// fix data
		if ('' === ($node['value'] = esc_sql($node['value']))) {
			return false;
		}
		if ($processLike && false !== stripos($node['compare'], 'LIKE')) {
			$node['value'] = '%'.$node['value'].'%';
		}
		// return filter
		return $node;
	}

	/**
	 * Builds data source.
	 *
	 * @access private
	 * @return array
	 */
	private function buildSource() {
		return array_reduce(func_get_args(), function ($sources, $source) {
			if (array_key_exists(\AdvancedPostSearch::IDENTIFIER, $source) && is_array($source[\AdvancedPostSearch::IDENTIFIER])) {
				$sources = array_merge($sources, $source[\AdvancedPostSearch::IDENTIFIER]);
			}
			return $sources;
		}, []);
	}

	/** **************************************************************************************************** */

	/**
	 * Gets a field by type.
	 *
	 * @access protected
	 * @static
	 * @param object $parent
	 * @param string $type
	 * @param mixed ...
	 * @return bool|object
	 */
	protected static function get() {
		$args = func_get_args();
		if (count($args) >= 2) {
			$parent = array_shift($args);
			$type = array_shift($args);
			$class = self::fieldClassByType($parent, $type);
			$class = apply_filters('aps/field/get_class_by_type', $class, $type);
			try {
				$reflection = new \ReflectionClass($class);
				if ($reflection->isSubclassOf($parent)) {
					$fieldObject = $reflection->newInstanceArgs($args);
					return ($fieldObject->isValid() ? $fieldObject : false);
				}
			} catch (\Exception $e) {
				return false;
			}
		}
		return false;
	}

	/**
	 * Gets the class for a field type.
	 *
	 * @access private
	 * @static
	 * @param object $parent
	 * @param string $type
	 * @return string
	 */
	private static function fieldClassByType($parent, $type) {
		// change "_" into " "
		$class = str_replace('_', ' ', $type);
		// add caps on word's first letter
		$class = ucwords($class);
		// remove " "
		$class = str_replace(' ', '', $class);
		// return
		return $parent.'\\'.$class;
	}

	/** **************************************************************************************************** */

}