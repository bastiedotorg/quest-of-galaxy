{block name="content"}
    <h3 class="card-title">{$LNG.se_server_parameters}</h3>
    <form method="post" id="configForm">
        <input type="hidden" name="universe_id" value="{$universeId}"/>
        <table class="table table-striped">
            {foreach $config_vars as $key => $field}
                <tr>
                    <td><label for="id_{$key}">{$LNG.config_labels.$key}</label><br/>
                        <p class="text-muted">{$LNG.config_help.$key}</p></td>
                    <td><input id="id_{$key}" value="{$config->$key}" name="{$key}"
                               {if $field.type == "boolean" && $config->$key}checked{/if}
                               type="{if $field.type == "string"}text{elseif $field.type=="boolean"}checkbox{else}number{/if}"/>
                        ({$field.default})
                    </td>
                </tr>
            {/foreach}
            <tr>
                <td></td>
                <td>
                    <button class="btn btn-primary" type="submit">{$LNG.btn_save}</button>
                </td>
            </tr>
        </table>
    </form>
{literal}
    <script>
        document.getElementById("configForm").addEventListener("submit", function (event) {
            event.preventDefault();
            sendData('configForm', "admin.php?page=configUniverse");
        });

        function sendData(formId, url) {
            const XHR = new XMLHttpRequest();

            // Bind the FormData object and the form element
            const FD = new FormData(document.getElementById(formId));

            // Define what happens on successful data submission
            XHR.addEventListener("load", function (event) {
                let response = JSON.parse(event.target.responseText);
                NotifyBox(response.message, 'success');
            });

            // Define what happens in case of error
            XHR.addEventListener("error", function (event) {
                NotifyBox('Oops! Something went wrong.', 'danger');
            });

            // Set up our request
            XHR.open("POST", url);

            // The data sent is what the user provided in the form
            XHR.send(FD);
        }
    </script>
{/literal}
{/block}