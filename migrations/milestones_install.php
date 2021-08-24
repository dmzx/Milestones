<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\migrations;

use phpbb\db\migration\migration;

class milestones_install extends migration
{
	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\dev'];
	}

	public function update_data()
	{
		return [
			['config.add', ['milestones_version', '1.0.1']],

			// Add ACP extension category
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MILESTONES_TITLE',
			]],
			// Add ACP module
			['module.add', [
				'acp',
				'ACP_MILESTONES_TITLE',
				[
					'module_basename'	=> '\dmzx\milestones\acp\acp_milestones_module',
					'modes'				=> [
						'settings',
					],
				],
			]],
			// Insert data
			['custom', [[&$this, 'add_milestones_data']]],
		];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'milestones'	=> [
					'COLUMNS' => [
						'milestones_id'			=> ['UINT', null, 'auto_increment'],
						'milestones_enable' 	=> ['UINT', '0'],
						'milestones'			=> ['VCHAR', ''],
						'milestones_text'		=> ['VCHAR', ''],
					],
					'PRIMARY_KEY'	=> 'milestones_id',
				],
			],
		];
	}

	public function add_milestones_data()
	{
		$milestones_sql_query = [
			'milestones_id'		=> '1',
			'milestones'		=> 'phpbb/phpbb',
			'milestones_text'	=> 'phpbb',
		];
		$this->db->sql_multi_insert($this->table_prefix . 'milestones', $milestones_sql_query);
	}

	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'milestones',
			],
		];
	}
}
