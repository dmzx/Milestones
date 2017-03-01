<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\controller;

class admin_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\log\log_interface */
	protected $log;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string */
	protected $milestones_table;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config					$config
	 * @param \phpbb\template\template				$template
	 * @param \phpbb\log\log_interface				$log
	 * @param \phpbb\user							$user
	 * @param \phpbb\db\driver\driver_interface		$db
	 * @param \phpbb\request\request				$request
	 * @param \phpbb\language\language				$language
	 * @param string								$milestones_table
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\log\log_interface $log,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		\phpbb\language\language $language,
		$milestones_table
	)
	{
		$this->config 			= $config;
		$this->template 		= $template;
		$this->log 				= $log;
		$this->user 			= $user;
		$this->db 				= $db;
		$this->request 			= $request;
		$this->language			= $language;
		$this->milestones_table = $milestones_table;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		$this->language->add_lang('milestones_acp', 'dmzx/milestones');

		add_form_key('acp_milestones');

		$sql = 'SELECT *
			FROM '. $this->milestones_table;
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if (!empty($row['milestones']))
			{
				$this->template->assign_block_vars('milestones', array(
					'MILESTONES'		=> $row['milestones'],
					'MILESTONES_TEXT'	=> $row['milestones_text'],
				));
			};
		};
		$this->db->sql_freeresult($result);

		if (empty($row['milestones']))
		{
			$this->template->assign_block_vars('milestones', array(
				'MILESTONES' => '',
			));
		};

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('acp_milestones'))
			{
				trigger_error('FORM_INVALID');
			}

			$this->db->sql_query('DELETE FROM ' . $this->milestones_table);

			if (!$row['milestones_id'])
			{
				$sql_arr_id = array(
					'milestones_id' => '1',
				);
				$sql = 'INSERT INTO ' . $this->milestones_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr_id);
				$this->db->sql_query($sql);
			};

			$milestones 		= $this->request->variable('milestones', array('' => ''),true);
			$milestones_text 	= $this->request->variable('milestones_text', array('' => ''),true);
			$milestones			= array_filter($milestones);

			$i = 0;
			while ($i < count($milestones))
			{
				$sql_ary1 = array(
					'milestones' 		=> $milestones[$i],
					'milestones_text' 	=> $milestones_text[$i],
				);
				$this->db->sql_multi_insert($this->milestones_table, $sql_ary1);
				$i++;
			}

			$sql_ary_block = array(
				'milestones_enable' => $this->request->variable('milestones_enable', ''),
			);

			$this->db->sql_query('UPDATE ' . $this->milestones_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary_block) . "
				WHERE milestones_id = 1"
			);

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_MILESTONES_SAVE');

			trigger_error($this->user->lang('MILESTONES_SAVED') . adm_back_link($this->u_action));
		}

		$sql = 'SELECT milestones_enable
			FROM ' . $this->milestones_table . "
			WHERE milestones_id = 1";
		$result = $this->db->sql_query($sql);
		$milestones_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'MILESTONES_ENABLE'		=> $milestones_data['milestones_enable'],
			'MILESTONES_VERSION'	=> $this->config['milestones_version'],
		));
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
