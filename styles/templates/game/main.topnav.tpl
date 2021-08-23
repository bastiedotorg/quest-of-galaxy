<nav class="navbar navbar-expand-md  navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="game.php?page=overview" class="navbar-brand">
            <img src="{$dpath}planeten/{$image}.jpg" width="50" height="50"
                 alt="{$LNG.lm_overview}"></a>
        <a class="navbar-brand" href="game.php?page=overview">Quest of Galaxy</a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="d-flex flex-grow-1">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    {foreach $resourceTable as $resourceID => $resourceData}
                        <li class="nav-item res-item"><a class="nav-link" href="#"
                                                         onclick="return Dialog.info({$resourceID});">
                                <img src="{$dpath}images/{$resourceData.name}.gif">
                                <span class="d-lg-block">{$LNG.tech.$resourceID}</span>
                                {if !isset($resourceData.current)}
                                    {$resourceData.currentt = $resourceData.max + $resourceData.used}
                                    <span title="{$resourceData.currentt|number}">
                                        <span{if $resourceData.currentt < 0} style="color:red"{/if}>{$resourceData.currentt|number}&nbsp;/&nbsp;{$resourceData.max|number}</span>
                                    </span>
                                {else}
                                    <span class="res_current" id="current_{$resourceData.name}"
                                          data-real="{$resourceData.current}">
                                        {$resourceData.current|number}
                                    </span>
                                {/if}
                                {if !isset($resourceData.current) || !isset($resourceData.max)}
                                {else}
                                    /
                                    <span class="res_max" id="max_{$resourceData.name}"
                                          data-real="{$resourceData.current}">{$resourceData.max|number}</span>
                                {/if}
                            </a>
                        </li>
                    {/foreach}
                </ul>
                <ul class="navbar-nav ms-auto flex-nowrap">
                    <li class="nav-item pe-2 pt-2">
                        <select id="planetSelector" class="form-control">
                            {html_options options=$PlanetSelect selected=$current_pid}
                        </select>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{$avatar}" alt="" width="50" height="50" class="rounded-circle me-2">
                                <strong>{$username}</strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                {if isModuleAvailable($smarty.const.MODULE_MESSAGES)}<li class="nav-item"><a class="nav-link" href="game.php?page=messages">{$LNG.lm_messages}{nocache}{if $new_message > 0}<span id="newmes"> (<span id="newmesnum">{$new_message}</span>)</span>{/if}{/nocache}</a></li>{/if}
                                <li class="nav-item"><a class="nav-link" href="game.php?page=settings">{$LNG.lm_options}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="nav-item"><a class="nav-link" href="game.php?page=logout">{$LNG.lm_logout}</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</nav>


<div class="planetImage no-mobile">
</div>


{if !$vmode}
    <script type="text/javascript">
        var viewShortlyNumber = {$shortlyNumber|json};
        var vacation = {$vmode};
        $(function () {
            {foreach $resourceTable as $resourceID => $resourceData}
            {if isset($resourceData.production)}
            resourceTicker({
                available: {$resourceData.current|json},
                limit: [0, {$resourceData.max|json}],
                production: {$resourceData.production|json},
                valueElem: "current_{$resourceData.name}"
            }, true);
            {/if}
            {/foreach}
        });
    </script>
    <script src="scripts/game/topnav.js"></script>
    {if $hasGate}
        <script src="scripts/game/gate.js"></script>
    {/if}
{/if}