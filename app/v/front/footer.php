
<!--弹层-->
<div id="dialog-overlay"></div>
<div class="alertBox">
    <div class="alertCon">
        <div id="ajaxCon">
            <div class="popTitle">提示</div>
            <div class="popCon">
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p class="txtC"><b id="tip">登记成功</b></p>
                <p>&nbsp;</p>
                <p class="txtC"><a href="#" class="subClose" id="closeid">关闭</a></p>

            </div>
            <div class="clearboth"></div>
        </div>
    </div>
    <div class="clearboth"></div>
</div>
<!--弹层-->

<script>

    if (typeof (tipInfo) == "undefined") {


    } else {
        $('#tip').html(tipInfo);
<?php if (isset($err) && '提交成功' == $err) : ?>
            $('#closeid').attr('href', '/coupon/index.html');
<?php endif; ?>
        //$('#closeid').attr('href', '/');
        // $('#closeid').html('进入');
        popUp(0);
        $('.alertBox').show();
    }

</script>

</body>
</html>