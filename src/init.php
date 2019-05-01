<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since 	1.0.0
 * @package CGB
 */

require_once 'epfl/epfl-news/controller.php';

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function capitainewp_bases_block_assets() {

	// Styles.
	wp_enqueue_style(
		'capitainewp-bases-style-css',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		array( 'wp-editor' )
	);
}
add_action( 'enqueue_block_assets', 'capitainewp_bases_block_assets' );


function capitainewp_bases_editor_assets() {

	// Scripts.
	wp_enqueue_script(
		'capitainewp-bases-block',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element' )
	);

	// Envoyer les traductions au JS
	// Premier paramètre : le nom du script (handle)
  // Second paramètre : le textdomain
  if ( function_exists('wp_set_script_translations') ) {
  	wp_set_script_translations( 'capitainewp-bases-block', 'capitainewp-gutenberg-blocks' );
  }	

	// Styles.
	wp_enqueue_style(
		'capitainewp-bases-block-editor',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' )
	);
}
add_action( 'enqueue_block_editor_assets', 'capitainewp_bases_editor_assets' );


function mytheme_setup_theme_supported_features() {

	// Ajouter ses propres couleurs à la palette
	add_theme_support( 'editor-color-palette',
		array(
			array( 'name' => 'blue', 'slug'  => 'blue', 'color' => '#48ADD8' ),
			array( 'name' => 'pink', 'slug'  => 'pink', 'color' => '#FF2952' ),
			array( 'name' => 'green', 'slug'  => 'green', 'color' => '#83BD71' ),
			array( 'name' => 'yellow', 'slug'  => 'yellow', 'color' => '#FFC334' ),
			array( 'name' => 'red', 'slug'  => 'red', 'color' => '#B54D4D' ),
			array( 'name' => 'grey', 'slug'  => 'grey', 'color' => '#f8f8f8' ),
			array( 'name' => 'ui', 'slug'  => 'ui', 'color' => '#232634' ),
			array( 'name' => 'ui-dark', 'slug'  => 'ui-dark', 'color' => '#2F3344' ),
			array( 'name' => 'ui-light', 'slug'  => 'ui-light', 'color' => '#575D74' ),
		)
	);

	// Désactiver le choix d'une couleur personnalisée
	//add_theme_support( 'disable-custom-colors' );

	// Format large
	add_theme_support( 'align-wide' );

	// Embeds au format responsive
	add_theme_support( 'responsive-embeds' );

	// Définir des tailles personnalisées pour le paragraphe
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => __( 'Small', 'twentynineteen' ),
				'shortName' => __( 'S', 'twentynineteen' ),
				'size'      => 19.5,
				'slug'      => 'small',
			),
			array(
				'name'      => __( 'Normal', 'twentynineteen' ),
				'shortName' => __( 'M', 'twentynineteen' ),
				'size'      => 22,
				'slug'      => 'normal',
			),
			array(
				'name'      => __( 'Large', 'twentynineteen' ),
				'shortName' => __( 'L', 'twentynineteen' ),
				'size'      => 36.5,
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Huge', 'twentynineteen' ),
				'shortName' => __( 'XL', 'twentynineteen' ),
				'size'      => 49.5,
				'slug'      => 'huge',
			),
		)
	);

	// Désactiver la possibilité de personnaliser la taille des textes
	// add_theme_support('disable-custom-font-sizes');

	// Fond sombre dans l'éditeur pour les thèmes sombres
	// add_theme_support( 'dark-editor-style' );

	// Ajouter les styles de blocs par défaut dans le thème
	// add_theme_support( 'wp-block-styles' );

}
add_action( 'after_setup_theme', 'mytheme_setup_theme_supported_features', 1000 ); // 1000 pour passer après le thème et imposer mes couleurs. A ne pas reproduire à la maison

/*
 Pour les blos dynamiques (à partir de l'exemple 14)
*/
function capitainewp_dynamic_render( $attributes ) {

	$args = array(
      'posts_per_page' => 3,
    );

	$posts = get_posts( $args );

    if ( count( $posts ) == 0 ) {
      return '<p>No posts</p>';
    }

    $markup = '<ul class="wp-block-capitainewp-dynamic">';

		foreach( $posts as $post ) {

      $markup .= sprintf(
        '<li><a href="%1$s">%2$s</a></li>',
        esc_url( get_permalink( $post->ID ) ),
        esc_html( get_the_title( $post->ID ) )
      );
    }
    $markup .= '</ul>';

    return $markup;
}


// Déclarer les blocs qui ont un rendu côté PHP
function capitainewp_register_blocks() {

	// Vérifier que Gutenberg est actif
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Pour l'exemple 14
  register_block_type( 'capitainewp/dynamic', array(
		'render_callback' => 'capitainewp_dynamic_render',
	));

	// Pour l'exemple 15
	register_block_type( 'capitainewp/dynamic-alt', array(
		'render_callback' => 'capitainewp_dynamic_render',
	));

	// Pour mon exemple de news
	register_block_type( 'greglebarbar/news', array(
		'render_callback' => 'greglebarbar_news_render',
	));
	
}
add_action( 'init', 'capitainewp_register_blocks' );
