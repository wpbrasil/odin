<?php
/**
 * Odin_Options_Helper class.
 *
 * Helper for get the value of Theme Options.
 *
 * @package  Odin
 * @category Options
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Options_Helper {

	/**
	 * Option for the tab general.
	 */
	private $option_father = '';

	/**
	 * Option child.
	 */
	private $option_child = '';

	/**
	 * Option child value.
	 */
	private $option_child_value = '';

	/**
	 * Options Helper construct.
	 *
	 * @param string  $option_father Option Father.
	 * @param string  $option_child  Option Child.
	 *
	 * @return void
	 */
	public function __construct( $option_father, $option_child ) {

		/**
		 * Set the option father property.
		 */
		$this->set_option_father( $option_father );

		/**
		 * Set the option child property.
		 */
		$this->set_option_child( $option_child );

		/**
		 * Discover the option child value.
		 */
		$this->get_option_value();
	}

	/**
	 * Getter of Option Father.
	 *
	 * @return string option_father property.
	 */
	public function get_option_father() {
		return $this->option_father;
	}

	/**
	 * Getter of Option Child.
	 *
	 * @return string option_child property.
	 */
	public function get_option_child() {
		return $this->option_child;
	}

	/**
	 * Getter of Option Child Value.
	 *
	 * @return string option_child_value property.
	 */
	public function get_option_child_value() {
		return $this->option_child_value;
	}

	/**
	 * Setter of Option Father.
	 *
	 * @param string  $option_father Option father.
	 *
	 * @return void
	 */
	public function set_option_father( $option_father ) {
		$this->option_father = $option_father;
	}

	/**
	 * Setter of Option Child.
	 *
	 * @param string  $option_child Option child.
	 *
	 * @return void
	 */
	public function set_option_child( $option_child ) {
		$this->option_child = $option_child;
	}

	/**
	 * Setter of Option Child Value.
	 *
	 * @param string  $option_child_value Option child value.
	 *
	 * @return void
	 */
	public function set_option_child_value( $option_child_value ) {
		$this->option_child_value = $option_child_value;
	}

	/**
	 * Discover the option child value.
	 *
	 * @return void
	 */
	private function get_option_value() {
		$option_father_object = get_option( $this->option_father );

		$option_value = $option_father_object[ $this->option_child ];

		$this->set_option_child_value( $option_value );
	}

	/**
	 * Automagic __toString() method to returns the Option Child value.
	 *
	 * @return string $option_child_value Option Child value.
	 */
	public function __toString() {
		return $this->option_child_value;
	}
}
