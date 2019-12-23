<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2019 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\migrations;

class milestones_v103 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\milestones\migrations\milestones_v102',
		];
	}

	public function update_data()
	{
		return [
			['config.update', ['milestones_version', '1.0.3']],
		];
	}
}
