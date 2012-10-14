<?php

/*
=====================================================
TysonList
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
 File: upd.tyson_list.php
-----------------------------------------------------
 Dependencies: 
-----------------------------------------------------
 Purpose: Demo
=====================================================
*/

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

class Tyson_list_upd {

    var $version = '0.0.1';
    
    public function __construct() { 
        // Make a local reference to the ExpressionEngine super object 
        $this->EE =& get_instance(); 
    }

	public function install() {
		$this->EE->load->dbforge();
		
		$data = array(
			'module_name' => 'Tyson_list',
			'module_version' => $this->version,
			'has_cp_backend' => 'n',
			'has_publish_fields' => 'n'
		);
		
		$this->EE->db->insert('modules', $data);
		
		$this->install_actions();
		
		$this->install_tyson_list_table();
		
		return true;
	}
	
	function install_actions() {
		$actions = array(
			array(
				'class'		=> 'Tyson_list',
				'method'	=> 'getLists'
			),
			array(
				'class'		=> 'Tyson_list',
				'method'	=> 'saveLists'
			),
		);
		
		$this->EE->db->insert_batch('actions', $actions);
	}
	
	function install_tyson_list_table() {
		$fields = array(
			'list_id'			=> array('type' => 'int', 'constraint' => '10', 'unsigned' => true, 'auto_increment' => true),
			'member_id'			=> array('type' => 'int', 'constraint' => '10', 'unsigned' => true),
			'list_name'			=> array('type' => 'varchar', 'constraint' => '500'),
			'list_data' 		=> array('type' => 'text', 'null' => true, 'default' => null),
			'status'			=> array('type' => 'int', 'constraint' => '10', 'unsigned' => TRUE, 'default' => 0),
			'created_on'		=> array('type' => 'int', 'constraint' => '10', 'unsigned' => TRUE),
			'modified_on'		=> array('type' => 'int', 'constraint' => '10', 'unsigned' => TRUE)
		);
		
		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('list_id', TRUE);

		$this->EE->dbforge->create_table('tyson_lists');
	}
	
	public function uninstall() {
		$this->EE->load->dbforge();
		$this->EE->db->select('module_id');
		
		$query = $this->EE->db->get_where('modules', array('module_name' => 'Tyson_list'));
		
	    $this->EE->db->where('module_id', $query->row('module_id'));
	    $this->EE->db->delete('modules');

	    $this->EE->db->where('class', 'Tyson_list');
	    $this->EE->db->delete('actions');

	    $this->EE->dbforge->drop_table('tyson_lists');
		
		return TRUE;
	}
	
	public function update($current = '')
	{
		$this->EE->load->dbforge();
		
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}

	    return FALSE;
	}
}
?>