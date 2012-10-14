<?php

/*
=====================================================
Tyson List
-----------------------------------------------------
 http://www.anecka.com/
-----------------------------------------------------
=====================================================
Copyright (c) 2012 Patrick Pohler

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
=====================================================
 File: mcp.tyson_list.php
-----------------------------------------------------
 Dependencies: 
-----------------------------------------------------
 Purpose: 
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