<?php include ROOT_V_R . 'left.php' ?>
<!--right-->
<div class="content">
    <?php include ROOT_V_R . 'time.php' ?>
    <!--主要内容-->
    <div class="mainCon">
        <!--所在位置-->
        <div class="where"><a href="/"><span>主页</span></a> >  <span>角色管理</span> > <span>角色查询</span></div>
        <!--角色查询-->
        <div class="mainConBase">
            <h1>角色查询</h1>
            <div class="mainConBaseInner">
                <div class="search">
                    <dl class="mainConInputStyle">
                        <form class="form-signin" role="form" action=""  method="post">
                            <dd><span>用户名</span><input type="text" name="uname" value="<?php echo $uname; ?>"><input type="submit" class="btnFuc"  value="搜索"></dd>
                        </form>
                        <?php if (in_array($userInfo['role'], array(-1))) : ?>
                            <dd><span>&nbsp;</span><A href="/user/add.html"><input type="button" class="btnFucAdd" value="新增用户"></A></dd>
                        <?php endif; ?>
                    </dl>
                </div>
                <!--查询结果-->
                <table class="resault" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
                    <thead>
                        <tr>
                            <td width="15%">用户名</td>
                            <td width="13%">姓名</td>
                            <td width="20%">Email</td>
                            <td width="10%">角色</td>
                            <td width="12%">城市</td>
                            <td width="12%">电话</td>
                            <td width="30%">操作</td>
                        </tr>
                    </thead>
                    <?php if ($list) : ?>
                        <?php foreach ($list as $key => $val) : ?>
                            <tr>
                                <td><?php echo $val['uname'] ?></td>
                                <td><?php echo $val['name'] ?></td>
                                <td><?php echo $val['email'] ?></td>
                                <td><?php echo $conf['role'][$val['role']] ?></td>
                                <td><?php echo $conf['city'][$val['city']] ?></td>
                                <td><?php echo $val['phone']?></td>
                                <td>
                                    <a href="/user/add/m_<?php echo $val['uid'] ?>.html" class="current hasLine" >修改</a>
                                    <a href="#" class="hasLine" onclick="if (window.confirm('你确定要重置此账号密码吗？')) {
                                                    rpsd('<?php echo $val['uid']; ?>');
                                                }">重置密码</a>
<?php if (in_array($userInfo['role'], array(-1))) : ?>
                                    <a href="#" onclick="if (window.confirm('你确定要删除此账号吗？')) {
                                                    d('<?php echo $val['uid']; ?>');
                                                }">删除</a>
<?php endif;?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td>没有数据</td>
                        </tr>
                    <?php endif; ?>
                </table>
                <?php echo (pageHtml('/user/index/', $page, $cnt)); ?>
                <!--翻页-->
                <!--                    <div class="page_turn page_turnSpe txtC">
                                        <a href="#" class="pre"><</a>
                                        <a href="#">1</a>
                                        <a href="#" class="current">2</a>
                                        ..
                                        <a href="#">3</a>
                                        <a href="#">4</a>
                                        <a href="#" class="next">></a>
                                    </div>-->
                <!--/翻页-->
                <!--/查询结果-->
            </div>
        </div>
        <!--/角色查询-->
    </div>
    <!--/主要内容-->
</div>
<!--/right-->
</div>
<!--/wrap-->


<script>
    function d(id_)
    {
        $.ajax({
            type: 'POST',
            url: "/user/del.html",
            data: {id: id_},
            success: function(res) {
                $('#tip').html(res.msg);
                $('#closeid').attr('href', location.href);
                popUp(0);
            },
            dataType: 'json'
        });
    }

    function rpsd(id_)
    {
        $.ajax({
            type: 'POST',
            url: "/user/rePsd.html",
            data: {id: id_},
            success: function(res) {
                $('#tip').html(res.msg);
                $('#closeid').attr('href', location.href);
                popUp(0);
            },
            dataType: 'json'
        });
    }


</script>
