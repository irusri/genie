<?php 
$subdir_arr = explode("/", $_SERVER["REQUEST_URI"]);
$mennu_arr= explode("<br />", $c['menu']);
$menu_exist=true;

for($search_num=0;$search_num<count($mennu_arr);$search_num++){
	if(trim(strtolower($mennu_arr[$search_num]))==strtolower($subdir_arr[count($subdir_arr)-1]) || trim(strtolower($mennu_arr[$search_num]))=="-".strtolower($subdir_arr[count($subdir_arr)-1])){
		$menu_exist=true;
	}
}

if(strtolower(basename(dirname(__FILE__)))== basename($_SERVER['REDIRECT_URL']) || basename($_SERVER['REDIRECT_URL'])=="transcript" ){//&& $menu_exist==true
	$c['initialize_tool_plugin']=true;
	$c['tool_plugin']="gene";//strtolower($subdir_arr[count($subdir_arr)-1]);

} 
?>