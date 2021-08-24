<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\event;

use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var template */
	protected $template;

	/** @var driver_interface */
	protected $db;

	/** @var language */
	protected $language;

	/** @var string */
	protected $milestones_table;

	/**
	* Constructor
	*
	* @param template				$template
	* @param driver_interface 		$db
	* @param language				$language
	* @param string					$milestones_table
	*/
	public function __construct(
		template $template,
		driver_interface $db,
		language $language,
		$milestones_table
	)
	{
		$this->template 		= $template;
		$this->db 				= $db;
		$this->language			= $language;
		$this->milestones_table = $milestones_table;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.page_header' => 'page_header',
		];
	}

	public function page_header($event)
	{
		$this->language->add_lang('common', 'dmzx/milestones');

		$sql = 'SELECT *
			FROM ' . $this->milestones_table;
		$result	 = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		if ($row['milestones_enable'])
		{
			$this->template->assign_vars([
				'MILESTONES_ENABLE'	=> $row['milestones_enable'],
			]);

			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!empty($row['milestones']))
				{
					$this->template->assign_block_vars('milestones', [
						'MILESTONES'		=> $row['milestones'],
						'MILESTONES_TEXT'	=> $row['milestones_text'],
					]);
				}
			}
		}
		$this->db->sql_freeresult($result);
	}
}
