<?php
/** @var $field \GDO\OnlineUsers\GDT_OnlineUsers **/
/** @var $users \GDO\User\GDO_User[] **/

use GDO\OnlineUsers\Module_OnlineUsers;
use GDO\Profile\GDT_ProfileLink;

$max = Module_OnlineUsers::instance()->cfgNumOnline();

$data = $field->getOnlineUsers();
$guests = $data['guests'];
$users = $data['users'];
$output = [];

if ($guests > 0)
{
	$output[] = t('num_online_guests', [$guests]);
}

$more = false;
foreach ($users as $user)
{
	if (module_enabled('Profile'))
	{
		$output[] = GDT_ProfileLink::make()->forUser($user)->withAvatar(false)->withNickname()->renderCell();
	}
	else
	{
		$output[] = $user->displayNameLabel();
	}
	
	if (count($output) >= $max)
	{
		$more = true;
		break;
	}
}

$total = $guests + count($users);
$onlineUsers = implode(', ', array_slice($output, 0, $max));

if ($more)
{
	echo "<div class=\"gdo-online-users\">" . t('num_online_more', [$total, $onlineUsers]) . "</div>\n" . "</div>";
}
else 
{
	echo "<div class=\"gdo-online-users\">" . t('num_online', [$total, $onlineUsers]) . "</div>\n";
}
