<?php 
	/** Define THEME_URL for Odin */
	if( !define('THEME_URI') )
		define('THEME_URI', get_template_directory_uri() );

	/** Define THEME_DIR for Odin */
	if( !define('THEME_DIR') )
		define('THEME_DIR', get_template_directory() );

	define('ASSETS_PREFIX', DS . 'assets');
  define('ASSETS_URI', THEME_URI . ASSETS_PREFIX);
  define('ASSETS_DIR', THEME_DIR . ASSETS_PREFIX);

  $_js_path = DS . 'js';
  define('JS_URI', ASSETS_URI . $_js_path);
  define('JS_DIR', ASSETS_DIR . $_js_path);

  $_css_path = DS . 'css';
  define('CSS_URI', ASSETS_URI . $_css_path);
  define('CSS_DIR', ASSETS_DIR . $_css_path);

  $_fonts_path = DS . 'fonts';
  define('FONTS_URI', ASSETS_URI . $_fonts_path);
  define('FONTS_DIR', ASSETS_DIR . $_fonts_path);

  $_img_path = DS . 'images';
  define('IMAGES_URI', ASSETS_URI . $_img_path );
  define('IMAGES_DIR', ASSETS_DIR . $_img_path );

  $_sass_path = DS . 'sass';
  define('SASS_URI', ASSETS_URI . $_sass_path);
  define('SASS_DIR', ASSETS_DIR . $_sass_path );