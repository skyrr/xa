<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('acf_field_user_related_text') ) :


class acf_field_user_related_text extends acf_field {
	
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options
		
		
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct( $settings )
	{
		// vars
		$this->name = 'user_related_text';
		$this->label = __('User Related Text');
		$this->category = __("Content",'acf'); // Basic, Content, Choice, etc
		$this->defaults = array(
			'default_value'	=> '',
			'formatting' 	=> 'br',
			'maxlength'		=> '',
			'placeholder'	=> '',
			'rows'			=> ''
		);
		
		
		// do not delete!
    	parent::__construct();
    	
    	
    	// settings
		$this->settings = $settings;

	}


	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function create_field( $field )
	{
        // vars
		$o = array( 'id', 'class', 'name', 'placeholder', 'rows' );
		$e = '';

		// maxlength
		if( $field['maxlength'] !== "" )
		{
			$o[] = 'maxlength';
		}

		// rows
		if( empty($field['rows']) )
		{
			$field['rows'] = 8;
		}

		$e .= '<textarea';

		foreach( $o as $k )
		{
			$e .= ' ' . $k . '="' . esc_attr( $field[ $k ] ) . '"';
		}

		$e .= '>';
        $currentUserValue= ( ! empty($field['value'][get_current_user_id()]) ) ? $field['value'][get_current_user_id()] : '';
		$e .= esc_textarea($currentUserValue);
		$e .= '</textarea>';

        // Other users data
        if ( is_array($field['value']) ) {
            foreach ($field['value'] as $userId => $value) {
                if ( $userId == get_current_user_id() ) continue;
                if ( empty($value) ) continue;
                $userData = get_userdata($userId);
                $e .= '<p class="label" style="margin-top: 20px;">' . $userData->display_name . ':</p>';
                $e .= '<textarea readonly>';
                $e .= esc_textarea($value);
                $e .= '</textarea>';
            }
        }

		// return
		echo $e;

	}

	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @param	$field	- an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function create_options( $field )
	{
		// vars
		$key = $field['name'];

		?>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Default Value",'acf'); ?></label>
				<p><?php _e("Appears when creating a new post",'acf') ?></p>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'	=>	'textarea',
					'name'	=>	'fields['.$key.'][default_value]',
					'value'	=>	$field['default_value'],
				));
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Placeholder Text",'acf'); ?></label>
				<p><?php _e("Appears within the input",'acf') ?></p>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'	=>	'text',
					'name'	=>	'fields[' .$key.'][placeholder]',
					'value'	=>	$field['placeholder'],
				));
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Character Limit",'acf'); ?></label>
				<p><?php _e("Leave blank for no limit",'acf') ?></p>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'	=>	'number',
					'name'	=>	'fields[' .$key.'][maxlength]',
					'value'	=>	$field['maxlength'],
				));
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Rows",'acf'); ?></label>
				<p><?php _e("Sets the textarea height",'acf') ?></p>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'			=> 'number',
					'name'			=> 'fields[' .$key.'][rows]',
					'value'			=> $field['rows'],
					'placeholder'	=> 8
				));
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Formatting",'acf'); ?></label>
				<p><?php _e("Effects value on front end",'acf') ?></p>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'	=>	'select',
					'name'	=>	'fields['.$key.'][formatting]',
					'value'	=>	$field['formatting'],
					'choices' => array(
						'none'	=>	__("No formatting",'acf'),
						'br'	=>	__("Convert new lines into &lt;br /&gt; tags",'acf'),
						'html'	=>	__("Convert HTML into tags",'acf')
					)
				));
				?>
			</td>
		</tr>
		<?php

	}



	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$post_id - the $post_id of which the value will be saved
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the modified value
	*/

	function update_value( $value, $post_id, $field )
	{
        $acf = new acf_field_functions();
        $valuesArray = $acf->load_value($value, $post_id, $field);
        $valuesArray[get_current_user_id()] = $value;
        return serialize($valuesArray);
	}



    /*
	*  format_value()
	*
	*  This filter is applied to the $value after it is loaded from the db and before it is passed to the create_field action
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/

    function format_value( $value, $post_id, $field )
    {
        return $value;
    }




	/*
	*  format_value_for_api()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/

	function format_value_for_api( $value, $post_id, $field )
	{
		// validate type
		if( !is_string($value[get_current_user_id()]) )
		{
			return $value[get_current_user_id()];
		}


		if( $field['formatting'] == 'none' )
		{
            $value[get_current_user_id()] = htmlspecialchars($value[get_current_user_id()], ENT_QUOTES);
		}
		elseif( $field['formatting'] == 'html' )
		{
			//$value = html_entity_decode($value);
			//$value = nl2br($value);
		}
		elseif( $field['formatting'] == 'br' )
		{
            $value[get_current_user_id()] = htmlspecialchars($value[get_current_user_id()], ENT_QUOTES);
            $value[get_current_user_id()] = nl2br( $value[get_current_user_id()] );
		}


		return $value[get_current_user_id()];
	}

}


// initialize
new acf_field_user_related_text( $this->settings );


// class_exists check
endif;

?>