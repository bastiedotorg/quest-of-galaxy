{block name="title" prepend}{$LNG.siteTitleLostPassword}{/block}
{block name="content"}
    <div class="col-12 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{$LNG.siteTitleLostPassword}</h3>
            </div>
            <div class="card-body">
                <p>{$LNG.passwordInfo}</p>
                <form action="index.php?page=lostPassword" method="post" data-action="index.php?page=lostPassword">
                    <input type="hidden" value="send" name="mode">
                    <div class="row">
                        <label for="universe" class="form-label">{$LNG.universe}</label>
                        <select name="uni" class="changeAction form-control"
                                id="universe">{html_options options=$universeSelect selected=$UNI}</select>
                    </div>
                    <div class="row">
                        <label for="username" class="form-label">{$LNG.passwordUsername}</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="row">
                        <label for="mail" class="form-label">{$LNG.passwordMail}</label>
                        <input type="email" name="mail" id="mail" class="form-control">
                    </div>
                    {if $config->recaptcha_active}
                        <div class="row" id="captchaRow">
                            <div>
                                <label>{$LNG.registerCaptcha}<p class="captchaButtons"></p></label>
                                <div class="g-recaptcha" data-sitekey="{$config->recaptcha_public_key}"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    {/if}
                    <div class="row mt-2">
                        <input type="submit" class="btn btn-primary submitButton" value="{$LNG.passwordSubmit}">
                    </div>
                </form>

            </div>
        </div>
    </div>
{/block}
{block name="script" append}
    {if $config->recaptcha_active}
        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl={$lang}"></script>
    {/if}
{/block}