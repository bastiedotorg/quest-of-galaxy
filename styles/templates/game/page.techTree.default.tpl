{block name="title" prepend}
    {$LNG.lm_technology}{/block}

{block name="content"}

<div class="card">
    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        {foreach from=$TechTreeMap key=$elementID item=$requireList}
            <li class="nav-item">
                <button class="nav-link p-3 {if $requireList@iteration == 1}active{/if}"
                   id="tab-{$elementID}" data-bs-toggle="tab"
                   data-bs-target="#content-{$elementID}" role="tab"
                   aria-controls="content-{$elementID}"
                   aria-selected="true">{$LNG.tech.$elementID}</button>
            </li>
        {/foreach}
        <li class="nav-item">
            <button class="nav-link p-3"
               id="tab-ships" data-bs-toggle="tab"
               data-bs-target="#content-ships"
               aria-controls="content-ships"
               aria-selected="true">{$LNG.techtree_ship_data}</button>

    </ul>
    <div class="tab-content" id="myTabContent">
        {foreach from=$TechTreeMap key=$ID item=$childItems name=techniques}
            <div class="tab-pane fade {if $childItems@iteration == 1}show active{/if}"
                 id="content-{$ID}" role="tabpanel" aria-labelledby="tab-{$ID}">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-2 build-gutter">
                    {foreach from=$childItems key=$ID item=$requireList name=techniques}
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title" onclick="return Dialog.info({$ID})">{$LNG.tech.{$ID}}
                                    </h6>
                                </div>

                                <a href="#" onclick="return Dialog.info({$ID})">
                                    <img class="card-img-top"
                                         src="{$dpath}gebaeude/{$ID}.{if $ID >=600 && $ID <= 699}jpg{else}gif{/if}"
                                         alt="{$LNG.tech.{$ID}}">
                                </a>
                                <div class="card-body">
                                    {if $requireList }
                                        {$LNG.tt_requirements}
                                        <ul class="list-group">
                                            {foreach $requireList as $requireID => $NeedLevel}
                                                <li onclick="return Dialog.info({$requireID});"
                                                    class="list-group-item list-group-item-{if $NeedLevel.own < $NeedLevel.count}danger{else}success{/if}">{$LNG.tech.$requireID}
                                                    ({$LNG.tt_lvl} {$NeedLevel.own}/{$NeedLevel.count})
                                                </li>
                                            {/foreach}
                                        </ul>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        {/foreach}
        <div class="tab-pane fade"
             id="content-ships" role="tabpanel" aria-labelledby="tab-ships">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{$LNG.bs_names}</th>
                    <th>{$LNG.in_attack_pt}</th>
                    <th>{$LNG.in_shield_pt}</th>
                    <th>{$LNG.tech.901}</th>
                    <th>{$LNG.tech.902}</th>
                    <th>{$LNG.tech.903}</th>
                    <th>{$LNG.in_base_speed}</th>
                    <th>{$LNG.in_capacity}</th>
                </tr>
                </thead>
                <tbody>
                {foreach $ships as $ship}
                    <tr>
                        <td>{$LNG.tech.$ship}</td>
                        <td>{$CombatCaps.$ship.attack|number}</td>
                        <td>{$CombatCaps.$ship.shield|number}</td>
                        <td>{$priceList.$ship.cost.901|number}</td>
                        <td>{$priceList.$ship.cost.902|number}</td>
                        <td>{$priceList.$ship.cost.903|number}</td>
                        <td>{$priceList.$ship.speed|number}</td>
                        <td>{$priceList.$ship.capacity|number}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>

        {/block}
