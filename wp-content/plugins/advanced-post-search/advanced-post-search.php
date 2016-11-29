<?php
/**
 * Plugin Name: Advanced Post Search
 * Plugin URI: https://wordpress.org/plugins/advanced-post-search/
 * Description: Advanced Post Search is a WordPress plugin for anyone who needs an advanced search for posts (or custom posts) in a WordPress website.
 * Version: 1.0.1
 * License: Apache License 2.0
 *
 * Author: VarDump s.r.l.
 * Author URI: https://www.var-dump.it/
 * Copyright: VarDump s.r.l.
 *
 * Text Domain: aps
 * Domain Path: /lang
 */

// plugin root
if (!defined('APS_ROOT')) {
	define('APS_ROOT', __DIR__);
}

if (!class_exists('AdvancedPostSearch')) {

	class AdvancedPostSearch {

		/**
		 * IDENTIFIER (value: 'aps')
		 *
		 * @const string
		 * @access public
		 */
		const IDENTIFIER = 'aps';

		/**
		 * base_url (default value: null)
		 *
		 * @var mixed
		 * @access private
		 */
		private $base_url = null;

		/**
		 * default_options (default: value [])
		 *
		 * @var mixed
		 * @access private
		 */
		private $default_options = [
			'show_groups' => false
		];

		/**
		 * Create a new AdvancedPostSearch
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			// session
			if (!session_id()) {
				session_start();
			}
			// plugin autoloader
			spl_autoload_register(function ($class) {
				$classFile = strtolower(str_replace([__CLASS__, '\\'], ['', '/'], $class));
				if (file_exists(APS_ROOT.'/core/'.$classFile.'.php')) {
					require_once(APS_ROOT.'/core/'.$classFile.'.php');
				}
			});
			// base url
			$this->base_url = plugin_dir_url(__FILE__);
			// initialization
			$this->init();
		}

		/**
		 * Initialize an AdvancedPostSearch.
		 *
		 * @access public
		 * @return void
		 */
		public function init() {
			// actions
			add_action('load-edit.php', [$this, 'loadEditInjectForm'], 10, 0);
			add_action('plugins_loaded', [$this, 'pluginsLoaded'], 10, 0);
			add_action('admin_menu', [$this, 'adminMenu'], 10, 0);
			// options
			if (false === get_option('aps_views', false)) {
				update_option('aps_views', [], false);
			}
		}

		/**
		 * Load plugin textdomain.
		 *
		 * @access public
		 * @return void
		 */
		public function pluginsLoaded() {
			load_plugin_textdomain('aps', false, dirname(plugin_basename( __FILE__ )).'/lang/');
			do_action('aps/plugin/loaded');
		}

		/**
		 * Register the admin menu items.
		 *
		 * @access public
		 * @return void
		 */
		public function adminMenu() {
			global $submenu;
			add_menu_page(__('Advanced Post Search', 'aps'), __('Advanced Post Search', 'aps'), 'manage_options', 'aps-views', [$this, 'screenViews'], 'dashicons-search', 85);
			add_submenu_page('aps-views', __('FAQ', 'aps'), __('FAQ', 'aps'), 'manage_options', 'aps-faq', [$this, 'screenFaq']);
			$submenu['aps-views'][0][0] = __('Views', 'aps');
		}

		/**
		 * Views management.
		 *
		 * @access public
		 * @return void
		 */
		public function screenViews() {
			$post_types = get_post_types(['public' => true], 'objects');
			unset($post_types['attachment']); // remove attachments
			$field_groups = $this->getFieldGroups();
			$views = get_option('aps_views', []);
			if (@$_REQUEST['aps-action'] === 'update-options') {
				$views = call_user_func_array('array_merge', array_map(function ($post_type) {
					return [
						$post_type => [
							'fields'  => ($_REQUEST['views'][$post_type]['fields'] ?: []),
							'options' => ($_REQUEST['views'][$post_type]['options'] ?: [])
						]
					];
				}, array_keys($post_types)));
				update_option('aps_views', $views, false);
			}
			?><div class="wrap">
				<form method="post" action="?<?= $_SERVER['QUERY_STRING']; ?>">
					<input type="hidden" name="aps-action" value="update-options" />
					<h1><?php _e('Views', 'aps'); ?></h1>
					<br />
					<table class="widefat fixed">
						<thead>
							<tr>
								<th><?php _e('Field Group', 'aps'); ?></th>
								<?php foreach ($post_types as $post_type => $object): ?>
									<th class="num"><?= $object->label; ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><?php _e('Field Group', 'aps'); ?></th>
								<?php foreach ($post_types as $post_type => $object): ?>
									<th class="num"><?= $object->label; ?></th>
								<?php endforeach; ?>
							</tr>
						</tfoot>
						<tbody>
							<!-- fields -->
							<?php foreach ($field_groups as $idx => $field_group): ?>
								<tr class="bar">
									<td><strong><?= $field_group->label; ?></strong></td>
									<?php foreach ($post_types as $post_type => $object): ?>
									<?php $enabled = $this->isEnabled($post_type, $field_group); ?>
									<td class="num">
										<input type="checkbox" data-name="views[<?= $post_type; ?>][fields][<?= $field_group->key; ?>][]" <?= ($checked ? ' checked="checked"' : ''); ?><?= ($enabled ? '' : ' disabled="disabled"'); ?> />
									</td>
									<?php endforeach; ?>
								</tr>
								<!-- fields -->
								<?php foreach ($field_group->fields as $idx => $field): ?>
								<tr class="<?= ($idx % 2 == 0 ? 'alternate' : ''); ?>">
									<td>&mdash; <?= $field->label; ?></td>
									<?php foreach ($post_types as $post_type => $object): ?>
									<?php $enabled = $this->isEnabled($post_type, $field_group, $field); ?>
									<?php $checked = $this->isActive(@$views[$post_type]['fields'], $post_type, $field_group, $field); ?>
									<td class="num">
										<input type="checkbox" name="views[<?= $post_type; ?>][fields][<?= $field_group->key; ?>][]" value="<?= $field->key; ?>"<?= ($checked ? ' checked="checked"' : ''); ?><?= ($enabled ? '' : ' disabled="disabled"'); ?> />
									</td>
									<?php endforeach; ?>
								</tr>
								<?php endforeach; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php if ($this->isProEnabled()): ?>
					<br />
					<h1><?php _e('Options', 'aps'); ?></h1>
					<br />
					<table class="widefat fixed">
						<thead>
							<tr>
								<th><?php _e('Option', 'aps'); ?></th>
								<?php foreach ($post_types as $post_type => $object): ?>
									<th class="num"><?= $object->label; ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><?php _e('Option', 'aps'); ?></th>
								<?php foreach ($post_types as $post_type => $object): ?>
									<th class="num"><?= $object->label; ?></th>
								<?php endforeach; ?>
							</tr>
						</tfoot>
						<tbody>
							<tr class="alternate">
								<td style="vertical-align: middle;"><strong><?php _e('Show Groups', 'aps'); ?></strong></td>
								<?php foreach ($post_types as $post_type => $object): ?>
									<?php $options = array_merge($this->default_options, (array) @$views[$post_type]['options']); ?>
									<td class="num">
										<select name="views[<?= $post_type; ?>][options][show_groups]">
											<option value="0"<?= (!$options['show_groups'] ? ' selected="selected"' : ''); ?>><?php _e('No', 'aps'); ?></option>
											<option value="1"<?= ($options['show_groups'] ? ' selected="selected"' : ''); ?>><?php _e('Yes', 'aps'); ?></option>
										</select>
									</td>
								<?php endforeach; ?>
							</tr>
						</tbody>
					</table>
					<?php endif; ?>
					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e('Update'); ?>" />
					</p>
				</form>
			</div>
			<script type="text/javascript">
				jQuery(function () {
					jQuery('[type="checkbox"][data-name]').change(function (evt) {
						var $this = jQuery(this), name = $this.data('name'), checked = $this.is(':checked');
						jQuery('[name="' + name + '"]').attr('checked', checked);
					}).each(function () {
						var $this = jQuery(this), name = $this.data('name');
						$this.attr('checked', jQuery('[name="' + name + '"]').length === jQuery('[name="' + name + '"]:checked').length);
					});
				});
			</script><?php
		}

		/**
		 * Help.
		 *
		 * @access public
		 * @return void
		 */
		public function screenFaq() {
			?><div class="wrap">
				<h1><?php _e('Frequently Asked Questions', 'aps'); ?></h1>
				<div class="faq-item">
					<h2><?php _e('Q. How do I use the plugin?', 'aps'); ?></h2>
					<p><?php _e('A. The main search form is in the posts list (also available for pages or custom posts) and can be accessed by the "Advanced Search" dropdown on the top right of the screen.', 'aps'); ?></p>
				</div>
				<div class="faq-item">
					<h2><?php _e('Q. How do I make a search?', 'aps'); ?></h2>
					<p><?php _e('A. In the "Advanced Search" form you can fill one or more fields with the desired search terms, then press the "Search" button to perform the search.', 'aps'); ?></p>
				</div>
				<div class="faq-item">
					<h2><?php _e('Q. How do I change comparison operator?', 'aps'); ?></h2>
					<p><?php _e('A. Every search field has different comparison types depending on field type: in a date field you can search values after or before a date or between two specific dates.', 'aps'); ?></p>
				</div>
				<div class="faq-item">
					<h2><?php _e('Q. How do I manage what fields are showed in the search form?', 'aps'); ?></h2>
					<p><?php _e('A. In the Views page you have a table showing registered post types; for each post type you can choose what fields you want to show in the search form by checking the corresponding checkbox.', 'aps'); ?></p>
				</div>
				<div style="margin-top: 100px;">
					<p><?php printf(__('For more information mail us at %1$s.', 'aps'), '<a href="mailto:plugins@var-dump.it?subject=Advanced Post Search">plugins@var-dump.it</a>'); ?></a></p>
				</div>
			</div><?php
		}

		/**
		 * Render Advanced Post Search in posts list.
		 *
		 * @access public
		 * @return void
		 */
		public function loadEditInjectForm() {
			$screen = get_current_screen();
			if ('edit-'.$screen->post_type === $screen->id) {
				// include js && css
				wp_enqueue_script('aps', $this->base_url.'/js/advanced-post-search.js', ['jquery', 'jquery-ui-datepicker'], false, true);
				wp_enqueue_style('aps', $this->base_url.'/css/advanced-post-search.css', false, false, 'all');
				wp_enqueue_style('jquery-ui-css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
				// inject HTML
				add_action('all_admin_notices', [$this, 'allAdminNotices'], 10, 0);
				// inject query filters
				add_action('pre_get_posts', [$this, 'preGetPosts'], 10, 1);
				// inject query WHERE
				add_filter('posts_where', [$this, 'postsWhere'], 10, 2);
				// save session
				if (@$_REQUEST['aps-action'] === 'advanced-search') {
					if (array_key_exists(self::IDENTIFIER, $_REQUEST)) {
						$_SESSION[self::IDENTIFIER] = $_REQUEST[self::IDENTIFIER];
					}
				} else {
					$_SESSION[self::IDENTIFIER] = [];
				}
			}
		}

		/**
		 * Render search form.
		 *
		 * @access public
		 * @return void
		 */
		public function allAdminNotices() {
			$screen = get_current_screen();
			$view = $this->getViewSettings();
			if ($field_groups = $this->getFieldGroups()) {
				?><!-- #aps-link -->
				<div id="aps-wrap" class="hidden no-sidebar" tabindex="-1" aria-label="<?php esc_attr_e('Advanced search', 'aps'); ?>">
					<form method="post" action="<?= add_query_arg('aps-action', 'advanced-search', '?'.$_SERVER['QUERY_STRING']); ?>">
						<div class="aps-groups">
							<?php foreach ($field_groups as $idx => $field_group): ?>
								<?php if ($this->isActive($view['fields'], $screen->post_type, $field_group)): ?>
									<?php if ($view['options']['show_groups']): // group block ?>
									<fieldset class="aps-filters" id="aps-general-filters">
										<legend><?= $field_group->label; ?></legend>
									<?php endif; // group block ?>
									<?php foreach ($field_group->fields as $field): ?>
										<?php if ($this->isActive($view['fields'], $screen->post_type, $field_group, $field)): ?>
											<div class="aps-filter field-<?= $field->type; ?>" data-field-key="<?= $field->key; ?>">
												<label for="acsfs_acf_<?= $field->key; ?>"><?= $field->label; ?></label>
												<?php $field->render(); ?>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
									<?php if ($view['options']['show_groups']): // group block ?>
									</fieldset>
									<?php endif; // group block ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
						<div class="clear"></div>
						<p class="submit">
							<input name="aps-submit" id="aps-submit" class="button button-primary" value="<?php esc_attr_e('Search', 'aps'); ?>" type="submit" />
						</p>
					</form>
				</div>
				<!-- #aps-link-wrap -->
				<div id="aps-link-wrap" class="hide-if-no-js screen-meta-toggle">
					<button type="button" id="aps-link" class="button show-settings" aria-controls="aps-wrap" aria-expanded="false"><?php _e('Advanced search', 'aps'); ?></button>
				</div><?php
			}
		}

		/**
		 * Filter post with search settings (meta_query).
		 *
		 * @access public
		 * @param mixed &$wp_query
		 * @return void
		 */
		public function preGetPosts(&$wp_query) {
			$screen = get_current_screen();
			if ($wp_query->query['post_type'] === $screen->post_type) {
				if (@$_REQUEST['aps-action'] === 'advanced-search') {
					$wp_query->query_vars['meta_query'] = array_reduce($this->getActiveFields(), function ($meta_query, $field) {
						return array_merge($meta_query, [$field->getMetaQuery()]);
					}, ['relation' => 'AND']);
				}
			}
		}

		/**
		 * Filter post with search settings (WHERE).
		 *
		 * @access public
		 * @param mixed $where
		 * @return string
		 */
		public function postsWhere($where, &$wp_query) {
			$screen = get_current_screen();
			if ($wp_query->query['post_type'] === $screen->post_type) {
				if (@$_REQUEST['aps-action'] === 'advanced-search') {
					$where = array_reduce($this->getActiveFields(), function ($where, $field) {
						return $where.(($append = $field->getWhere()) ? $append : '');
					}, $where);
				}
			}
			return $where;
		}

		/**
		 * Check if a field is active for a view or not
		 *
		 * @access private
		 * @param mixed $view
		 * @param mixed $post_type
		 * @param mixed $field_group
		 * @param bool $field (default: false)
		 * @return bool
		 */
		private function isActive($view, $post_type, $field_group, $field = false) {
			if (!($field_group instanceof \AdvancedPostSearch\FieldGroup)) {
				return false;
			}
			if ($field && !($field instanceof \AdvancedPostSearch\Field)) {
				return false;
			}
			if ($view) {
				if (array_key_exists($field_group->key, $view)) {
					if ($field) {
						$status =  in_array($field->key, $view[$field_group->key]);
					} else {
						$status = true;
					}
				} else {
					$status = false;
				}
			} else {
				$status = $field_group->defaultStatus($post_type);
			}
			if ($field === false) { // group
				return apply_filters('aps/group/active', $status, $post_type, $field_group->key);
			} else { // field
				$status = apply_filters('aps/group/active', $status, $post_type, $field_group->key);
				return apply_filters('aps/field/active', $status, $post_type, $field_group->key, $field->key);
			}
		}

		/**
		 * Check if a field is enabled for a view or not.
		 *
		 * @access private
		 * @param mixed $post_type
		 * @param mixed $field_group
		 * @param bool $field (default: false)
		 * @return void
		 */
		private function isEnabled($post_type, $field_group, $field = false) {
			if ($field === false) { // group
				return apply_filters('aps/group/enabled', true, $post_type, $field_group->key);
			} else { // field
				$status = apply_filters('aps/group/active', true, $post_type, $field_group->key);
				return apply_filters('aps/field/enabled', $status, $post_type, $field_group->key, $field->key);
			}
		}

		/**
		 * Get field groups.
		 *
		 * @access private
		 * @return void
		 */
		private function getFieldGroups() {
			$groups = [];
			// wordpress
			$wordpress = new \AdvancedPostSearch\WP\FieldGroup('wordpress', __('WordPress', 'aps'));
			array_map(function ($field) use (&$wordpress) {
				$wordpress->registerField($field);
			}, $this->getWordpressFields());
			$groups = array_merge($groups, [$wordpress]);
			// return
			return apply_filters('aps/groups/list', $groups);
		}

		/**
		 * Get active fields.
		 *
		 * @access private
		 * @return void
		 */
		private function getActiveFields() {
			$view = $this->getViewSettings();
			return call_user_func_array('array_merge', array_map(function ($field_group) use ($view) {
				if ($this->isActive($view['fields'], $view['post_type'], $field_group)) {
					return array_filter($field_group->fields, function ($field) use ($field_group, $view) {
						return $this->isActive($view['fields'], $view['post_type'], $field_group, $field);
					});
				}
				return [];
			}, $this->getFieldGroups()));
		}

		/**
		 * Get view settings.
		 *
		 * @access private
		 * @return void
		 */
		private function getViewSettings() {
			$screen = get_current_screen();
			$views = get_option('aps_views', []);
			if (array_key_exists($screen->post_type, $views)) {
				$options = array_merge($this->default_options, (array) @$views[$screen->post_type]['options']);
				$options = apply_filters('aps/view/options', $options, $screen->post_type);
				return [
					'post_type'    => $screen->post_type,
					'fields'       => $views[$screen->post_type]['fields'],
					'options'      => [
						'show_groups' => $options['show_groups']
					]
				];
			}
			return false;
		}

		/**
		 * Get wordpress fields.
		 *
		 * @access private
		 * @return array
		 */
		private function getWordpressFields() {
			return array_filter(array_map(function ($field) {
				$extra = array_diff_key($field, ['type' => '', 'key' => '', 'label' => '']);
				return \AdvancedPostSearch\WP\Field::get($field['type'], $field['key'], $field['label'], $extra);
			}, [
				[
					'type'     => 'text',
					'key'      => 'post_title',
					'label'    => __('Post title', 'aps')
				], [
					'type'     => 'select',
					'key'      => 'post_status',
					'label'    => __('Status', 'aps'),
					'choices'  => array_map(function ($status) {
						return $status->label;
					}, get_post_stati(['internal' => false], 'objects'))
				], [
					'type'     => 'select',
					'key'      => 'post_author',
					'label'    => __('Author', 'aps'),
					'choices'  => array_reduce(get_users(['who' => 'authors']), function ($authors, $author) {
						return ($authors + [$author->ID => $author->display_name]);
					}, [])
				], [
					'type'     => 'text',
					'key'      => 'post_name',
					'label'    => __('Slug', 'aps')
				], [
					'type'     => 'text',
					'key'      => 'post_password',
					'label'    => __('Password', 'aps')
				], [
					'type'     => 'text',
					'key'      => 'post_excerpt',
					'label'    => __('Excerpt', 'aps')
				], [
					'type'     => 'text',
					'key'      => 'post_content',
					'label'    => __('Content', 'aps')
				], [
					'type'     => 'date_range',
					'key'      => 'post_date',
					'label'    => __('Published', 'aps')
				], [
					'type'     => 'date_range',
					'key'      => 'post_modified',
					'label'    => __('Last Modified', 'aps')
				],
			]));
		}

		/**
		 * Check if PRO version is enabled.
		 *
		 * @access private
		 * @return void
		 */
		private function isProEnabled() {
			require_once ABSPATH.'wp-admin/includes/plugin.php';
			return is_plugin_active('advanced-post-search-pro/advanced-post-search-pro.php');
		}

	}

	/**
	 * AdvancedPostSearch function
	 *
	 * @return AdvancedPostSearch
	 */
	function AdvancedPostSearch() {
		global $AdvancedPostSearch;
		if (!isset($AdvancedPostSearch)) {
			$AdvancedPostSearch = new AdvancedPostSearch();
		}
		return $AdvancedPostSearch;
	}

	AdvancedPostSearch();

}
