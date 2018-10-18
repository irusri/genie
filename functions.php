<?php
/**
 * @author		Chanaka Mannapperuma <irusri@gmail.com>
 * @date		2017-03-04
 * @version		Beta 1.0
 * @usage		Main functions for GenIECMS
 * @licence		GNU GENERAL PUBLIC LICENSE
 * @link		https://geniecms.org
 */
/*Load the content based on request from index.php*/
foreach($c as $key => $val) {
	if ($key == 'content') continue;
	$fval = @file_get_contents('genie_files/'.$key);
	$d['default'][$key] = $c[$key];
	if ($fval) $c[$key] = $fval;
	//echo $key."<br>";
	switch ($key) {
		case 'password':
			if (!$fval) $c[$key] = savePassword($val);
			break;
		case 'loggedin':
			if (isset($_SESSION['l']) and $_SESSION['l'] == $c['password']) $c[$key] = true;
			if (isset($_REQUEST['logout'])) {
				session_destroy();
				header('Location: ./');
				exit;
			}
			if (isset($_REQUEST['login'])) {
				if (is_loggedin()) header('Location: ./');
				loginForm();
			}
			$lstatus = (is_loggedin()) ? "<a href='$hostname?logout'>Logout</a>" : "<a href='$hostname?login'>Login</a>";
			break;
		case 'page':
			//if ($c[$key]==""){ $c[$key]="home";}
			if ($rp) $c[$key] = $rp;
			$c[$key] = getthetitle($c[$key]);
			
			if (isset($_REQUEST['login'])) continue;
			$c['content'] = @file_get_contents("genie_files/".$c[$key]);
			if (!$c['content']) {
				if (!isset($d['page'][$c[$key]])) {
					//echo "secondary pages"."</br>";
					//echo "key=".$c[$key]."</br>";
					//echo "page=".print_r($d['page']);
					header('HTTP/1.1 404 Not Found');
					$c['content'] = (is_loggedin()) ? $d['new_page']['admin'] : $c['content'] = $d['new_page']['visitor'];
					
				} else {
					//echo "Homepage"."</br>";
					//echo "key=".$c[$key]."</br>";
					//echo "page=".print_r($d['page']);	
					$c['content'] = $d['page'][$c[$key]];
					
				}
				
			}
			break;
		default:
			break;
	}
}

/*Fire loadPlugins() function*/
loadPlugins();

/*Load the selected theme from settings menu*/
include("themes/".$c['themeSelect']."/theme.php");

/*Load plugins while traveling through plugins directory*/
function loadPlugins(){
	global $hook,$c;
	$cwd = getcwd();
	if(chdir("./plugins/")){
		$dirs = glob('*', GLOB_ONLYDIR);
		if(is_array($dirs))foreach($dirs as $dir){
			if(file_exists($cwd.'/plugins/'.$dir.'/index.php')){
			require_once($cwd.'/plugins/'.$dir.'/index.php');
			}
		}
	}
	chdir($cwd);
	$hook['admin-head'][] = "<script type='text/javascript' src='./js/editInplace.php?hook=".$hook['admin-richText']."'><script>";
	
}

/*Formulate the page titles*/
function getthetitle($p){
        $p = strip_tags($p);
        preg_match_all('/([a-z0-9A-Z-_]+)/', $p, $matches);
        $matches = array_map('strtolower', $matches[0]);
        $tmp_title = implode('-', $matches);
        return $tmp_title;
}

/*Formulate the menu titles*/
function getthetitle_for_menu($p){
        $p = strip_tags($p);
        preg_match_all('/([a-z0-9A-Z-_]+)/', $p, $matches);
        $matches = $matches[0];
        $tmp_title = implode('-', $matches);
        return $tmp_title;
}

/*Check user authentication level*/
function is_loggedin(){
        global $c;
        return $c['loggedin'];
}

function editTags(){
        global $hook;
        if(!is_loggedin() && !isset($_REQUEST['login'])) return;
        foreach($hook['admin-head'] as $o){
                echo "\t".$o."\n";
        }
}

function content($id,$content){
	global $d;
	echo (is_loggedin())? "<span title='".$d['default']['content']."' id='".$id."' class='editText richText'>".$content."</span>": $content;
}

/*Rendering the main menu*/
function genie_menu(){
        global $c,$hostname;
        $mlist = explode('<br />',$c['menu']);
        for($i=0;$i<count($mlist);$i++){
                $page = getthetitle_for_menu($mlist[$i]);
                if(!$page) continue;
                if(substr($page,0,1)!="-"){
                        $menu_items= "<li><a target='_parent' href='".$hostname.$page."'>".str_replace('-',' ',$page)."</a></li>";
                }else{
                        $page_display=str_replace("_"," ",$page);
                        $menu_items= "<ul><li><a target='_parent' href='".$hostname.str_replace('-','',$page)."'>".str_replace('-',' ',$page_display)."</a></li></ul>";
                }
                $contact_menu_items.=$menu_items;
        }
        $contact_menu_items= str_replace('</li><ul>','<ul>',$contact_menu_items);
        echo str_replace('</ul><ul>','',$contact_menu_items);
}

/*Rendering the login form*/
function loginForm(){
	global $c, $msg;
	$msg = '';
	if(isset($_POST['sub'])) login();
	$c['content'] = "<form style='font-size:16px' action='' method='POST'>
	Password <input type='password' name='password'>
	<input type='submit' name='login' value='Login'> $msg
	<br /><br /><b style='cursor:pointer' class='toggle'>Change password</b>
	<div class='hide'><br />Type your old password above and your new one below.<br /><br />
	New Password <input type='password' name='new'>
	<input type='submit' name='login' value='Change'>
	<input type='hidden' name='sub' value='sub'>
	</div>
	</form>";
}

/*Loginform functions*/
function login(){
	global $c, $msg;
	if(md5($_POST['password'])<>$c['password']){
		$msg = "Wrong Password";
		return;
	}
	if($_POST['new']){
		savePassword($_POST['new']);
		$msg = 'Password changed';
		return; 
	}
	$_SESSION['l'] = $c['password'];
	header('Location: ./');
	exit;
}

/*if the passwword file exist use md5 to save the password*/
function savePassword($p){
	$file = @fopen('genie_files/password', 'w');
	if(!$file){
		echo "Error opening password. Set correct permissions (644) to the password file.";
		exit;
	}
	fwrite($file, md5($p));
	fclose($file);
	return md5($p);
}

/*Rendering the main settings this will appear nce user logged into the genie*/
function settings(){
	global $c,$d;
	echo "<div class='settings'>
	<h3 class='toggle'>↕ Settings ↕</h3>
	<div class='hide'>
	<div class='change border'><b>Theme</b>&nbsp;<span id='themeSelect'><select name='themeSelect' onchange='fieldSave(\"themeSelect\",this.value);'>";
	if(chdir("./themes/")){
		$dirs = glob('*', GLOB_ONLYDIR);
		foreach($dirs as $val){
			$select = ($val == $c['themeSelect'])? ' selected' : ''; 
			echo '<option value="'.$val.'"'.$select.'>'.$val."</option>\n";
		}
	}
	echo "</select></span></div>
	<div class='change border'><b>Navigation <small>(hint: add your page below and <a href='javascript:location.reload(true);'>click here to refresh</a>)</small></b><br /><span id='menu' title='Home' class='editText'>".$c['menu']."</span></div>";
	foreach(array('title','description','keywords','copyright') as $key){
		echo "<div class='change border'><span title='".$d['default'][$key]."' id='".$key."' class='editText'>".$c[$key]."</span></div>";
	}
	echo "</div></div>";
}
?>