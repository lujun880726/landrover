 <script type="text/javascript" src="/js/jquery.base.js"></script>
<!--提示信息-->
<div class="msgBox">首次登录请修改密码</div>

<div class="inputOuter inputOuter_focus">
    <label class="input_tips">旧密码</label>
    <i class="ico2"></i><input type="password" value="" class="inputstyle" id="o_psd" name="o_psd"/>
</div>
<div class="inputOuter">
    <label class="input_tips">新密码</label>
    <i class="ico2"></i><input type="password" value="" class="inputstyle" id="n_psd1" name="n_psd1"/>
</div>
<div class="inputOuter">
    <label class="input_tips">确认密码</label>
    <i class="ico3"></i><input type="password" value="" class="inputstyle"  name="n_psd2" id="n_psd2"/>
</div>

<div class="txtC"><a href="#" onclick="repsd()"><img src="/images/btnDl.png"></a></div>

<div class="clearboth"></div>
<script>
    function repsd()
    {
        $.ajax({
            type: 'POST',
            url: "/psd/index.html?t=" + (Math.random() * 10000),
            data: {o_psd: $('#o_psd').val(), n_psd1: $('#n_psd1').val(), n_psd2: $('#n_psd2').val()},
            success: function(res) {
                if (1 == res.code) {
                    $('#tip').html(res.msg);
                    popUp(0);
                }
                if (3 == res.code) {
                    $('#tip').html(res.msg);
                    $('#closeid').attr('href', '/');
                    $('#closeid').html('进入');
                    popUp(0);
                }
                //
            },
            dataType: 'json'
        });
    }
</script>