{block name="title" prepend}{$LNG.fcm_info}{/block}
{block name="content"}
    <div class="card">
        <div class="card-body">
            <p class="alert alert-warning">{$message}</p>
            {if !empty($redirectButtons)}
                {foreach $redirectButtons as $button}<a href="{$button.url}"
                                                        class="btn btn-primary">{$button.label}</a>{/foreach}
            {/if}
        </div>
    </div>
{/block}
