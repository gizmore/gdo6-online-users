<?php /** @var $field \GDO\OnlineUsers\GDT_OnlineUsers **/
use GDO\UI\GDT_Tooltip;
use GDO\UI\GDT_Link;
use GDO\OnlineUsers\Module_OnlineUsers;
$users = $field->getOnlineUsers();
$ausers = [];
$max = Module_OnlineUsers::instance()->cfgNumOnline();
foreach ($users as $data)
{
	/** @var $user \GDO\User\GDO_User **/
	list ($t, $user) = $data;
	$uid = $user->getID();
	
	$ausers[$uid] = GDT_Link::anchor(href('Profile', 'View', "&user=$uid"), $user->displayNameLabel());
}
$online = count($ausers);
$onlineUsers = implode(', ', array_slice($ausers, 0, $max));

if ($online > $max)
{
	echo "<div class=\"gdo-online-users\">" . t('num_online_more', [$online, $onlineUsers, ($max-$online)]) . "</div>\n" . "</div>";
}
else 
{
	echo "<div class=\"gdo-online-users\">" . t('num_online', [$online, $onlineUsers]) . "</div>\n";
}
