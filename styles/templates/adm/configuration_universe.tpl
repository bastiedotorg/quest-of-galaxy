{block name="content"}
    <h3>{$LNG.se_server_parameters}</h3>
    <table class="table table-striped">
    {foreach $config_vars as $key => $field}
        <tr>
            <td><label for="id_{$key}">{$LNG.$key}</label></td>
            <td><input id="id_{$key}" value="{$config->$key}" type="{if $field.type == "string"}text{else}number{/if}"/> ({$field.default})</td>
        </tr>
    {/foreach}
    </table>
{/block}