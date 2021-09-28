{include file="overall_header.tpl"}
<form action="" method="post">
    <input type="hidden" name="opt_save" value="1">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{$LNG.se_server_parameters}</h3>
        </div>
        <div class="card-body">
            {foreach $server_config as $key => $type}
                <div class="row">
                    <div class="col"><label for="id_{$key}" class="form-label">{$LNG.se_server_settings.$key}</label>
                    </div>
                    <div class="col">
                        {if isset($Selector.$key)}
                            {html_options id="id_{$key}" name=$key options=$Selector.$key selected=$current_config.$key class="form-control"}
                        {else}
                            <input id="id_{$key}" class="{if $type == "boolean"}form-check{else}form-control{/if}"
                                   name="{$key}" {if $type == "boolean"}{if $current_config.$key == true}checked{/if}{else}value="{$current_config.$key}"{/if}
                                   type="{if $type == "string"}text{elseif $type == "boolean"}checkbox{else}number{/if}"/>
                        {/if}
                    </div>
                </div>
            {/foreach}
        </div>
        <div class="card-footer">
            <button class="float-end btn btn-primary" type="submit">{$LNG.cs_save_changes}</button>
        </div>
    </div>
</form>
{include file="overall_footer.tpl"}