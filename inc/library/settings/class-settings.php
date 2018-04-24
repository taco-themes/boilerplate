<?php
/**
 * Super_Awesome_Theme_Settings class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Theme settings registry.
 *
 * @since 1.0.0
 */
final class Super_Awesome_Theme_Settings extends Super_Awesome_Theme_Theme_Component_Base {

	/**
	 * Registered theme settings.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $settings = array();

	/**
	 * Gets the value for a theme setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this setting.
	 * @return mixed Value for the setting, or null if setting is not registered.
	 */
	public function get( $id ) {
		if ( ! isset( $this->settings[ $id ] ) ) {
			return null;
		}

		return $this->settings[ $id ]->get_value();
	}

	/**
	 * Registers a theme setting.
	 *
	 * @since 1.0.0
	 *
	 * @param Super_Awesome_Theme_Setting $setting Setting to register.
	 * @return bool True on success, false on failure.
	 */
	public function register_setting( Super_Awesome_Theme_Setting $setting ) {
		$id = $setting->get( 'id' );

		if ( isset( $this->settings[ $id ] ) ) {
			return false;
		}

		$this->settings[ $id ] = $setting;

		return true;
	}

	/**
	 * Gets a registered theme setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Unique string identifier for this setting.
	 * @return Super_Awesome_Theme_Setting Registered setting instance.
	 *
	 * @throws InvalidArgumentException Thrown when $id does not identify a registered setting.
	 */
	public function get_registered_setting( $id ) {
		if ( ! isset( $this->settings[ $id ] ) ) {

			/* translators: %s: setting identifier */
			throw new InvalidArgumentException( sprintf( __( '%s is not a registered setting.', 'super-awesome-theme' ), $id ) );
		}

		return $this->settings[ $id ];
	}

	/**
	 * Gets all registered theme settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of $key => $setting pairs, where each $setting is a
	 *               registered Super_Awesome_Theme_Setting instance.
	 */
	public function get_registered_settings() {
		return $this->settings;
	}

	/**
	 * Magic call method.
	 *
	 * Handles the Customizer registration action hook callbacks.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Method arguments.
	 */
	public function __call( $method, $args ) {
		if ( 'register_in_customizer' !== $method || empty( $args ) ) {
			return;
		}

		$wp_customize = $args[0];

		foreach ( $this->settings as $setting ) {
			$id   = $setting->get( 'id' );
			$args = array(
				'capability'        => $setting->get( 'capability' ),
				'default'           => $setting->get( 'default' ),
				'transport'         => 'postMessage',
				'validate_callback' => array( $setting, 'validate_value' ),
				'sanitize_callback' => array( $setting, 'sanitize_value' ),
			);

			$wp_customize->add_setting( $id, $args );
		}
	}

	/**
	 * Adds hooks and runs other processes required to initialize the component.
	 *
	 * @since 1.0.0
	 */
	protected function run_initialization() {
		add_action( 'customize_register', array( $this, 'register_in_customizer' ), 1, 1 );
	}
}
