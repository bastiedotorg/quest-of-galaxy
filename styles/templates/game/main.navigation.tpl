

<div class="p-3 shadow" id="mainNav">
    <img src="styles/resource/images/logo.png" class="img-logo img-fluid"/>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item"><a class="btn btn-toggle align-items-center rounded" href="game.php?page=overview">{$LNG.lm_overview}</a></li>

        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                Allgemein
            </button>
            <div class="collapse " id="home-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    {if isModuleAvailable($smarty.const.MODULE_BUILDING)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=buildings">{$LNG.lm_buildings}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_SHIPYARD_FLEET)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=shipyard&amp;mode=fleet">{$LNG.lm_shipshard}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_SHIPYARD_DEFENSIVE)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=shipyard&amp;mode=defense">{$LNG.lm_defenses}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_RESEARCH)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=research">{$LNG.lm_research}</a></li>{/if}
                    <li class="nav-item"><a href="#" class="nav-link link-dark rounded" onclick="return Dialog.GeneralChat();">{$LNG.lm_chat}</a>

                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#overview-collapse" aria-expanded="false">
                &Uuml;bersichten
            </button>
            <div class="collapse " id="overview-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    {if isModuleAvailable($smarty.const.MODULE_TRADER)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=fleetTable">{$LNG.lm_fleet}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_GALAXY)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=galaxy">{$LNG.lm_galaxy}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_IMPERIUM)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=imperium">{$LNG.lm_empire}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_TECHTREE)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=techtree">{$LNG.lm_technology}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_RESSOURCE_LIST)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=resources">{$LNG.lm_resources}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_CUNEROS)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=referral">{$LNG.lm_referral}</a></li>{/if}

                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#buy-collapse" aria-expanded="false">
                Einkaufen
            </button>
            <div class="collapse " id="buy-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    {if isModuleAvailable($smarty.const.MODULE_CUNEROS)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=cuneros">{$LNG.lm_cuneros}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_OFFICIER) || isModuleAvailable($smarty.const.MODULE_DMEXTRAS)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=officier">{$LNG.lm_officiers}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_TRADER)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=trader">{$LNG.lm_trader}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_TRADER)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=marketPlace">{$LNG.lm_marketplace}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_FLEET_TRADER)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=fleetDealer">{$LNG.lm_fleettrader}</a></li>{/if}

                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#info-collapse" aria-expanded="false">
                Information
            </button>
            <div class="collapse " id="info-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    {if isModuleAvailable($smarty.const.MODULE_STATISTICS)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=statistics">{$LNG.lm_statistics}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_RECORDS)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=records">{$LNG.lm_records}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_BATTLEHALL)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=battleHall">{$LNG.lm_topkb}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_SEARCH)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=search">{$LNG.lm_search}</a></li>{/if}
                    {if isModuleAvailable($smarty.const.MODULE_SUPPORT)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=ticket">{$LNG.lm_support}</a></li>{/if}
                    <li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=questions">{$LNG.lm_faq}</a></li>
                    <li class="nav-item"><a class="nav-link link-dark rounded" href="index.php?page=rules" target="rules">{$LNG.lm_rules}</a></li>
                    {if isModuleAvailable($smarty.const.MODULE_SIMULATOR)}<li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=battleSimulator">{$LNG.lm_battlesim}</a></li>{/if}

                </ul>
            </div>
        </li>

        {if isModuleAvailable($smarty.const.MODULE_ALLIANCE)}
            {if !$hasAlly}<li class="nav-item"><a class="btn btn-toggle align-items-center rounded" href="game.php?page=alliance">{$LNG.lm_alliance}</a></li>
            {else}
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#ally-collapse" aria-expanded="false">
                {$LNG.lm_alliance}
            </button>
            <div class="collapse " id="ally-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=alliance">{$LNG.lm_alliance_overview}</a></li>
                    <li class="nav-item"><a class="nav-link link-dark rounded" href="game.php?page=allianceBoard">{$LNG.lm_ally_board}</a></li>
                    <li class="nav-item"><a class="nav-link link-dark rounded" href="#" onclick="return Dialog.AllianceChat();">{$LNG.al_goto_chat}</a></li>
                    <li class="nav-item"><a class="nav-link link-dark rounded" href="?page=alliance&amp;mode=memberList">{$LNG.al_user_list}</a></li>
                </ul>
            </div>
        </li>
                {/if}
        {/if}

        {if $authlevel > 0}<li class="nav-item"><a class="btn btn-danger" href="./admin.php">{$LNG.lm_administration} ({$VERSION})</a></li>{/if}
</div>
