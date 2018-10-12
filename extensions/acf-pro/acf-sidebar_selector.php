<?php if ( class_exists('acf_field_sidebar_selector') ) return;
/**
 * ACF PRO Sidebar Selector Class
 *
 * The role selector class enables users to select sidebars. This is
 * the class that is used for ACF Pro.
 *
 * @author Daniel Pataki
 * @since 3.0.0
 * @link https://github.com/danielpataki/acf-sidebar-selector
 *
 */

class acf_field_sidebar_selector extends acf_field {

	/**
	 * Field Constructor
	 *
	 * Sets basic properties and runs the parent constructor
	 *
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function __construct() {

		$this->name = 'sidebar_selector';
		$this->label = __( 'Sidebar Selector', 'xe-core' );
		$this->category = __( "Choice", 'xe-core' );
		$this->defaults = array(
			'allow_null' => '1',
			'default_value' => ''
		);

    	parent::__construct();

	}


	/**
	 * Field Options
	 *
	 * Creates the options for the field, they are shown when the user
	 * creates a field in the back-end. Currently there are two fields.
	 *
	 * Allowing null determines if the user is allowed to select no sidebars
	 *
	 * The default value can set the dropdown to a pre-set value when loaded
	 *
	 * @param array $field The details of this field
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function render_field_settings( $field ) {

		acf_render_field_setting( $field, array(
			'label'			=> __('Allow Null?','xe-core'),
			'type'			=> 'radio',
			'name'			=> 'allow_null',
			'layout'  =>  'horizontal',
			'choices' =>  array(
				'1' => __('Yes', 'xe-core'),
				'0' => __('No', 'xe-core'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Default Value','xe-core'),
			'type'			=> 'text',
			'name'			=> 'default_value',
		));


	}



	/**
	 * Field Display
	 *
	 * This function takes care of displaying our field to the users, taking
	 * the field options into account.
	 *
	 * @param array $field The details of this field
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function render_field( $field ) {
		global $wp_registered_sidebars;
		?>
		<div>
			<select name='<?php echo $field['name'] ?>'>
				<?php if ( !empty( $field['allow_null'] ) ) : ?>
					<option value=''><?php _e( 'Select a Sidebar', 'xe-core' ) ?></option>
				<?php endif ?>
					<option value='default'>Default</option>
				<?php
					foreach( $wp_registered_sidebars as $sidebar ) :
					$selected = ( ( $field['value'] == $sidebar['id'] ) || ( empty( $field['value'] ) && $sidebar['id'] == $field['default_value'] ) ) ? 'selected="selected"' : '';
				?>
					<option <?php echo $selected ?> value='<?php echo $sidebar['id'] ?>'><?php echo $sidebar['name'] ?></option>
				<?php endforeach; ?>

			</select>
		</div>

		<?php
	}



}

new acf_field_sidebar_selector();
