$(document).ready(function(){

    $.ajaxSetup({ cache: false });

    $("#m").keydown(function(e){
        if (e.keyCode == 13) {
            refresh();
        }
    });
    
    $("#s").click(function(){
        refresh();
    });

    function refresh() {
        $("#s").attr("value","...");
        
        var o = $("#c").attr("o");
        if (!o) { o = ''; }
        
        var data;
        if ($("#n").val() == "" || $("#m").val() == "") {
            data = {"o":o};
        } else {
            data = {"a":"i","n":$("#n").val(),"m":$("#m").val(),"o":o};
            $("#m").val("");
        }

        $.getJSON("json.php",data,function(json) {
            $("#c").attr("o",json.offset);
            for (var i in json.msgs) {
                var msg = json.msgs[i]['n'] + ": " + json.msgs[i]['m'] + "<br>";
                $("#c").append(msg);
            }
            $("#c")[0].scrollTop = $("#c")[0].scrollHeight;
            $("#s").attr("value","~");
        });
        
    }

    refresh();
});

