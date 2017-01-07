<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var phpbb\language\language */
	protected $language;

	/** @var string */
	protected $milestones_table;

	/**
	* Constructor
	*
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	* @param \phpbb\db\driver\driver_interface 		$db
	* @param \phpbb\request\request					$request
	* @param phpbb\language\language				$language
	* @param string									$milestones_table
	*/
	public function __construct(
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		\phpbb\language\language $language,
		$milestones_table)
	{
		$this->template 		= $template;
		$this->user 			= $user;
		$this->db 				= $db;
		$this->request 			= $request;
		$this->language			= $language;
		$this->milestones_table = $milestones_table;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.page_header' => 'page_header',
		);
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
			$this->template->assign_vars(array(
				'MILESTONES_ENABLE'	=> $row['milestones_enable'],
			));

			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!empty($row['milestones']))
				{
					$this->template->assign_block_vars('milestones', array(
						'MILESTONES'		=> $row['milestones'],
						'MILESTONES_TEXT'	=> $row['milestones_text'],
					));
				};
			}
		}
		$this->db->sql_freeresult($result);
	}
}
