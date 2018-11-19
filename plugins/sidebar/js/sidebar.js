$(document).ready(function() {
   
    var init_position = "left-center";

    if (getCookie("sidebarclass") != null) {
        init_position = getCookie("sidebarclass");
        //console.log(init_position)
    }

    $("#nav").genieMenu({
        delay: 20,
        position: init_position
    });
    var notificationBubble = document.getElementById("geniemenu-controller-0");
    var node = document.createElement("span");
    node.innerHTML = '<a   onclick="open_samplelist();" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)"  data-refresh="true"><FONT color="#FFFFFF" class="hint--right hint--success" aria-label="Click here to open GeneList"><span style="position:relative"  id="numberofgenesSpan"  style="opacity: 1;">00</span></FONT></a>';
    ///node = document.getElementById("bbb");
    //var node = document.createElement("span");
    node.setAttribute("class", "notificationcount");
    node.setAttribute("id", "mainspan");
    notificationBubble.appendChild(node);

    $("#geniemenu-controller-0").click(function() {
        //$.noConflict(removeAll)

        if ($.fn.genieMenu.toggleMenu("#nav") != undefined) {
            return false
        }

        if ($(".geniemenu-controller").hasClass("open") == true) {
            adjustPadding();
            $("#editpanel").show()
            updategenebasket3();
            $("#content").load("plugins/genelist/crud/listbarang.php");
            //	console.log($("#genenumber")[0].)
            //	console.log($("#mainspan")[0])
            $("#mainspan").hide();
            $("#notificationcount_2")[0].innerHTML = $("#numberofgenesSpan")[0].innerHTML;

            //	console.log(tmp_new_x,tmp_new_y)
            setCookie("open_side_menu", "open", 10)
        } else {
            $("#editpanel").hide()
            $("#mainspan").delay(200).show(200);
            setCookie("open_side_menu", "close", 10)
        }
    });

    //var testme=document.getElementById("geniemenu-controller-0");
    if (getCookie("open_side_menu") == undefined || getCookie("open_side_menu") == "open") {
        updategenebasket3();
        //console.log($("#numberofgenesSpan")[0].innerHTML)
        //=$("#numberofgenesSpan")[0].innerHTML;
        $.fn.genieMenu.toggleMenu("#nav");
        $("#editpanel").delay(6).show(6);
        $("#mainspan").delay(0).hide(0);
    }

});

//document.getElementById("analysis_tools").addEventListener("click",function(e){console.log(e)},false);
$("#analysis_tools").mouseover(function(e) {
    $("#genelistli").hide()
    $("#editpanel2").hide()
    $("#editpanel3").show()

});
$("#genenumber").mouseover(function(e) {
    $("#genelistli").show()
    $("#editpanel2").hide()
    $("#editpanel3").hide()

});

$("#expression_tools").mouseover(function(e) {
    $("#genelistli").hide()
    $("#editpanel2").show()
    $("#editpanel3").hide()

});

function adjustPadding() {
    var u = document.getElementById("geniemenu-controller-0").className.split(" ")[2].split("-")[0]
    if (u == "right") {
        $("#editpanel").css({
            Right: "120px",
            Left: "10px"
        });
        $("#editpanel2").css({
            Right: "120px",
            Left: "10px"
        })
        $("#editpanel3").css({
            Right: "120px",
            Left: "10px"
        })
    } else {
        $("#editpanel").css({
            Right: "10px",
            Left: "120px"
        });
        $("#editpanel2").css({
            Right: "10px",
            Left: "120px"
        });
        $("#editpanel3").css({
            Right: "10px",
            Left: "120px"
        });
    }
}