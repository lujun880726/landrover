
<body class="bgShow">
    <div class="loginWrap">
        <!--wrapout-->
        <div class="loginWrapout">
            <!--wrapinner-->
            <div class="loginWrapinner margin_auto">
                <div class="loginHeader" align="center">
                    <h1><a href="/login/index.html">logo链接</a></h1>
                </div>
                <!--用户登录-->
                <div class="login fr" id="loginView">
                    <!--提示信息-->
                    <div class="msgBox"></div>

                    <div class="inputOuter">
                        <label class="input_tips">用户名</label>
                        <i class="ico1"></i><input type="text" value=""  class="inputstyle"  name="name" id="name"/>
                    </div>
                    <div class="inputOuter">
                        <label class="input_tips">密  码</label>
                        <i class="ico2"></i><input type="password" value="" class="inputstyle" name="psd" id="psd"/>
                    </div>
                    <!--
                                        <div class="inputOuter subInputOuter">
                                            <label class="input_tips">验证码</label>
                                            <input type="text" value="" class="inputstyle subInputstyle" name="code" id="code" /><img  id="codeImg"  height="38px" width="111px" src="/code/index.html?t=<?php echo rand(0, 99999); ?>" align="top" alt="看不清楚，换一张" onClick="create_code();">
                                        </div>
                    -->
                    <div class="txtC"><a href="#" type="button" onclick="sub()"><img src="/images/btnDl.png"></a></div>
                    <div class="clearboth"></div>
                </div>
                <!--/用户登录-->
                <div class="clearboth"></div>
            </div>
            <!--/wrapinner-->
        </div>
        <!--/wrapout-->
    </div>





    <script>

<?php if (isset($msg) && $msg) : ?>
            alert('<?= $msg ?>');
<?php endif; ?>
        function create_code() {
            $('#codeImg').attr('src', '/code/index.html?t=' + Math.random() * 10000);
        }

        function sub()
        {
            $.ajax({
                type: 'POST',
                url: "/login/login.html?t=" + (Math.random() * 10000),
                data: {name: $('#name').val(), psd: $('#psd').val(), code: $('#code').val()},
                success: function(res) {
                    if (1 == res.code) {
                        $('#tip').html(res.msg);
                        popUp(0);
                    }
                    if (2 == res.code) {
                        $('#tip').html('第一次进入请重置密码!');
                        popUp(0);
                        $('#loginView').html(res.msg);
                    }
                    if (3 == res.code) {
                        $('#tip').html(res.msg);
                        location.href = "/";
                    }
                },
                dataType: 'json'
            });
        }
    </script>
