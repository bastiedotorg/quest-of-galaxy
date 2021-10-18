{block name="title" prepend}{$LNG.lm_ally_board}{/block}
{block name="content"}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{$LNG.lm_ally_board}</h3>
                    <small class="card-subtitle"><a href="?page=allianceBoard">Home</a> / <a href="?page=allianceBoard&amp;subpage=category&amp;id={$category.id}">{$category.name}</a></small>

                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{$LNG.ally_board_thread}</th>
                            <th>{$LNG.ally_board_creator}</th>
                            <th>{$LNG.ally_board_posted}</th>
                        </tr>
                        </thead>

                        <tbody>
                        {foreach $threads as $thread}
                            <tr>
                                <td><a href="game.php?page=allianceBoard&amp;subpage=thread&amp;id={$thread.id}">{$thread.subject}</td>
                                <td>{$thread.creator}<br /><small>{$thread.created_time|date_format:$LNG.php_tdformat}</small></td>
                                <td>{if $thread.latest_post_time}
                                        <a href="game.php?page=allianceBoard&amp;subpage=thread&amp;id={$thread.id}">{$thread.creator}<br/><small>{$thread.latest_post_time|date_format:$LNG.php_tdformat}</small></a>
                                    {else}{$LNG.ally_board_never_posted}{/if}</td>

                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{$LNG.ally_board_create_thread}</h3></div>
                <div class="card-body">
                    <form method="post">
                        <label for="id_thread_name" class="form-label">{$LNG.ally_board_thread}</label>
                        <input class="form-control" type="text" id="id_thread_name" name="thread_name" />
                        <label for="id_thread_text" class="form-label">{$LNG.ally_board_thread_text}</label>
                        <textarea class="form-control" type="text" id="id_thread_text" name="thread_text"></textarea>
                        <button type="submit" class="btn btn-primary">{$LNG.ally_board_create}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/block}
