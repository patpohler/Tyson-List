<?php

/*
=====================================================
Talon Net Seller's Calculator
-----------------------------------------------------
 http://www.anecka.com/
-----------------------------------------------------
 Copyright (c) 2012 Patrick Pohler
=====================================================
 This software is based upon and derived from
 ExpressionEngine software protected under
 copyright dated 2004 - 2012. Please see
 http://expressionengine.com/docs/license.html
=====================================================
 File: mcp.talon_snp.php
-----------------------------------------------------
 Dependencies: 
-----------------------------------------------------
 Purpose: Custom module for the Net Seller Proceed's Calculator on 
TalonTitle.net
=====================================================
*/

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

class Tyson_list_mcp {
	
	var $site_id = 1;
	var $base_url;
	var $perpage = 25;
	
	function __construct() { 
		// Make a local reference to the ExpressionEngine super object 
		$this->EE =& get_instance(); 
		$this->site_id = $this->EE->config->item('site_id');
		$this->base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=tyson_list';
	}
}
?>