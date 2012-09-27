<?php

/*
  Plugin Name: YM Status Widget
  Plugin URI: http://qtpros.info
  Description: Adds a widget to display Yahoo Messenger online statuses from users, displays default YM images + custom images.
  Author: QTPros
  Version: 0.1
  Author URI: http://qtpros.info
  License: GPL2

  Copyright 2011  QTPros  (http://QTPros.info)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

global $YM_status;
$YM_status = new YM_status();

class YM_status {
    
    private $opts;

    public function __construct() {
        
        //register_deactivation_hook(__FILE__, array(&$this, 'on_deactivate'));
        register_activation_hook(__FILE__, array(&$this, 'on_activate'));
        
        //initiation
        add_action('init', 	array(&$this, 'ym_status_init'), 1);   
		
		//register settings
		add_action('admin_init', array(&$this,'ym_register_settings')); 
        
        //add script to admin page
        //add_action('admin_enqueue_scripts', array(&$this,'ym_status_script' ));
        
        //ajax response
       //add_action('wp_ajax_ym_status',  array('YM_Status_Widget','ajax_response'));
		
		//add admin page
		add_action('admin_menu', array(&$this,'ym_status_menu'));
		
        
    }
    
     public function on_activate() {
        if (!get_option('ym_status')) {
           $opts['action'] = 'sendIM';
           $opts['image'] = 1;           
           update_option('ym_status', $opts);
        }
    }
    
    public function ym_status_init() {
        $this->opts = get_option('ym_status');
        
        //wp_register_script('ym_status', plugins_url('/ym_status.js', __FILE__), array('jquery'), '1.0', true);
        
        require dirname( __FILE__ ).'/ym_status_widget.php';
        register_widget('YM_Status_Widget');
    }
	
	public function ym_register_settings() {
		register_setting( 'ym_options', 'ym_status' );
	}
    
    public function ym_status_script($hook) {
        wp_enqueue_script('ym_status');
    }
	
	public function ym_status_menu() {
		add_options_page('Yahoo Staus Options', 'YM_status Options', 'manage_options', 'ym_status_options', array(&$this,'ym_status_options'));
	}
	
	public function ym_status_options() {
		$opts = $this->opts;
           
		require dirname( __FILE__ ).'/ym_status_settings.php';
		
	}

}

?>