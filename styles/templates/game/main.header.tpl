<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="{$lang}" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="{$lang}" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="{$lang}" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="{$lang}" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="{$lang}" class="no-js"> <!--<![endif]-->
<head>
    <title>{block name="title"} - {$uni_name} - {$game_name}{/block}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    {if !empty($goto)}
        <meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
    {/if}
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link href="./styles/resource/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="./styles/resource/bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="./styles/resource/css/base/boilerplate.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/ingame/main.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/base/jquery.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/base/jquery.fancybox.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/base/validationEngine.jquery.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="{$dpath}formate.css?v={$REV}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <script type="text/javascript">
        var ServerTimezoneOffset = {$Offset};
        var serverTime = new Date({$date.0}, {$date.1 - 1}, {$date.2}, {$date.3}, {$date.4}, {$date.5});
        var startTime = serverTime.getTime();
        var localTime = serverTime;
        var localTS = startTime;
        var Gamename = document.title;
        var Ready = "{$LNG.ready}";
        var Skin = "{$dpath}";
        var Lang = "{$lang}";
        var head_info = "{$LNG.fcm_info}";
        var auth = {$authlevel|default:'0'};
        var days = {$LNG.week_day|json|default:'[]'}
        var months = {$LNG.months|json|default:'[]'} ;
        var tdformat = "{$LNG.js_tdformat}";
        var queryString = "{$queryString|escape:'javascript'}";
        var isPlayerCardActive = "{$isPlayerCardActive|json}";
        var relativeTime = Math.floor(Date.now() / 1000);

        setInterval(function () {
            if (relativeTime < Math.floor(Date.now() / 1000)) {
                serverTime.setSeconds(serverTime.getSeconds() + 1);
                relativeTime++;
            }
        }, 1);
    </script>
    <script type="text/javascript" src="./scripts/base/jquery.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/jquery.ui.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/jquery.cookie.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/jquery.fancybox.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/jquery.validationEngine.js?v={$REV}"></script>
    <script type="text/javascript"
            src="./scripts/l18n/validationEngine/jquery.validationEngine-{$lang}.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/tooltip.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/game/base.js?v={$REV}"></script>
    {foreach item=scriptname from=$scripts}
        <script type="text/javascript" src="./scripts/game/{$scriptname}.js?v={$REV}"></script>
    {/foreach}
    {block name="script"}
        <script type="text/javascript" src="./scripts/game/btn-events.js?v={$REV}"></script>
    {/block}
    <script type="text/javascript">
        $(function () {
            {$execscript}
        });
    </script>
</head>
<body id="{$smarty.get.page|htmlspecialchars|default:'overview'}" class="{$bodyclass}">
<main>
<div id="tooltip" class="tip"></div>

