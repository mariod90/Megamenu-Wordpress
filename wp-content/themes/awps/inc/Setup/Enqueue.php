<?php

namespace Awps\Setup;

/**
 * Enqueue.
 */
class Enqueue
{
	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function register()
	{
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
	}

	/**
	 * Notice the mix() function in wp_enqueue_...
	 * It provides the path to a versioned asset by Laravel Mix using querystring-based 
	 * cache-busting (This means, the file name won't change, but the md5. Look here for 
	 * more information: https://github.com/JeffreyWay/laravel-mix/issues/920 )
	 */
	public function enqueue_scripts()
	{
		// Deregister the built-in version of jQuery from WordPress
		if (!is_customize_preview()) {
			wp_deregister_script('jquery');
		}

		// CSS
		wp_enqueue_style('main', mix('css/style.css'), array(), '1.0.0', 'all');

		// JS		
		wp_enqueue_script('jqueryawps', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array(), '3.3.1', true);
		wp_enqueue_script('main', mix('js/app.js'), array('jqueryawps'), '1.0.0', true);

		//Bootstrap
		wp_enqueue_style('bootstrapcss', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1', 'all');
		wp_enqueue_script('popperjs', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jqueryawps'), '1.14.7', true);
		wp_enqueue_script('bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jqueryawps'), '4.3.1', true);
		


		// Activate browser-sync on development environment
		if (getenv('APP_ENV') === 'development') :
			wp_enqueue_script('__bs_script__', getenv('WP_SITEURL') . ':3000/browser-sync/browser-sync-client.js', array(), null, true);
		endif;

		// Extra
		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
