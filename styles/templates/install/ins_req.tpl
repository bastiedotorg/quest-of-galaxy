{include file="ins_header.tpl"}

<div class="card">
    <div class="card-header">
        <h2>{$LNG.req_head}</h2>
    </div>
    <div class="card-body">
        <p class="card-text">{$LNG.req_desc}</p>

        <table class="table table-striped">
            <tr>
                <td class="transparent left"><p>{$LNG.req_php_need}</p>
                    <p class="desc">{$LNG.req_php_need_desc}</p></td>
                <td class="transparent">{$PHP}</td>
            </tr>
            <tr>
                <td class="transparent left"><p>{$LNG.reg_global_need}</p>
                    <p class="desc">{$LNG.reg_global_desc}</p></td>
                <td class="transparent">
                {$global}</th>
            </tr>
            <tr>
                <td class="transparent left"><p>{$LNG.reg_pdo_active}</p>
                    <p class="desc">{$LNG.reg_pdo_desc}</p></td>
                <td class="transparent">
                {$pdo}</th>
            </tr>
            <tr>
                <td class="transparent left"><p>{$LNG.reg_gd_need}</p>
                    <p class="desc">{$LNG.reg_gd_desc}</p></td>
                <td class="transparent">{$gdlib}</td>
            </tr>
            <tr>
                <td class="transparent left"><p>{$LNG.reg_json_need}</p></td>
                <td class="transparent">{$json}</td>
            </tr>
            <tr>
                <td class="transparent left"><p>{$LNG.reg_iniset_need}</p></td>
                <td class="transparent">{$iniset}</td>
            </tr>
            {$dir}
            {$config}
        </table>

        {if $ftp != 0}
            <h3>{$LNG.req_ftp_head}</h3>
            <form name="ftp" id="ftp" action="" onsubmit="return false;">
                <table class="table table-striped">
                    <tr>
                        <td class="transparent left" colspan="2">
                            <p>{$LNG.req_ftp_desc}</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="transparent left">{$LNG.req_ftp_host}:</td>
                        <td class="transparent"><input type="text" name="host"></td>
                    </tr>
                    <tr>
                        <td class="transparent left">{$LNG.req_ftp_username}:</td>
                        <td class="transparent"><input type="text" name="user"></td>
                    </tr>
                    <tr>
                        <td class="transparent left">{$LNG.req_ftp_password}:</td>
                        <td class="transparent"><input type="password" name="pass"></td>
                    </tr>
                    <tr>
                        <td class="transparent left">{$LNG.req_ftp_dir}:</td>
                        <td class="transparent"><input type="text" name="path"></td>
                    </tr>
                </table>
                <span class="float-right"><input type="button" class="btn btn-success" value="{$LNG.req_ftp_send}"
                                                 onclick="submitftp();"></span>

            </form>
        {/if}

    </div>
    <div class="card-footer">
        <a class="btn btn-primary float-end" href="index.php?mode=install&amp;step=3">{$LNG.continue}</a>
    </div>
</div>


{include file="ins_footer.tpl"}