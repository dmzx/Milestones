<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\migrations;

class milestones_install extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('milestones_version', '1.0.1')),

			// Add ACP extension category
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MILESTONES_TITLE',
			)),
			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_MILESTONES_TITLE',
				array(
					'module_basename'	=> '\dmzx\milestones\acp\acp_milestones_module',
					'modes'				=> array(
						'settings',
					),
				),
			)),
			// Insert data
			array('custom', array(array(&$this, 'add_milestones_data'))),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'milestones'	=> array(
					'COLUMNS' => array(
						'milestones_id'			=> array('UINT', null, 'auto_increment'),
						'milestones_enable' 	=> array('UINT', '0'),
						'milestones'			=> array('VCHAR', ''),
						'milestones_text'		=> array('VCHAR', ''),
					),
					'PRIMARY_KEY'	=> 'milestones_id',
				),
			),
		);
	}

	public function add_milestones_data()
	{
		$milestones_sql_query = array(
			'milestones_id'		=> '1',
			'milestones'		=> 'phpbb/phpbb',
			'milestones_text'	=> 'phpbb',
		);
		$this->db->sql_multi_insert($this->table_prefix . 'milestones', $milestones_sql_query);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'milestones',
			),
		);
	}
}
