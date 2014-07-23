<body>
    <!--wrap-->
    <div class="wrap">
        <!--left-->
        <div class="sideBar fl">
            <div class="logo"><a href="/"><img src="/images/logo.jpg"></a></div>
            <!--角色信息-->
            <div class="sideCon">
                <div class="sideConInner">
                    <div class="sideConTit"><span class="userName"><?php echo $conf['role'][$userInfo['role']] ?></span><a class="exit" href="/login/out.html">退出</a></div>
                    <div class="line"></div>
                    <div class="sideConUserDel">
                        <?php if (in_array($userInfo['role'], array(2))) : ?>
                            <p>城市：<?php echo $conf['city'][$userInfo['city']] ?></p>
                        <?php endif; ?>
                        <!--
                                                <p>姓名：<?php echo $userInfo['name'] ?></p>
                                                <div><span class="fl">角色：</span>
                        <?php
                        if (3 == $userInfo['role']) {
                            $co = 'blue';
                        } else if (2 == $userInfo['role']) {
                            $co = 'yellow';
                        } else {
                            $co = 'green';
                        }
                        ?>
                                                    <div class="role fl"><i class="yellow"><span class="corL"></span><?php echo $conf['role'][$userInfo['role']] ?><span class="corR"></span></i></div>
                                                    <div class="clearboth"></div>
                        -->
                    </div>
                </div>
            </div>
            <!--/角色信息-->

            <div class="sideCon">
                    <div class="line"></div>
                    <div class="sideConInner">
                        <div class="sideConTit" ><b><a href="/" style=" color: #FF9000">回到首页</a></b></div>

                    </div>
                </div>
            <!--角色管理-->
            <?php if (in_array($userInfo['role'], array(-1,1))): ?>
                <div class="sideCon">
                    <div class="line"></div>
                    <div class="sideConInner">
                        <div class="sideConTit"><b>角色管理</b></div>
                        <div class="line"></div>
                        <div class="sideConIntro">
                            <?php if (in_array($userInfo['role'], array(-1))): ?>
                            <div class="sideConTit sideConTitSub"><a href="/user/add.html" class="<?php if (1 == $cd) echo 'current'; ?>"><span class="edit">创建</span></a></div>
                            <?php endif;?>
                            <div class="sideConTit sideConTitSub"><a href="/user/index.html" class="<?php if (2 == $cd) echo 'current'; ?>"><span class="check">查询</span></a></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!--/角色管理-->

            <!--前台登记-->
            <div class="sideCon">
                <div class="line"></div>
                <div class="sideConInner">
                    <div class="sideConTit"><b>前台登记</b></div>
                    <div class="line"></div>
                    <div class="sideConIntro">
                        <div class="sideConTit sideConTitSub">
                            <?php if (1 == $userInfo['role']): ?>
                                <a href="/coupon/index.html" class="<?php if (4 == $cd) echo 'current'; ?>"><span class="edit">信息查询</span></a>
                            <?php else : ?>
                                <a href="/coupon/index.html" class="<?php if (4 == $cd) echo 'current'; ?>"><span class="edit">登记查询</span></a>
                            <?php endif; ?>

                            <div id="num_view"></div>
                            <?php if (3 == $userInfo['role']): ?>
                                <script language="JavaScript">
                                    function myrefresh()
                                    {
                                        $.ajax({
                                            type: 'GET',
                                            url: "/getInfo/index.html?t=" + (Math.random() * 10000),
                                            success: function(res) {
                                                if (res.num > 0) {
                                                    $('#num_view').html(' <a href="/coupon/index/n.html"><div class="regNum" >' + res.num + '</div></a>');
                                                } else {
                                                    $('#num_view').html('');
                                                }
                                            },
                                            dataType: 'json'
                                        });
                                    }
                                    setInterval('myrefresh()', 5000); //指定1秒刷新一次
                                    myrefresh();
                                </script>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!--/前台登记-->

            <!--其他管理-->

            <div class="sideCon">
                <div class="line"></div>
                <div class="sideConInner">
                    <div class="sideConTit"><b>其他管理</b></div>
                    <div class="line"></div>
                    <div class="sideConIntro">
                        <div class="sideConTit sideConTitSub">
                            <a href="/data/index.html" class="<?php if (5 == $cd) echo 'current'; ?>"><span class="check">统计查询</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--/其他管理-->

        </div>
        <!--/left-->

