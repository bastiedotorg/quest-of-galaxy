<h4>{$currentPlanet.alliance.name}</h4>
<h6>{$currentPlanet.alliance.member}</h6>

<div class='list-group'>
<a class='list-group-item' href='?page=alliance&amp;mode=info&amp;id={$currentPlanet.alliance.id}'>{$LNG.gl_alliance_page}</a>
    <a class='list-group-item' href='?page=statistics&amp;start={$currentPlanet.alliance.rank}&amp;who=2'>{$LNG.gl_see_on_stats}</a>
{if $currentPlanet.alliance.web}
    <a class='list-group-item' href='{$currentPlanet.alliance.web}' target='allyweb'>{$LNG.gl_alliance_web_page}</a>
{/if}
</div>