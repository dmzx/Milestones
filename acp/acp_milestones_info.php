<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\acp;

class acp_milestones_info
{
	function module()
	{
		return [
			'filename'	=> '\dmzx\milestones\acp\acp_milestones_module',
			'title'		=> 'ACP_MILESTONES_TITLE',
			'modes'		=> [
				'settings'	=> ['title' => 'ACP_MILESTONES_CONFIG', 'auth' => 'ext_dmzx/milestones && acl_a_board', 'cat'	=> ['ACP_MILESTONES_CONFIG']],
			],
		];
	}
}
