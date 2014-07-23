
function popUp(x) {
    var maskWidth = $(window).width();
    var maskHeight = $(document).height();
    var innerHeight = $(".alertBox").innerHeight();
    var innerWidth = $(".alertBox").innerWidth();

    var parentHeight = $(window.parent).height();
    var parentScrollTop = $(window.parent).scrollTop();

    var topHeight = (parentHeight - innerHeight) / 2 + parentScrollTop;
    var leftWidth = (maskWidth - innerWidth) / 2;

    $(".alertBox").hide();
    $("#dialog-overlay").css({height: maskHeight, width: maskWidth}).show()
    $("#alertBox_" + x).show();
}

/*!代码调用*/

jQuery(document).ready(function() {

    //login输入框 提示文字 显示/隐藏
    $(".inputstyle").each(function(i) {
        if ($(".inputstyle").eq(i).val() == "") {
            $(".inputOuter").eq(i).find("label").show();
        } else {
            $(".inputOuter").eq(i).find("label").hide();
        }
    })

    $(":input").focus(function(){
			$(".inputOuter").removeClass("inputOuter_focus")
			$(this).parent().addClass("inputOuter_focus");
			
			$(this).parent().find("label").hide();
			
	  }).blur(function(){
		  	$(".inputOuter").removeClass("inputOuter_focus")
			
			if($(this).val() ==""){
				$(this).parent().find("label").show();
			}else {
				$(this).parent().find("label").hide();
			}
	  });


    /*弹层*/
    $(".alertBox").each(function(i) {
        $(this).attr("id", "alertBox_" + i)
    });

    $(".close,.subClose").click(function() {
        tmphref = $(this).attr('href');
        if ('#' != tmphref || '' != tmphref) {
            location.href = tmphref;
        }
        $(".alertBox").hide();
        $("#dialog-overlay").hide()
        return false;
    });



});