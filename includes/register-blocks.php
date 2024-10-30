<?php

namespace BoosterBlocks;

class RegisterBlocks{

    private static $instance; 

    public static function register(){

        if ( null === self::$instance ) {
			self::$instance = new RegisterBlocks();
		}

		return self::$instance;
    }

    
    public function __construct()
    {
        add_action( 'block_categories_all', [$this, 'register_category'], 10, 2 );
        add_action('init', [ $this, 'register_blocks'], 99);
    }

    public function register_category($categories){
        
        $categories =  array_merge(
            $categories,
            [
                [
                    'slug'  => 'booster-blocks',
                    'title' => __( 'Booster Blocks', 'bb' ),
                ],
            ]
        );
        
        return $categories;
    }

    public function register_blocks(){

        // Return early if this function does not exist.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

        register_block_type(
            'booster-blocks/alert',
            [
                'editor_script' => 'alert-blocks-editor',
                'style'         => 'alert-style',
                'editor_style'  => 'alert-editor-style',
            ]
        );

        // register_block_type(
        //     'booster-blocks/image-box',
        //     [
        //         'editor_script' => 'image-box-blocks-editor',
        //         'style'         => 'image-box-style',
        //         'editor_style'  => 'image-box-editor-style',
        //     ]
        // );
    }
}

RegisterBlocks::register();