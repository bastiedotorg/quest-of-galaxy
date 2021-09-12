{block name="title" prepend}{$LNG.lm_empire}{/block}
{block name="content"}
    <div class="card">
        <div class="card-header">
            <h2>{$LNG.lv_imperium_title}</h2>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width:100px">{$LNG.lv_planet}</th>
                    <th style="width:100px;font-size: 50px;">&Sigma;</th>
                    {foreach $planetList.image as $planetID => $image}
                        <th style="width:100px">
                            <a href="game.php?page=overview&amp;cp={$planetID}">
                                <img width="80" height="80" src="{$dpath}planeten/{$image}.jpg">
                            </a>
                        </th>
                    {/foreach}
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{$LNG.lv_name}</td>
                    <td>{$LNG.lv_total}</td>
                    {foreach $planetList.name as $name}
                        <td>{$name}</td>
                    {/foreach}
                </tr>
                <tr>
                    <td>{$LNG.lv_coords}</td>
                    <td>-</td>
                    {foreach $planetList.coords as $coords}
                        <td>
                            <a href="game.php?page=galaxy&amp;galaxy={$coords.galaxy}&amp;system={$coords.system}">
                                [{$coords.galaxy}:{$coords.system}:{$coords.planet}]
                            </a>
                        </td>
                    {/foreach}
                </tr>
                <tr>
                    <td>{$LNG.lv_fields}</td>
                    <td>-</td>
                    {foreach $planetList.field as $field}
                        <td>{$field.current} / {$field.max}</td>
                    {/foreach}
                </tr>
                <tr>
                    <th colspan="{$colspan}">{$LNG.lv_resources}</th>
                </tr>
                {foreach $planetList.resource as $elementID => $resourceArray}
                    <tr>
                        <td><a href='#' onclick='return Dialog.info({$elementID});' class='tooltip' data-tooltip-content="{include "resource.info.tpl"}">{$LNG.tech.$elementID}</a>
                        </td>
                        <td>{array_sum($resourceArray)|number} {if in_array($elementID, array(901,902,903))}<span
                                    style="color:darkgreen">{array_sum($planetList.resourcePerHour[$elementID])|number}
                                /h</span>{/if}
                        </td>
                        {foreach $resourceArray as $planetID => $resource}
                            <td>{$resource|number} {if in_array($elementID, array(901,902,903)) && $planetList.planet_type[$planetID] == 1}
                                    <span style="color:darkgreen">{$planetList.resourcePerHour[$elementID][$planetID]|number}
                                    /h</span>{/if}</td>
                        {/foreach}
                    </tr>
                {/foreach}
                <tr>
                    <th colspan="{$colspan}">{$LNG.lv_buildings}</th>
                </tr>
                {foreach $planetList.build as $elementID => $buildArray}
                    <tr>
                        <td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip'
                               data-tooltip-content="{include "building.info.tpl"}">{$LNG.tech.$elementID}</a>
                        </td>
                        <td>{array_sum($buildArray)|number}</td>
                        {foreach $buildArray as $planetID => $build}
                            <td>{$build|number}</td>
                        {/foreach}
                    </tr>
                {/foreach}
                <tr>
                    <th colspan="{$colspan}">{$LNG.lv_technology}</th>
                </tr>
                {foreach $planetList.tech as $elementID => $tech}
                    <tr>
                        <td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip'
                               data-tooltip-content="{include "building.info.tpl"}">{$LNG.tech.$elementID}</a>
                        </td>
                        <td>{$tech|number}</td>
                        {foreach $planetList.name as $name}
                            <td>{$tech|number}</td>
                        {/foreach}
                    </tr>
                {/foreach}
                <tr>
                    <th colspan="{$colspan}">{$LNG.lv_ships}</th>
                </tr>
                {foreach $planetList.fleet as $elementID => $fleetArray}
                    <tr>
                        <td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip'
                               data-tooltip-content="{include "building.info.tpl"}">{$LNG.tech.$elementID}</a>
                        </td>
                        <td>{array_sum($fleetArray)|number}</td>
                        {foreach $fleetArray as $planetID => $fleet}
                            <td>{$fleet|number}</td>
                        {/foreach}
                    </tr>
                {/foreach}
                <tr>
                    <th colspan="{$colspan}">{$LNG.lv_defenses}</th>
                </tr>
                {foreach $planetList.defense as $elementID => $fleetArray}
                    <tr>
                        <td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip'
                               data-tooltip-content="{include "building.info.tpl"}">{$LNG.tech.$elementID}</a>
                        </td>
                        <td>{array_sum($fleetArray)|number}</td>
                        {foreach $fleetArray as $planetID => $fleet}
                            <td>{$fleet|number}</td>
                        {/foreach}
                    </tr>
                {/foreach}
                <tr>
                    <th colspan="{$colspan}">{$LNG.tech.500}</th>
                </tr>
                {foreach $planetList.missiles as $elementID => $fleetArray}
                    <tr>
                        <td><a href='#' onclick='return Dialog.info({$elementID})' class='tooltip'
                               data-tooltip-content="{include "building.info.tpl"}">{$LNG.tech.$elementID}</a>
                        </td>
                        <td>{array_sum($fleetArray)|number}</td>
                        {foreach $fleetArray as $planetID => $fleet}
                            <td>{$fleet|number}</td>
                        {/foreach}
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
{/block}
