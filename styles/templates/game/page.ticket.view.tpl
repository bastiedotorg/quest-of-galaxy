{block name="title" prepend}{$LNG.ti_read} - {$LNG.lm_support}{/block}
{block name="content"}
    <form action="game.php?page=ticket&mode=send" method="post" id="form">
        <input type="hidden" name="id" value="{$ticketID}">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{$LNG.ti_header}</h2>
                </div>
                <div class="card-body">

                    <table class="table519">
                        {foreach $answerList as $answerID => $answerRow}
                            {if $answerRow@first}
                                <tr>
                                    <th colspan="2">{$LNG.ti_read} :: {$answerRow.subject}</th>
                                </tr>
                            {/if}
                            <tr>
                                <td class="left" colspan="2">
                                    {$LNG.ti_msgtime} <b>{$answerRow.time}</b> {$LNG.ti_from}
                                    <b>{$answerRow.ownerName}</b>
                                    {if $answerRow@first}
                                        <br>
                                        {$LNG.ti_category}: {$categoryList[$answerRow.categoryID]}
                                    {/if}
                                    <hr>
                                    <p>
                                        {$answerRow.message}
                                    </p>
                                </td>
                            </tr>
                        {/foreach}
                        {if $status < 2}
                            <tr>
                                <th colspan="2">{$LNG.ti_answer}</th>
                            </tr>
                            <tr>
                                <td><label class="form-label" for="message">{$LNG.ti_message}</label></td>
                                <td><textarea class="form-control validate[required]" id="message" name="message"
                                                                rows="60" cols="8" style="height:100px;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="submit" value="{$LNG.ti_submit}"></td>
                            </tr>
                        {/if}
                    </table>
                </div>
            </div>
        </div>
    </form>
{/block}
{block name="script" append}
    <script>
        $(document).ready(function () {
            $("#form").validationEngine('attach');
        });
    </script>
{/block}