<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="{$lang}" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="{$lang}" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="{$lang}" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="{$lang}" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{$lang}" class="no-js"> <!--<![endif]-->
<head>
    <title>{$title}</title>
    {if !empty($goto)}
        <meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
    {/if}
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link href="./styles/resource/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="./styles/resource/css/base/boilerplate.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/ingame/main.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/admin/main.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/base/jquery.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/base/jquery.fancybox.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/resource/css/base/validationEngine.jquery.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="./styles/theme/qog/formate.css?v={$REV}">
    <link rel="stylesheet" type="text/css" href="styles/resource/css/login/icon-font/style.css?v={$REV}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" type="text/css">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <script type="text/javascript">
        var ServerTimezoneOffset = {$Offset};
        var serverTime 	= new Date({$date.0}, {$date.1 - 1}, {$date.2}, {$date.3}, {$date.4}, {$date.5});
        var xsize 	= screen.width;
        var ysize 	= screen.height;
        var breite	= 720;
        var hoehe	= 300;
        var xpos	= (xsize-breite) / 2;
        var ypos	= (ysize-hoehe) / 2;
        var Ready		= "{$LNG.ready}";
        var Skin		= "{$dpath}";
        var Lang		= "{$lang}";
        var head_info	= "{$LNG.fcm_info}";
        var days 		= {$LNG.week_day|json|default:'[]'}
        var months 		= {$LNG.months|json|default:'[]'} ;
        var tdformat	= "{$LNG.js_tdformat}";
        function openEdit(id, type) {
            var editlist = window.open("?page=qeditor&edit="+type+"&id="+id, "edit", "scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width=850,height=600,screenX="+((xsize-600)/2)+",screenY="+((ysize-850)/2)+",top="+((ysize-600)/2)+",left="+((xsize-850)/2));
            editlist.focus();
        }
    </script>
    <script type="text/javascript" src="./scripts/base/jquery.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/jquery.ui.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/jquery.cookie.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/jquery.fancybox.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/jquery.validationEngine.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/l18n/validationEngine/jquery.validationEngine-{$lang}.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/base/tooltip.js?v={$REV}"></script>
    <script type="text/javascript" src="./scripts/game/base.js?v={$REV}"></script>
    {foreach item=scriptname from=$scripts}
        <script type="text/javascript" src="./scripts/game/{$scriptname}.js?v={$REV}"></script>
    {/foreach}
    <script type="text/javascript">
        $(function() {
            {$execscript}
        });
    </script>
</head>
<body id="{$smarty.get.page|htmlspecialchars|default:'overview'}" class="{$bodyclass}">
