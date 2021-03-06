<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Cherry_Data_Importer_Cache' ) ) {

	/**
	 * Define Cherry_Data_Importer_Cache class
	 */
	class Cherry_Data_Importer_Cache {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Import data caching metod.
		 *
		 * @var string
		 */
		private $caching_method = 'session';

		/**
		 * Active cache handler instance
		 *
		 * @var null
		 */
		private $handler = null;

		/**
		 * Registered cache handlers array
		 *
		 * @var array
		 */
		private $handlers = array();

		/**
		 * Base caching group name
		 *
		 * @var string
		 */
		public $base_group = 'cherry-importer';

		/**
		 * Constructor for the class
		 */
		public function __construct() {

			$this->handlers = array(
				'session' => 'Cherry_Data_Importer_Session_Cache',
				'file'    => 'Cherry_Data_Importer_File_Cache',
			);

			require_once cdi()->path( 'includes/cache-handlers/class-cherry-data-importer-cache-handler.php' );

			$method = $this->get_caching_method();

			if ( isset( $this->handlers[ $method ] ) ) {
				$handler = $this->handlers[ $method ];
			} else {
				$handler = 'Cherry_Data_Importer_Session_Cache';
			}

			$file = $this->get_file_name( $handler );

			require_once cdi()->path( 'includes/cache-handlers/' . $file );

			$this->handler = new $handler( $this->base_group );
		}

		/**
		 * Returns handler file name by class name.
		 *
		 * @param  string $handler Handler class name.
		 * @return string
		 */
		private function get_file_name( $handler ) {

			$file = str_replace( '_', ' ', $handler );
			$file = strtolower( $file );
			$file = str_replace( ' ', '-', $file );

			return sprintf( 'class-%s.php', $file );

		}

		/**
		 * Returns appropriate caching method for current server/
		 *
		 * @return string
		 */
		private function get_caching_method() {

			if ( ! session_id() ) {
				$this->caching_method = 'file';
			}

			return $this->caching_method;
		}

		/**
		 * Store passed value in cache with passed key.
		 *
		 * @param  string $key   Caching key.
		 * @param  mixed  $value Value to save.
		 * @param  string $group Caching group.
		 * @return bool
		 */
		public function update( $key = null, $value = null, $group = 'global' ) {
			$this->handler->update( $key, $value, $group );
		}

		/**
		 * Get value from cache by key.
		 *
		 * @param  string $key   Caching key.
		 * @param  string $group Caching group.
		 * @return bool
		 */
		public function get( $key = null, $group = 'global' ) {
			return $this->handler->get( $key, $group );
		}

		/**
		 * Get all group values from cache by group name.
		 *
		 * @param  string $group Caching group.
		 * @return bool
		 */
		public function get_group( $group = 'global' ) {
			return $this->handler->get_group( $group );
		}

		/**
		 * Clear cache for passed group or all cache if group not provided.
		 *
		 * @param  string $group Caching group to clear.
		 * @return bool
		 */
		public function clear_cache( $group = null ) {
			return $this->handler->clear_cache( $group );
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Cherry_Data_Importer_Cache
 *
 * @return object
 */
function cdi_cache() {
	return Cherry_Data_Importer_Cache::get_instance();
}
