<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\migrations;

class milestones_v102 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\milestones\migrations\milestones_install',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('milestones_version', '1.0.2')),
		);
	}
}
