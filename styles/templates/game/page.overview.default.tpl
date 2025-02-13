{block name="title" prepend}{$LNG.lm_overview}{/block}
{block name="content"}
    <div class="row row-cols-1 row-cols-lg-2 g-4">
        <div class="col mb-2">
            <div class="card">
                <div class="card-header">
                    <h2>{$LNG.lm_overview}</h2>
                </div>
                <div class="card-body">
                    {$LNG.ov_server_time}:
                    <span class="servertime">{$servertime}</span>
                    <br/>
                    {$LNG.ov_players} {$LNG.ov_online}: {$usersOnline}<br/>
                    {$LNG.ov_moving_fleets}: {$fleetsOnline}<br/>
                    {$LNG.ov_points}: {$rankInfo}<br/>
                    {if $noob.active}
                        {$LNG.noob_protection}:
                        {if $noob.points < $noob.limit}
                            {sprintf($LNG.noob_active_until, $noob.points)}
                        {else}
                            {sprintf($LNG.noob_inactive, $noob.lower_limit, $noob.upper_limit)}
                        {/if}<br />
                    {/if}
                    {$LNG.ov_planet_colonization}: {$USER.current_planet_count} / {$planets_max}<br />
                    {if $is_news}
                        <div class="collapse" id="news">
                            {$LNG.ov_news}:&nbsp;{$news}
                        </div>
                    {/if}
                    <hr/>
                    <h5 class="card-subtitle mb-2">{$LNG.ov_fleet_incoming}</h5>
                    <ul class="collapse show list-group" id="fleet-info">
                        {foreach $fleets as $index => $fleet}
                            <li class="list-group-item">
                                <span id="fleettime_{$index}" class="fleets" data-fleet-end-time="{$fleet.returntime}"
                                      data-fleet-time="{$fleet.resttime}">{pretty_fly_time({$fleet.resttime})}</span>
                                <span id="fleettime_{$index}">{$fleet.text}</span>
                            </li>
                        {/foreach}
                    </ul>
                    <hr/>
                    <h5 class="card-subtitle mb-2">{$LNG.ov_fleet_planet}</h5>
                    <div class="d-flex w-100">
                        <ul class="list-group flex-grow-1">
                            <li class="list-group-item">
                                <a class="nav-link" href="game.php?page=shipyard&amp;mode=fleet">{$LNG.lm_fleet}</a>
                            </li>
                            {foreach $offMissiles as $ID => $amount}
                                {if $amount > 0}
                                    <li class="list-group-item d-flex justify-content-between align-items-center"><span
                                                class="badge bg-primary rounded-pill">{$amount|number}</span> <a
                                                href="#" onclick="return Dialog.info({$ID});">{$LNG.tech.{$ID}}</a></li>
                                {/if}
                            {/foreach}
                        </ul>
                        <ul class="list-group flex-grow-1">
                            <li class="list-group-item"><a class="nav-link"
                                                           href="game.php?page=shipyard&amp;mode=defense">{$LNG.lm_defenses}</a>
                            </li>
                            {foreach $defMissiles as $ID => $amount}
                                {if $amount > 0}
                                    <li class="list-group-item d-flex justify-content-between align-items-center"><span
                                                class="badge bg-info rounded-pill">{$amount|number}</span>
                                        <a href="#" onclick="return Dialog.info({$ID});">{$LNG.tech.{$ID}}</a>
                                    </li>
                                {/if}
                            {/foreach}
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-info" data-bs-target="#news"
                            data-bs-toggle="collapse">{$LNG.toggle_news}</button>

                    <button class="btn btn-sm btn-info" data-bs-target="#fleet-info"
                            data-bs-toggle="collapse">{$LNG.toggle_fleets}</button>

                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="float-end">
                        <a class="btn btn-secondary" href="game.php?page=galaxy"
                           title="{$LNG.lm_galaxy}"><i class="fas fa-sun"></i></a>
                        <a class="btn btn-secondary" onclick="return Dialog.PlanetAction();"
                           title="{$LNG.ov_planetmenu}"><i class="fas fa-edit"></i></a>
                    </div>
                    <h2>{$LNG["type_planet_{$PLANET.planet_type}"]} {$PLANET.name}</h2>
                </div>
                <div class="card-body d-flex">
                    <div class="d-inline-block">
                        <img style="float: left;" src="{$dpath}planeten/{$PLANET.image}.jpg" height="200" width="200"
                             alt="{$PLANET.name}">
                    </div>
                    <div class="d-inline-block ps-1 flex-grow-1">
                        <ul class="list-group">
                            {if $buildInfo.buildings}
                                <li class="list-group-item list-group-item-warning"><a
                                            href="game.php?page=buildings">{$LNG.lm_buildings}
                                        :</a> {$LNG.tech[$buildInfo.buildings['id']]} ({$buildInfo.buildings['level']})
                                    <span class="timer float-end" data-time="{$buildInfo.buildings['timeleft']}"></span>
                                </li>
                            {else}
                                <li class="list-group-item list-group-item-success"><a
                                            href="game.php?page=buildings">{$LNG.lm_buildings}
                                        : {$LNG.ov_free}</a></li>
                            {/if}
                            {if $buildInfo.tech}
                                <li class="list-group-item list-group-item-warning"><a
                                            href="game.php?page=research">{$LNG.lm_research}
                                        :</a> {$LNG.tech[$buildInfo.tech['id']]} ({$buildInfo.tech['level']})

                                    <span class="timer float-end" data-time="{$buildInfo.tech['timeleft']}"></span></li>
                            {else}
                                <li class="list-group-item list-group-item-success"><a
                                            href="game.php?page=research">{$LNG.lm_research}: {$LNG.ov_free}</a></li>
                            {/if}
                            {if $buildInfo.fleet}
                                <li class="list-group-item list-group-item-warning"><a
                                            href="game.php?page=shipyard&amp;mode=fleet">{$LNG.lm_shipshard}
                                        :</a> {$LNG.tech[$buildInfo.fleet['id']]} ({$buildInfo.fleet['level']})
                                    <span class="timer float-end" data-time="{$buildInfo.fleet['timeleft']}"></span>
                                </li>
                            {else}
                                <li class="list-group-item list-group-item-success"><a
                                            href="game.php?page=shipyard&amp;mode=fleet">{$LNG.lm_shipshard}
                                        : {$LNG.ov_free}</a></li>
                            {/if}
                            <li class="list-group-item {if $PLANET.coins > 0}list-group-item-danger{/if}">{$LNG.cuneros_coins}
                                : <span class="info-coins">{$PLANET.coins|number_format}</span>{if $PLANET.coins > 0}<a
                                        class="btn btn-primary btn-sm float-end json-request" data-value="0" data-target=".info-coins"
                                        data-href="game.php?page=overview&amp;mode=claim_coins">{$LNG.cuneros_claim}</a>{/if}
                            </li>
                        </ul>
                        <br>
                        {$LNG.ov_diameter}: {$PLANET.diameter} {$LNG.ov_distance_unit} (<a
                                title="{$LNG.ov_developed_fields}">{$PLANET.field_current}</a> / <a
                                title="{$LNG.ov_max_developed_fields}">{$PLANET.field_max}</a> {$LNG.ov_fields})
                        <br>{$LNG.ov_temperature}
                        : {$LNG.ov_aprox} {$PLANET.temp_min}{$LNG.ov_temp_unit} {$LNG.ov_to} {$PLANET.temp_max}{$LNG.ov_temp_unit}
                        <br>{$LNG.ov_position}: {BuildPlanetAddressLink($PLANET)}

                    </div>
                </div>
            </div>
            {if $Moon}
                <div class="card mt-2">
                    <div class="card-header">
                        <h2>{$LNG.fcm_moon}</h2>
                    </div>
                    <div class="card-body">
                        <div class="moon-overview">
                            <a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" title="{$Moon.name}">
                                <img src="{$dpath}planeten/mond.jpg" height="100" width="100 "
                                     alt="{$Moon.name} ({$LNG.fcm_moon})"><br />
                                {$Moon.name} ({$LNG.fcm_moon})</a>
                        </div>
                    </div>
                </div>
            {/if}

            {if $AllPlanets}
                <div class="card mt-2">
                    <div class="card-header">
                        <h2 class="card-title">{$LNG.lv_planet_other}</h2>
                    </div>
                    <div class="card-body row">
                        {foreach $AllPlanets as $PlanetRow}
                            <div class="col">
                                <a href="game.php?page=overview&amp;cp={$PlanetRow.id}" title="{$PlanetRow.name}">
                                    <img src="{$dpath}planeten/{$PlanetRow.image}.jpg" width="100" height="100"
                                         alt="{$PlanetRow.name}"><br/>
                                    {$PlanetRow.name}
                                </a>
                                <br>{$PlanetRow.build}<br>
                            </div>
                        {/foreach}
                    </div>
                </div>
            {/if}
        </div>
    </div>
{/block}
{block name="script" append}
    <script src="scripts/game/overview.js?3"></script>
{/block}
