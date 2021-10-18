{block name="title" prepend}{$LNG.lm_ally_board}{/block}
{block name="content"}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{$LNG.lm_ally_board}</h3>
                    <small class="card-subtitle"><a href="?page=allianceBoard">Home</a></small>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{$LNG.ally_board_category}</th>
                            <th>{$LNG.ally_board_latest_post}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $categories as $category}
                            <tr>
                                <td><a href="game.php?page=allianceBoard&amp;subpage=category&amp;id={$category.id}">{$category.name}</td>
                                <td>{if $category.latest_post_time}
                                        <a href="game.php?page=allianceBoard&amp;subpage=thread&amp;id={$category.latest_post_thread}">{$category.creator}, {$category.latest_post_time|date_format:$LNG.php_tdformat}</a>
                                    {else}{$LNG.ally_board_never_posted}{/if}</td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {if $rights.ADMIN}
        <div class="col">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{$LNG.ally_board_create_category}</h3></div>
                <div class="card-body">
                    <form method="post">
                        <label for="id_category_name" class="form-label">{$LNG.ally_board_category}</label>
                        <input class="form-control" type="text" id="id_category_name" name="category_name" />
                        <button type="submit" class="btn btn-primary">{$LNG.ally_board_create}</button>
                    </form>
                </div>
            </div>
        </div>
        {/if}
    </div>
{/block}

