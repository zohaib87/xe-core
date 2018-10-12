<?php if ( class_exists('WPPress_ACF_Field') ) return;
/**
 * Class for ACF Pro Slider Fields.
 * 
 * Its a modified version of ACF Sliders extension.
 * 
 * @link https://github.com/WPPress/acf-sliders
 */

if ( !defined('ABSPATH') ) die(-1); 

abstract class WPPress_ACF_Field extends acf_field {

	var $label = "WPPress Slider";

	function __construct() {

		$this->name = $this->_create_name();
		$this->category = __("Sliders", 'xe-core');
		parent::__construct();

	}

	abstract protected function slider_output($data = false);
	abstract protected function slider_data();

	private function _create_name() {

		return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', "wpp_acf_" . $this->label) , '_'));

	}

	function format_value_for_api($value, $field) {
		
		if (!$value || $value == 'null') {
			return false;
		}
		if (is_array($value)) {
			foreach ($value as $k => $v) {
				$f = $this->slider_output($v);
				$value[$k] = array();
				$value[$k] = $f;
			}
		} else {
			$value = $this->slider_output($value);
		}
		
		return $value;

	}

	function create_field($field) {

		$field['multiple'] = isset($field['multiple']) ? $field['multiple'] : false;
		$field['disable'] = isset($field['disable']) ? $field['disable'] : false;
		$field['hide_disabled'] = isset($field['hide_disabled']) ? $field['hide_disabled'] : false;
		$multiple = '';
		if ($field['multiple'] == '1') {
			$multiple = ' multiple="multiple" size="5" ';
			$field['name'].= '[]';
		}
		echo '<select id="' . $field['name'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" ' . $multiple . ' >';
		if ($field['allow_null'] == '1') {
			echo '<option value="null"> - Select - </option>';
		}
		$sliders = $this->slider_data();
		if (!empty($sliders)) {
			foreach ($sliders as $key => $value) {
				$selected = '';
				if (is_array($field['value'])) {
					if (in_array($key, $field['value'])) {
						$selected = 'selected="selected"';
					}
				} else {
					if ($key == $field['value']) {
						$selected = 'selected="selected"';
					}
				}
				if (in_array(($key) , $field['disable'])) {
					if ($field['hide_disabled'] == 0) {
						echo '<option value="' . $key . '" ' . $selected . ' disabled="disabled">' . $value . '</option>';
					}
				} else {
					echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
				}
			}
		}
		
		echo '</select>';

	}
	
	function create_options($field) {

		$defaults = array(
			'multiple' => 0,
			'allow_null' => 0,
			'default_value' => '',
			'choices' => '',
			'disable' => '',
			'hide_disabled' => 0,
		);
		
		$field = array_merge($defaults, $field);
		$key = $field['name'];
		echo '<tr class="field_option field_option_' . $this->name . '">';
		echo '<td class="label">';
		echo '<label>' . __("Disabled Slides:", 'xe-core') . '</label>';
		echo '<p class="description">' . __("You will not be able to select these Slides", 'xe-core') . '</p>';
		echo '</td>';
		echo '<td>';
		$sliders = $this->slider_data();
		
		$choices = array_merge(array(
			0 => "---"
		) , $sliders);
		do_action('acf/create_field', array(
			'type' => 'select',
			'name' => 'fields[' . $key . '][disable]',
			'value' => $field['disable'],
			'multiple' => '1',
			'allow_null' => '0',
			'choices' => $choices,
			'layout' => 'horizontal',
		));
		echo '</td>';
		echo '</tr>';
		echo '<tr class="field_option field_option_' . $this->name . '">';
		echo '<td class="label">';
		echo '<label>' . __("Allow Null?", 'xe-core') . '</label>';
		echo '</td>';
		echo '<td>';
		
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields[' . $key . '][allow_null]',
			'value' => $field['allow_null'],
			'choices' => array(
				1 => __("Yes", 'xe-core') ,
				0 => __("No", 'xe-core') ,
			) ,
			'layout' => 'horizontal',
		));
		echo '</td>';
		echo '</tr>';
		echo '<tr class="field_option field_option_' . $this->name . '">';
		echo '<td class="label">';
		echo '<label>' . __("Select Multiple?", 'xe-core') . '</label>';
		echo '</td>';
		echo '<td>';
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields[' . $key . '][multiple]',
			'value' => $field['multiple'],
			'choices' => array(
				1 => __("Yes", 'xe-core') ,
				0 => __("No", 'xe-core') ,
			) ,
			'layout' => 'horizontal',
		));
		echo '</td>';
		echo '</tr>';
		echo '<tr class="field_option field_option_' . $this->name . '">';
		echo '<td class="label">';
		echo '<label>' . __("Hide disabled Slides?", 'xe-core') . '</label>';
		echo '</td>';
		echo '<td>';
		do_action('acf/create_field', array(
			'type' => 'radio',
			'name' => 'fields[' . $key . '][hide_disabled]',
			'value' => $field['hide_disabled'],
			'choices' => array(
				1 => __("Yes", 'xe-core') ,
				0 => __("No", 'xe-core') ,
			) ,
			'layout' => 'horizontal',
		));
		echo '</td>';
		echo '</tr>';

	}
	
	function format_value($value, $field) {
		
		if (!$value || $value == 'null') {
			return false;
		}
		if (is_array($value)) {
			foreach ($value as $k => $v) {
				$f = $this->slider_output($v);
				$value[$k] = array();
				$value[$k] = $f;
			}
		} else {
			$value = $this->slider_output($value);
		}
		
		return $value;

	}

	function render_field($field) {

		$field['multiple'] = isset($field['multiple']) ? $field['multiple'] : false;
		$field['disable'] = isset($field['disable']) ? $field['disable'] : false;
		$field['hide_disabled'] = isset($field['hide_disabled']) ? $field['hide_disabled'] : false;
		$multiple = '';
		if ($field['multiple'] == '1') {
			$multiple = ' multiple="multiple" size="5" ';
			$field['name'].= '[]';
		}
		echo '<select id="' . $field['name'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" ' . $multiple . ' >';
		if ($field['allow_null'] == '1') {
			echo '<option value="null"> - Select - </option>';
		}
		$sliders = $this->slider_data();
		if (!empty($sliders)) {
			foreach ($sliders as $key => $value) {
				$selected = '';
				if (is_array($field['value'])) {
					if (in_array($key, $field['value'])) {
						$selected = 'selected="selected"';
					}
				} else {
					if ($key == $field['value']) {
						$selected = 'selected="selected"';
					}
				}
				if (in_array(($key) , $field['disable'])) {
					if ($field['hide_disabled'] == 0) {
						echo '<option value="' . $key . '" ' . $selected . ' disabled="disabled">' . $value . '</option>';
					}
				} else {
					echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
				}
			}
		}
		
		echo '</select>';

	}
	
	function render_field_settings($field) {

		$defaults = array(
			'multiple' => 0,
			'allow_null' => 0,
			'default_value' => '',
			'choices' => '',
			'disable' => '',
			'hide_disabled' => 0,
		);
		
		$field = array_merge($defaults, $field);
		$key = $field['name'];
		
		$sliders = $this->slider_data();
		
		$choices = array_merge(array(
			0 => "---"
		) , $sliders);

		acf_render_field_setting($field, array(
			'label' => __('Disabled Slides:', 'xe-core') ,
			'type' => 'select',
			'name' => 'fields[' . $key . '][disable]',
			'value' => $field['disable'],
			'multiple' => '1',
			'allow_null' => '0',
			'choices' => $choices,
			'layout' => 'horizontal',
		));

		acf_render_field_setting($field, array(
			'label' => __('Allow Null?', 'xe-core') ,
			'type' => 'radio',
			'name' => 'fields[' . $key . '][allow_null]',
			'value' => $field['allow_null'],
			'choices' => array(
				1 => __("Yes", 'xe-core') ,
				0 => __("No", 'xe-core') ,
			) ,
			'layout' => 'horizontal',
		));

		acf_render_field_setting($field, array(
			'label' => __('Select Multiple?', 'xe-core') ,
			'type' => 'radio',
			'name' => 'fields[' . $key . '][multiple]',
			'value' => $field['multiple'],
			'choices' => array(
				1 => __("Yes", 'xe-core') ,
				0 => __("No", 'xe-core') ,
			) ,
			'layout' => 'horizontal',
		));

		acf_render_field_setting($field, array(
			'label' => __('Hide disabled Slides?', 'xe-core') ,
			'type' => 'radio',
			'name' => 'fields[' . $key . '][hide_disabled]',
			'value' => $field['hide_disabled'],
			'choices' => array(
				1 => __("Yes", 'xe-core') ,
				0 => __("No", 'xe-core') ,
			) ,
			'layout' => 'horizontal',
		));

	}

}

