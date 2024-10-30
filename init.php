<?php
/**
 * Plugin Name: Booster Blocks
 * Description: Ultimate Blocks to enhance your design experience. 
 * Author: WPVibes
 * Author URI: https://wpvibes.com
 * Version: 0.0.1
 * Text Domain: booster-blocks
 * Domain Path: /languages
 * Tested up to: 5.8
**/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BOOSTER_BLOCKS_VERSION', '0.0.1' );
define( 'BOOSTER_BLOCKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'BOOSTER_BLOCKS_URL', plugin_dir_url( __FILE__ ) );
define( 'BOOSTER_BLOCKS_FILE', __FILE__ );
define( 'BOOSTER_BLOCKS_BASE', plugin_basename( __FILE__ ) );


if(!class_exists('BoosterBlocks')){

    class BoosterBlocks{

        private static $instance; 

        public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CoBlocks ) ) {
				self::$instance = new BoosterBlocks();
				self::$instance->init();
				self::$instance->includes();
			}
			return self::$instance;
		}
        
        /**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'booster-blocks' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'booster-blocks' ), '1.0' );
		}

        private function includes(){

            require_once BOOSTER_BLOCKS_DIR.'includes/block-assets.php';
            require_once BOOSTER_BLOCKS_DIR.'includes/register-blocks.php';
        }

        private function init() {
			
		}
    }
}

function booster_blocks() {
	return BoosterBlocks::instance();
}

// Get the plugin running. Load on plugins_loaded action to avoid issue on multisite.
if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	add_action( 'plugins_loaded', 'booster_blocks', 90 );
} else {
	booster_blocks();
}