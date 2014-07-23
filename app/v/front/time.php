<!--时间显示-->
    <?php
    $weekarray=array("日","一","二","三","四","五","六");

    ?>
        <div class="currentTime txtC"><?php echo date('Y年m月d日 H:i:s')?><?php echo "星期".$weekarray[date("w")];?></div>
        <!--时间显示-->
        <div class="line"></div>
