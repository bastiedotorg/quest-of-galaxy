
<!-- building queue-->
{if !empty($Queue)}
    <div id="buildlist" class="infos1">
        {foreach $Queue as $List}
            {$ID = $List.element}
            <div class="d-flex justify-content-between alert {if $List@first}alert-info{else}alert-secondary{/if}" id="buildqueue-{$List@iteration}" data-name="{$LNG.tech.{$ID}}">
                <span>{$List@iteration}.: {$LNG.tech.{$ID}} {$LNG.bd_tech_next_level} {$List.level}</span>
                <div id="time" data-time="{$List.time}"><br></div>
                <span data-time="{$List.endtime}" class="timer d-none d-md-inline-block">{$List.display}</span>
                {if isset($ResearchList[$List.element])}
                    {$CQueue = $ResearchList[$List.element]}
                {/if}
                {if isset($CQueue) && $CQueue.maxLevel != $CQueue.level && !$IsFullQueue && $CQueue.buyable}
                    <form class="build_form d-none d-md-inline-block" action="game.php?page=research" method="post">
                        <input type="hidden" name="cmd" value="insert">
                        <input type="hidden" name="tech" value="{$ID}">
                        <button type="submit" class="build_submit onlist btn btn-success">{$LNG.tech.{$ID}} {$LNG.bd_tech_next_level} {$List.level+1}</button>
                    </form>
                {/if}
                <form action="game.php?page=research" method="post" class="build_form">
                    <input type="hidden" name="cmd" value="{if $List@iteration == 1}cancel{else}remove{/if}">
                    <input type="hidden" name="listid" value="{$List@iteration}">
                    <button type="submit" class="build_submit onlist btn btn-danger">{$LNG.bd_cancel}</button>
                </form>

                {if $List@first}
                    <div class="progress w-100 time shadow">
                        {$pct = 100-$List.resttime*100/$List.time}
                        <div data-resttime="{$List.resttime}" data-totaltime="{$List.time}" class="border-1 time-progress progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {$pct}%;"></div>
                    </div>
                {/if}
            </div>
        {/foreach}
    </div>
{/if}

<!-- end queue -->