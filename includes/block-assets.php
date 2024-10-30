<?php 

namespace BoosterBlocks;

class BlockAssets{

    private static $instance; 

    public static function register(){
        if ( null === self::$instance ) {
			self::$instance = new BlockAssets();
		}

		return self::$instance;
    }

    public function __construct() {
        
		add_action( 'enqueue_block_editor_assets', array( $this, 'editor_assets' ) );
		add_action( 'enqueue_block_assets', array( $this, 'frontend_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
	}

	public function frontend_scripts(){
			wp_enqueue_script('bb-script',BOOSTER_BLOCKS_URL.'assets/script.js',[],'1.0',true);
	}
	public function frontend_assets(){
		$blocks = [
			'alert',
			// 'image-box'
		];
		foreach($blocks as $block){
			$name       = $this->dashesToCamelCase($block);
			wp_register_style(
				$block.'-style',
				BOOSTER_BLOCKS_URL.'build/style-'.$name.'.css',
				array(),
				'.1.1',
				''
			);
		}
		
	}
    public function editor_assets(){
		$blocks = [
			'alert',
			// 'image-box'
		];
		foreach($blocks as $block){
			$name       = $this->dashesToCamelCase($block);
			$filepath   = 'build/' . $name;
			$asset_file = $this->get_asset_file( $filepath );

			wp_register_script(
				$block.'-blocks-editor',
				BOOSTER_BLOCKS_URL.'build/'.$name.'.js',
				array_merge( $asset_file['dependencies'], array( 'wp-api' ) ),
				$asset_file['version'],
				true
			);
			wp_register_style(
				$block.'-editor-style',
				BOOSTER_BLOCKS_URL.'build/'.$name.'.css',
				array( 'wp-edit-blocks' ),
				'.1.1',
				''
			);
		}
        
    }

    /**
	 * Loads the asset file for the given script or style.
	 * Returns a default if the asset file is not found.
	 *
	 * @param string $filepath The name of the file without the extension.
	 *
	 * @return array The asset file contents.
	 */
	public function get_asset_file( $filepath ) {	
		$asset_path = BOOSTER_BLOCKS_DIR . $filepath . '.asset.php';

		return file_exists( $asset_path )
			? include $asset_path
			: array(
				'dependencies' => array(),
				'version'      => BOOSTER_BLOCKS_VERSION,
			);
	}

	function dashesToCamelCase($string, $capitalizeFirstCharacter = false) 
	{

		$str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

		if (!$capitalizeFirstCharacter) {
			$str[0] = strtolower($str[0]);
		}

		return $str;
	}
}

BlockAssets::register();