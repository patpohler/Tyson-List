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
 File: mod.talon_snp.php
-----------------------------------------------------
 Dependencies: 
-----------------------------------------------------
 Purpose: Custom module for the Net Seller Proceed's Calculator on 
TalonTitle.net
=====================================================
*/

if (! defined('BASEPATH')) exit('No direct script access allowed');

class Tyson_list {
	var $site_id = 1;
	
	function __construct() {

		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		
		$this->EE =& get_instance();
		
		$this->site_id = $this->EE->config->item('site_id');
		
		if(! class_exists('EE_Template'))
		{
			$this->EE->TMPL =& load_class('Template', 'libraries', 'EE_');
		}
	}
	
	public function getLists() {
		$query = $this->_get_lists_query();
		
		$result = "";
		
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row) {
				$result = $row->list_data;
				break;
			}
		}
		header('Content-type: text/plain');
		echo $result;
	}

	public function saveLists() {
		$list_data = $this->EE->input->post('list_data');
		
		$list_obj = json_decode($list_data);

		$member_id = $member_id = $this->EE->session->userdata('member_id');
		$modified_on = $this->EE->localize->now;
		
		$this->EE->db->select('list_id, member_id, list_data, created_on, modified_on');
		$this->EE->db->where('member_id', $member_id);
		$query = $this->EE->db->get('exp_tyson_lists');
		
		$result = array();
		
		if ($query->num_rows() > 0)
		{
			//update
			$data = array(
				'modified_on'	=> $modified_on,
				'list_data'		=> $list_data,
			);
			
			$this->EE->db->where('member_id', $member_id);
			$this->EE->db->update('exp_tyson_lists', $data);
		} else {
			$data = array(
				'modified_on'	=> $modified_on,
				'created_on'	=> $this->EE->localize->now,
				'member_id'		=> $member_id,
				'list_data'		=> $list_data,
			);
			
			$this->EE->db->insert('exp_tyson_lists', $data);
		}
		
		header('Content-type: text/plain');
		echo json_encode($list_obj);
	}
	
	public function scripts() {
		$is_debug = $this->EE->TMPL->fetch_param('debug', false);
		$is_head = $this->EE->TMPL->fetch_param('head', false);

		$scripts = array();
		$css = array();
		
		if($is_head) {
			if($is_debug) {
				$scripts = array(
					$this->_build_script_tag(URL_THIRD_THEMES."tyson_list/js/knockout-2.1.0.debug.js"),
					$this->_build_script_tag(URL_THIRD_THEMES."tyson_list/js/knockout.mapping-latest.debug.js"),
				);
			} else {
				$scripts = array(
					$this->_build_script_tag(URL_THIRD_THEMES."tyson_list/js/knockout-2.1.0.js"),
					$this->_build_script_tag(URL_THIRD_THEMES."tyson_list/js/knockout.mapping-latest.js"),
				);
			}
			
			$css = array(
				$this->_build_style_tag(URL_THIRD_THEMES."tyson_list/css/bootstrap.min.css"),
			);
		} else {
			$scripts = array(
				$this->_build_api_constants(),
				$this->_build_script_tag(URL_THIRD_THEMES."tyson_list/js/tysonlist-app.js"),
				$this->_build_script_tag(URL_THIRD_THEMES."tyson_list/js/bootstrap.min.js"),
			);
		}
		
		$out = "";
		foreach($scripts as $script) {
			$out .= $script."\n";
		}
		
		foreach($css as $href) {
			$out .= $href."\n";
		}
		
		return $out;
	}
	
	function _build_api_constants() {
		$get_lists_id = $this->EE->functions->fetch_action_id('Tyson_list', 'getLists');
		$save_lists_id = $this->EE->functions->fetch_action_id('Tyson_list', 'saveLists');
		
		$out = "<script type='text/javascript'>\n";
		$out .= "function TysonApi() { \n

		} \n

		TysonApi.GET_LISTS = $get_lists_id;				\n
		TysonApi.SAVE_LISTS = $save_lists_id;				\n
		
		";
		
		$site_url = $this->EE->functions->create_url("");

			
		$out .= "var BASE_URL = '".$site_url."';\n";
		$out .= "var ACT_URL = '".$site_url."?ACT=';\n";
		
		$out .= "</script>\n";
		return $out;
	}
	
	function _build_script_tag($path) {
		return "<script type='text/javascript' src='$path'></script>";
	}
	
	function _build_style_tag($path) {
		return "<link href='$path' media='screen' rel='stylesheet' type='text/css' />";
	}
	
	public function _get_lists_query($status = '') {
		$member_id = $this->EE->session->userdata('member_id');
		
		$this->EE->db->select('list_data');
		$this->EE->db->where('member_id', $member_id);
		
		if($status != '')
			$this->EE->db->where('status', $status);
			
		$query = $this->EE->db->get('exp_tyson_lists');
		return $query;
	}
}
?>