class WPPress_RevolutionSlider_ACF_Field extends WPPress_ACF_Field {
	
	function __construct() {

		$this->label = 'Revolution Slider';
		parent::__construct();

	}

	/**
	 * will return
	 * @method get_slider_output
	 * @author Sovit Tamrakar
	 * @param  [type] $data accepts data in array or string/integer
	 * @return string output data for slider html
	 */
	function slider_output($data = NULL) {

		ob_start();
		$rev = RevSliderOutput::putSlider($data);
		$slider = ob_get_contents();
		ob_clean();
		ob_end_clean();
		return $slider;

	}
	
	/**
	 * Will return all the Gallery Slider in array in format(id=>name)
	 * @method sliders_data
	 * @author Sovit Tamrakar
	 * @return array id=>label
	 */
	function slider_data() {

		$slider = new RevSlider();
		$sliders = $slider->getArrSlidersShort();
		$data = array();
		if (!empty($sliders)) {
			foreach ($sliders as $key => $val) {
				$data[$key] = $val;
			}
		}
		return $data;

	}

}

class WPPress_LayerSlider_ACF_Field extends WPPress_ACF_Field {

	function __construct() {

		$this->label = 'LayerSlider';
		parent::__construct();

	}

	/**
	 * will return
	 * @method get_slider_output
	 * @author Sovit Tamrakar
	 * @param  [type] $data accepts data in array or string/integer
	 * @return string output data for slider html
	 */
	function slider_output($data=NULL){

		return do_shortcode("[layerslider id=\"".$data."\"]");

	}

	/**
	 * Will return all the Gallery Slider in array in format(id=>name)
	 * @method sliders_data
	 * @author Sovit Tamrakar
	 * @return array id=>label
	 */
	function slider_data() {

		$sliders = LS_Sliders::find(array(
			'limit' => 100
		));
		$data=array();
		if($sliders){
			foreach($sliders as $slide){
				$data[$slide['id']]=$slide['name'];
			}
		}
		return $data;

	}

}

/**
 * Load slider fields.
 */
if ( class_exists('RevSlider') ) {
	new WPPress_RevolutionSlider_ACF_Field();
}
if ( class_exists('LS_Sliders') ) {
	new WPPress_LayerSlider_ACF_Field();
}