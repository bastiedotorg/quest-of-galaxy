<tr>
	<th style="width:60px;">{$LNG.st_position}</th>
	<th>{$LNG.st_player}</th>
	<th>&nbsp;</th>
	<th>{$LNG.st_alliance}</th>
	<th>{$LNG.st_points}</th>
</tr>
{foreach name=RangeList item=RangeInfo from=$RangeList}
<tr>
	<td><a class="tooltip" data-tooltip-content="{if $RangeInfo.ranking == 0}<span style='color:#87CEEB'>*</span>{elseif $RangeInfo.ranking < 0}<span style='color:red'>-{$RangeInfo.ranking}</span>{elseif $RangeInfo.ranking > 0}<span style='color:green'>+{$RangeInfo.ranking}</span>{/if}">{$RangeInfo.rank}</a></td>
	<td><a href="#" onclick="return Dialog.Playercard({$RangeInfo.id}, '{$RangeInfo.name}');"{if $RangeInfo.id == $CUser_id} style="font-weight:bold"{/if}>{$RangeInfo.name}&nbsp;</a>{if $RangeInfo.is_leader}<a style="font-weight:bold;" class="tooltip" data-tooltip-content="<table width='100%'><tr><th colspan='2' style='text-align:center;'>{$RangeInfo.ally_owner_range}</th></tr><tr><td class='transparent'>{$RangeInfo.allyname}</td></tr></table>"><i class="fas fa-trophy"></i></a>{/if} {if $RangeInfo.id != $CUser_id && !empty($RangeInfo.class)}{foreach $RangeInfo.class as $class}{if !$class@first}&nbsp;{/if}<span class="galaxy-short-{$class} galaxy-short">{$ShortStatus.$class}</span>{/foreach}{/if}</td>
	<td>{if $RangeInfo.id != $CUser_id}<a href="#" onclick="return Dialog.PM({$RangeInfo.id});"><img src="{$dpath}img/m.gif" title="{$LNG.st_write_message}" alt="{$LNG.st_write_message}"></a>{/if}</td>
	<td>{if $RangeInfo.allyid != 0}<a href="game.php?page=alliance&amp;mode=info&amp;id={$RangeInfo.allyid}">{if $RangeInfo.allyid == $CUser_ally}<span style="color:#33CCFF">{$RangeInfo.allyname}</span>{else}{$RangeInfo.allyname}{/if}</a>{else}-{/if}</td>
	<td>{$RangeInfo.points}</td>
</tr>
{/foreach}