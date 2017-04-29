<?php
/* Plugin Name: Codistan
Plugin URI:
Description: User Contributions Management System
Version: 1.1
Author: Ali Azlan
Author URI: http://www.codistan.pk
License: GPLv2 or later
*/
	defined('ABSPATH') or die("No script kiddies please!");

    function register_my_session(){
	  if( !session_id() )
	  	session_start();
	}
	add_action('init', 'register_my_session');

    wp_enqueue_script( 'jquery' );
	wp_localize_script( 'codistan1', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
	wp_register_script( 'codistan1', plugins_url( '/js/jquery-ui.js' , __FILE__ ), array('jquery') );
	wp_enqueue_style( 'jquery-ui', plugins_url( '/style/jquery-ui.css' , __FILE__ ) );
	wp_enqueue_script('codistan', plugins_url( '/js/script.js' , __FILE__ ) , array( 'jquery' ));
	wp_localize_script( 'codistan', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));
	wp_register_script( 'codistan', plugins_url( '/js/script.js' , __FILE__ ), array('jquery') );
	wp_enqueue_script('codistan1', plugins_url( '/js/jquery-ui.js' , __FILE__ ) , array( 'jquery' ));
	wp_enqueue_style( 'codistan_style', plugins_url( '/style/style.css' , __FILE__ ) );

    function codistan_activation() {
		codistan_install();
	}
	register_activation_hook(__FILE__, 'codistan_activation');

	function codistan_deactivation() {
	}
	register_deactivation_hook(__FILE__, 'codistan_deactivation');

	function codistan_install () {
		global $wpdb;

		if ( ! empty( $wpdb->charset ) )
			$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		if ( ! empty( $wpdb->collate ) )
			$charset_collate .= " COLLATE {$wpdb->collate}";

		$sql1 = "CREATE TABLE codistan_songs (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
            name TEXT NOT NULL DEFAULT '',
			song_type mediumint(9),
			movie mediumint(9),
			lyricist TEXT DEFAULT '',
			producer TEXT DEFAULT '',
			director TEXT DEFAULT '',
			singers TEXT DEFAULT '',
			language TEXT DEFAULT '',
			genre TEXT DEFAULT '',
            actors TEXT DEFAULT '',
            media_url TEXT DEFAULT '',
            featured BOOLEAN DEFAULT false,
			year TEXT DEFAULT '',
            status BOOLEAN DEFAULT false,
			time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id),
			UNIQUE INDEX `id_UNIQUE` (`id` ASC)
		) $charset_collate;";

		$sql2 = "CREATE TABLE codistan_movies (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name TEXT NOT NULL DEFAULT '',
			image TEXT DEFAULT '',
			director TEXT DEFAULT '',
            producer TEXT DEFAULT '',
			description TEXT DEFAULT '',
            singers TEXT DEFAULT '',
            actors TEXT DEFAULT '',
            year TEXT DEFAULT '',
			time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id),
			UNIQUE INDEX `id_UNIQUE` (`id` ASC)
		) $charset_collate;";

        $sql3 = "CREATE TABLE codistan_images (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name TEXT NOT NULL DEFAULT '',
			relatedTo mediumint(9),
            relatedTo_id mediumint(9),
            media_url TEXT DEFAULT '',
            year TEXT DEFAULT '',
			status BOOLEAN DEFAULT false,
			time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id),
			UNIQUE INDEX `id_UNIQUE` (`id` ASC)
		) $charset_collate;";

        $sql4 = "CREATE TABLE codistan_content_types (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name TEXT NOT NULL DEFAULT '',
			time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id),
			UNIQUE INDEX `id_UNIQUE` (`id` ASC)
		) $charset_collate;";

        $sql5 = "CREATE TABLE codistan_song_types (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name TEXT NOT NULL DEFAULT '',
			time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id),
			UNIQUE INDEX `id_UNIQUE` (`id` ASC)
		) $charset_collate;";

        $sql6 = "CREATE TABLE codistan_song_genres (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name TEXT NOT NULL DEFAULT '',
			time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id),
			UNIQUE INDEX `id_UNIQUE` (`id` ASC)
		) $charset_collate;";

        $sql7 = "CREATE TABLE codistan_song_languages (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name TEXT NOT NULL DEFAULT '',
			time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id),
			UNIQUE INDEX `id_UNIQUE` (`id` ASC)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql1 );
		dbDelta( $sql2 );
        dbDelta( $sql3 );
        dbDelta( $sql4 );
        dbDelta( $sql5 );
        dbDelta( $sql6 );
        dbDelta( $sql7 );
	}

    add_action( 'admin_menu', 'codistan_menu' );

	function codistan_menu() {
			add_menu_page( 'Contributions', 'Contributions', 'manage_options', 'codistan_menu');
			add_submenu_page( 'codistan_menu', 'New Contributions', 'New', 'manage_options', 'codistan_menu', 'codistan_new_contributions' );
			add_submenu_page( 'codistan_menu', 'Approved Contributions', 'Approved', 'manage_options', 'codistan_approved_contributions', 'codistan_approved_contributions' );
	}

    include 'helper_methods.php';
    include 'admin_pages.php';
    include 'shortcode_contributions_form.php';
    include 'shortcode_featured_songs.php';
    include 'shortcode_songs_catalogue.php';
?>
