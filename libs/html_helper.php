<?php

/**
 * A helper class to output html
 *
 * @package rockharbor
 */
class HtmlHelper {

/**
 * The theme object
 *
 * @var RockharborThemeBase
 */
	protected $theme = null;

/**
 * The prefix to put before input names
 *
 * @var string
 */
	public $inputPrefix = '';

/**
 * Array of default data for inputs
 *
 * @var array
 */
	protected $data = array();

/**
 * Sets the theme object for use in this class
 *
 * @param RockharborThemeBase $theme
 */
	public function __construct($theme = null) {
		$this->theme = $theme;
	}

/**
 * Returns a captcha
 *
 * @return string
 */
	public function captcha() {
		return do_action('comment_form');
	}

/**
 * Validates a captcha
 *
 * @return boolean
 */
	public function validateCaptcha() {
		$comment = array(
			'comment_type' => 'comment'
		);
		do_action('preprocess_comment', $comment);
		return true;
	}

/**
 * Creates an image tag
 *
 * ### Attr
 * - boolean $parent If true, will pull from parent theme, otherwise child theme
 * - ...rest Attributes for the img tag
 *
 * @param string $url The name of the image
 * @param array $attr Attributes and options
 * @return string Image code
 */
	public function image($url, $attr = array()) {
		$_options = array(
            'url'    => false,
			'parent' => false
		);
		$attr += $_options;
		$options = array_intersect_key($attr, $_options);
		$attr = array_diff_key($attr, $options);
		if (empty($url)) {
			return null;
		}
		$path = $options['parent'] ? $this->theme->info('base_url') : $this->theme->info('url');
        if ( $options['url'] ) return $path.'/img/'.$url;
		return '<img src="'.$path.'/img/'.$url.'"'.$this->parseAttributes($attr).'/>';
	}

/**
 * Creates a basic HTML tag.
 *
 * If `$content` is an array, the tag is treated as a self-closing tag and
 * `$content` is treated as the attributes.
 *
 * @param string $tag Tag name
 * @param string $content Content to fill the tag
 * @param array $attr Array of attributes
 * @return string Html code
 */
	public function tag($tag, $content, $attr = array()) {
		$out = "<$tag";
		if (is_array($content)) {
			$attr = $content;
		}
		$out .= $this->parseAttributes($attr);
		if ($content === $attr) {
			$out .= ' />';
		} else {
			$out .= ">$content</$tag>";
		}
		return $out;
	}

/**
 * Creates an input field
 *
 * If `$label` is false, no label will be created. If no `$value` is defined,
 * it will look for one in `$this->data` and use it instead.
 *
 * If `$div` is false, it won't be wrapped in a div. It's a string, the string
 * value will be used as a class.
 *
 * @param string $name Name of input
 * @param array $options List of options
 */
	public function input($name, $options = array()) {
		$_default = array(
			'type' => 'input',
			'value' => null,
			'name' => $name,
			'label' => $name,
			'options' => array(),
			'before' => '',
			'after' => '',
			'between' => '',
			'div' => true,
			'required' => false
		);
		$options = array_merge($_default, $options);
		if ($options['type'] == 'checkbox' && $options['value'] === null) {
			$options['value'] = 1;
		}
		if ((is_null($options['value']) || $options['type'] == 'checkbox' || $options['type'] == 'radio') && isset($this->data)) {
			$data = $this->data;
			if (isset($data[$this->inputPrefix])) {
				$data = $this->data[$this->inputPrefix];
			}
			if (strpos($options['name'], 'tax_input') !== false) {
				if (preg_match('/tax_input\[(.+)\]/i', $options['name'], $matches)) {
					if (!empty($data['tax_input'])) {
						$data[$options['name']] = $data['tax_input'][$matches[1]];
					}
				}
			}
			if (isset($data[$options['name']])) {
				if ($options['type'] == 'checkbox' || $options['type'] == 'radio') {
					if ($options['value'] == $data[$options['name']]) {
						$options['checked'] = 'checked';
					}
				} else {
					$options['value'] = $data[$options['name']];
				}
			}
		}
		if ($options['value'] === null) {
			unset($options['value']);
		}
		if (!empty($this->inputPrefix) && stripos($options['name'], $this->inputPrefix) === false) {
			$options['name'] = $this->inputPrefix.'['.$options['name'].']';
		}
		if (empty($options['id'])) {
			$options['id'] = preg_replace('/[^a-z0-9]+/i', '', $options['name']);
		}

		if ($options['type'] == 'hidden') {
			$options['label'] = false;
			$options['div'] = false;
		}

		$before = $options['before'];
		unset($options['before']);
		$after = $options['after'];
		unset($options['after']);
		$between = $options['between'];
		unset($options['between']);

		$out = '';
		if (!empty($before)) {
			$out .= $before;
		}
		if ($options['label'] !== false && (empty($options['options']) || $options['type'] == 'select')) {
			$out .= $this->tag('label', $options['label'], array(
				'for' => $options['id'],
				'class' => 'description'
			));
		}
		if (!empty($between)) {
			$out .= $between;
		}
		unset($options['label']);
		$selectOptions = $options['options'];
		unset($options['options']);
		$type = $options['type'];
		unset($options['type']);
		$div = $options['div'];
		unset($options['div']);
		switch ($type) {
			case 'select':
				$selected = isset($options['value']) ? $options['value'] : '';
				unset($options['value']);
				$select = '';
				foreach ($selectOptions as $selectValue => $selectLabel) {
					$_attrs = array('value' => $selectValue);
					if ($selectValue == $selected) {
						$_attrs['selected'] = 'selected';
					}
					$select .= $this->tag('option', $selectLabel, $_attrs);
				}
				$out .= $this->tag('select', $select, $options);
			break;
			case 'radio':
				$options['type'] = $type;
				$out = $this->tag('input', $options) . '&nbsp;' . $out;
			break;
			case 'checkbox':
				$options['type'] = $type;
				$hidden = $this->tag('input', array_merge($options, array('value' => 0, 'type' => 'hidden', 'id' => $options['id'].'hidden')));
				$out = $hidden . $this->tag('input', $options) . '&nbsp;' . $out;
			break;
			case 'textarea':
				$val = isset($options['value']) ? $options['value'] : '';
				unset($options['value']);
				$out .= $this->tag('textarea', $val, $options);
			break;
			case 'submit':
				$options['value'] = $options['name'];
			default:
				if ($type == 'input') {
					$type = 'text';
				}
				$options['type'] = $type;
				$out .= $this->tag('input', $options);
			break;
		}
		if (!empty($after)) {
			$out .= $after;
		}
		unset($options['after']);

		if ($div === false) {
			return $out;
		}
		$attrs = array();
		if (is_string($div)) {
			$attrs['class'] = $div;
		}
		return $this->tag('div', $out, $attrs);
	}

/**
 * Data for input fields
 *
 * @param array $data Data to set
 * @return array
 */
	public function data($data = array()) {
		$this->data = $data;
		return $this->data;
	}

/**
 * Quick function to parse attributes
 *
 * @param array $attr Attributes
 * @return string
 */
	public function parseAttributes($attr = array()) {
		$out = array();
		foreach ($attr as $name => $value) {
			if (is_bool($value)) {
				if ($value === true) {
					$out[] = "$name";
				}
				continue;
			}
			$name = esc_attr($name);
			$value = esc_attr($value);
			$out[] = "$name=\"$value\"";
		}
		if (!empty($out)) {
			// prepend an extra space in the beginning
			array_unshift($out, null);
		}
		return implode(' ', $out);
	}

}