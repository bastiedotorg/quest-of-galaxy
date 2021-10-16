<ul id="menu" class="ms-2">
    <li class="nav-item"><span>{$LNG.mu_general}</span></li>
    {if allowedTo('ShowInformationPage')}<li class="nav-item"><a href="?page=infos">{$LNG.mu_game_info}</a></li>{/if}
    {if allowedTo('ShowConfigBasicPage')}<li class="nav-item"><a href="?page=config">{$LNG.mu_settings}</a></li>{/if}
    {if allowedTo('ShowConfigUniPage')}<li class="nav-item"><a href="?page=configuni">{$LNG.mu_unisettings}</a></li>{/if}
    {if allowedTo('ShowChatConfigPage')}<li class="nav-item"><a href="?page=chat">{$LNG.mu_chat}</a></li>{/if}
    {if allowedTo('ShowTeamspeakPage')}<li class="nav-item"><a href="?page=teamspeak">{$LNG.mu_ts_options}</a></li>{/if}
    {if allowedTo('ShowFacebookPage')}<li class="nav-item"><a href="?page=facebook">{$LNG.mu_fb_options}</a></li>{/if}
    {if allowedTo('ShowModulePage')}<li class="nav-item"><a href="?page=module">{$LNG.mu_module}</a></li>{/if}
    {if allowedTo('ShowDisclamerPage')}<li class="nav-item"><a href="?page=disclamer">{$LNG.mu_disclaimer}</a></li>{/if}
    {if allowedTo('ShowStatsPage')}<li class="nav-item"><a href="?page=statsconf">{$LNG.mu_stats_options}</a></li>{/if}
    {* if allowedTo('ShowVertifyPage')}<li class="nav-item"><a href="?page=vertify">{$LNG.mu_vertify}</a></li>{/if *}
    {if allowedTo('ShowCronjobPage')}<li class="nav-item"><a href="?page=cronjob">{$LNG.mu_cronjob}</a></li>{/if}
    {if allowedTo('ShowDumpPage')}<li class="nav-item"><a href="?page=dump">{$LNG.mu_dump}</a></li>{/if}
    <li class="nav-item"><span>{$LNG.mu_users_settings}</span></li>
    {if allowedTo('ShowCreatorPage')}<li class="nav-item"><a href="?page=create">{$LNG.new_creator_title}</a></li>{/if}
    {if allowedTo('ShowAccountEditorPage')}<li class="nav-item"><a href="?page=accounteditor">{$LNG.mu_add_delete_resources}</a></li>{/if}
    {if allowedTo('ShowBanPage')}<li class="nav-item"><a href="?page=bans">{$LNG.mu_ban_options}</a></li>{/if}
    {if allowedTo('ShowGiveawayPage')}<li class="nav-item"><a href="?page=giveaway">{$LNG.mu_giveaway}</a></li>{/if}
    <li class="nav-item"><span>{$LNG.mu_observation}</span></li>
    {if allowedTo('ShowSearchPage')}<li class="nav-item"><a href="?page=search&amp;search=online&amp;minimize=on">{$LNG.mu_connected}</a></li>{/if}
    {if allowedTo('ShowSupportPage')}<li class="nav-item"><a href="?page=support">{$LNG.mu_support}{if $supportticks != 0} ({$supportticks}){/if}</a></li>{/if}
    {if allowedTo('ShowActivePage')}<li class="nav-item"><a href="?page=active">{$LNG.mu_vaild_users}</a></li>{/if}
    {if allowedTo('ShowSearchPage')}<li class="nav-item"><a href="?page=search&amp;search=p_connect&amp;minimize=on">{$LNG.mu_active_planets}</a></li>{/if}
    {if allowedTo('ShowFlyingFleetPage')}<li class="nav-item"><a href="?page=fleets">{$LNG.mu_flying_fleets}</a></li>{/if}
    {if allowedTo('ShowNewsPage')}<li class="nav-item"><a href="?page=news">{$LNG.mu_news}</a></li>{/if}
    {if allowedTo('ShowSearchPage')}<li class="nav-item"><a href="?page=search&amp;search=users&amp;minimize=on">{$LNG.mu_user_list}</a></li>{/if}
    {if allowedTo('ShowSearchPage')}<li class="nav-item"><a href="?page=search&amp;search=planet&amp;minimize=on">{$LNG.mu_planet_list}</a></li>{/if}
    {if allowedTo('ShowSearchPage')}<li class="nav-item"><a href="?page=search&amp;search=moon&amp;minimize=on">{$LNG.mu_moon_list}</a></li>{/if}
    {if allowedTo('ShowMessageListPage')}<li class="nav-item"><a href="?page=messagelist">{$LNG.mu_mess_list}</a></li>{/if}
    {if allowedTo('ShowAccountDataPage')}<li class="nav-item"><a href="?page=accountdata">{$LNG.mu_info_account_page}</a></li>{/if}
    {if allowedTo('ShowSearchPage')}<li class="nav-item"><a href="?page=search">{$LNG.mu_search_page}</a></li>{/if}
    {if allowedTo('ShowMultiIPPage')}<li class="nav-item"><a href="?page=multiips">{$LNG.mu_multiip_page}</a></li>{/if}
    <li class="nav-item"><span>{$LNG.mu_tools}</span></li>
    {if allowedTo('ShowLogPage')}<li class="nav-item"><a href="?page=log">{$LNG.mu_logs}</a></li>{/if}
    {if allowedTo('ShowCreatorPage')}<li class="nav-item"><a href="?page=npc">{$LNG.npc_creator}</a></li>{/if}
    {if allowedTo('ShowSendMessagesPage')}<li class="nav-item"><a href="?page=globalmessage">{$LNG.mu_global_message}</a></li>{/if}
    {if allowedTo('ShowPassEncripterPage')}<li class="nav-item"><a href="?page=password">{$LNG.mu_md5_encripter}</a></li>{/if}
    {if allowedTo('ShowStatUpdatePage')}<li class="nav-item"><a href="?page=statsupdate" onClick=" return confirm('{$LNG.mu_mpu_confirmation}');">{$LNG.mu_manual_points_update}</a></li>{/if}
    {if allowedTo('ShowClearCachePage')}<li class="nav-item"><a href="?page=clearcache">{$LNG.mu_clear_cache}</a></li>{/if}
</ul>