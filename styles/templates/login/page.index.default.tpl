{block name="title" prepend}{$LNG.siteTitleIndex}{/block}
{block name="content"}

    <!-- Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">{$LNG.siteTitleRegister}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {include "forms.register.tpl"}
                </div>
            </div>
        </div>
    </div>
    <main class="container">
        <div class="row">
            <div class="col-xl-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-text">Nur noch</h6>
                        <h4 class="text-center" id="countdown"></h4>
                        <h6 class="card-text">Dann startet Quest-of-Galaxy!</h6>

                        <img class="img-fluid" src="styles/resource/images/header.png"/>
                        <p class="lead">{$descText}</p>
                        <ul id="desc_list">
                            <li>Weltraum-Strategiespiel in Echtzeit</li>
                            <li>Erobere fremde Planeten</li>
                            <li>Kostenlose Registierung</li>
                            <li>Zeite dein Geschick gegen hunderte User</li>
                            <li>Cuneros für alle aktiven User</li>
                            <li>27 Gebäude- und 14 Schiffstypen</li>
                            </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>{$LNG.loginHeader}</h2>
                    </div>
                    <div class="card-body">
                        <form id="login" name="login" action="index.php?page=login" data-action="index.php?page=login"
                              method="post">
                            <div class="row">
                                <div class="mb-3">
                                    <select class="form-select changeAction" aria-label="Default universe example"
                                            name="uni" id="universe">
                                        {html_options options=$universeSelect selected=$UNI}
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                           class="form-label">{$LNG.loginUsername}</label>
                                    <input type="text" class="form-control" placeholder="{$LNG.loginUsername}"
                                           id="username"
                                           name="username">
                                </div>
                                <div class="mb-3">
                                    <label for="id_password" class="form-label">{$LNG.loginPassword}</label>
                                    <input type="password" class="form-control" id="id_password"
                                           placeholder="{$LNG.loginPassword}" name="password">
                                </div>
                                <div class="mb-3">
                                    {if $config->recaptcha_active}
                                        <script src='https://www.google.com/recaptcha/api.js'></script>
                                        <script>function onSubmit() {
                                                document.getElementById("login").submit();
                                            } </script>
                                        <input class="g-recaptcha btn btn-primary" data-sitekey="{$config->recaptcha_public_key}"
                                               data-callback="onSubmit"
                                               type="submit" value="{$LNG.loginButton}">
                                    {else}
                                        <input type="submit" class="btn btn-primary" value="{$LNG.loginButton}">
                                    {/if}
                                </div>
                            </div>
                        </form>
                        {if $config->facebook_active}
                            <a href="#" data-href="index.php?page=externalAuth&method=facebook" class="fb_login"><img
                                        src="styles/resource/images/facebook/fb-connect-large.png" alt=""></a>
                        {/if}
                        <a class="btn btn-primary" href="#" data-bs-toggle="modal"
                           data-bs-target="#registerModal">{$LNG.buttonRegister}</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
{literal}
    <script>
        function pad(num, size) {
            var s = "000000000" + num;
            return s.substr(s.length-size);
        }
        // Set the date we're counting down to
        var countDownDate = new Date("Sep 26, 2021 15:00:00").getTime();

        // Update the count down every 1 second
        function updateCD() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("countdown").innerHTML = days + " Tage " + pad(hours,2) + ":"
                + pad(minutes,2) + ":" + pad(seconds,2) + "";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "JETZT ANMELDEN!";
            }
            window.setTimeout(function (){updateCD()}, 1000);
        }
        updateCD();
    </script>
{/literal}
{/block}
{block name="script" append}
    <script>{if $code}alert({$code|json});{/if}</script>

{/block}