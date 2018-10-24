find_dump_file();

var myVar = setInterval(find_dump_file, 5000);

function myStopFunction() {
    clearInterval(myVar);
}

function find_dump_file(){
    if(getCookie("genie_key") != undefined) {
        var key=getCookie("genie_key");
    }
    var finalvarx= "key="+key;
	$.ajax({
		type: "POST",
		url: "http://build.plantgenie.org/service/check_file.php",
        data: (finalvarx),
        dataType: 'json',   
		complete: function (data) {
            if(data.responseText==""){ 
            }else{
                download_file(key,data.responseText);
                clearInterval(myVar);
                
            }
           
		}
	});
}

function download_file(key,file_name){
    console.log("download",key,file_name);
    var finalvarx= "key="+key+"&file_name="+file_name;
	$.ajax({
		type: "POST",
		url: "plugins/admin/service/index.php",
        data: (finalvarx),
        dataType: 'json',   
		complete: function (data) {
           
		}
	});

}
