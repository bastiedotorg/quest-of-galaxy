{block name="title" prepend}{$LNG.lm_ally_board}{/block}
{block name="content"}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{$LNG.lm_ally_board}</h3>
                    <small class="card-subtitle"><a href="?page=allianceBoard">Home</a> / <a href="?page=allianceBoard&amp;subpage=category&amp;id={$category.id}">{$category.name}</a> / <a href="?page=allianceBoard&amp;subpage=thread&amp;id={$thread.id}">{$thread.subject}</a></small>
                </div>
                <div class="card-body">
                    {foreach $postings as $post}
                        <p class="text-muted">{sprintf($LNG.ally_board_posting_intro, $post.creator, $post.created_time|date_format:$LNG.php_tdformat)}</p>
                        <p class="">{BBCode::parse($post.content)}</p>
                    {/foreach}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{$LNG.ally_board_respond}</h3></div>
                <div class="card-body">
                    <form method="post">
                        <label for="id_thread_text" class="form-label">{$LNG.ally_board_thread_text}</label>
                        <textarea class="form-control" type="text" id="id_thread_text" name="thread_text"></textarea>
                        <button type="submit" class="btn btn-primary">{$LNG.ally_board_create}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/block}

