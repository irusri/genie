<!doctype html>
<html lang="en"> 
   <head>
      <?php
         echo "<meta charset='utf-8'>
         <title>".$c['title']." : ".($c['page'])."</title>
         <base href='$hostname'>
         <link rel='stylesheet' href='themes/".$c['themeSelect']."/css/style.css'>
          <link rel='stylesheet' href='themes/".$c['themeSelect']."/css/hint.min.css'>
          <link rel='stylesheet' href='https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css'>
         <script src='js/jquery.min.js'></script>
         <script type='text/javascript' src='js/jquery-ui.js'></script>
         <script src='js/print.js'></script> 
         <script src='https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js'></script>
		 <link rel='shortcut icon' type='image/x-icon' href='/fav.ico'/>
		 <meta name='author' content='Chanaka Mannapperuma'>
         <meta name='description' content='".$c['description']."'>
         <meta name='keywords' content='".$c['keywords']."'>";
         
         editTags();
         ?>
      <script type="application/javascript">
         var fp4 = new Fingerprint({screen_resolution: true,ie_activex: true,canvas: true});
         setCookie('fingerprint',fp4.get().toString(),7);
      </script>
      <script src="js/bootstrap.min.js"></script>
   </head>
   <body>
      <div id="body_main_div" style="width:100%;">
         <div class="loader-wrap">
            <div class="spinner">
               <div class="bounce1"></div>
               <div class="bounce2"></div>
               <div class="bounce3"></div>
            </div>
         </div>
         <header>
            <img id="logo_img" style="margin-left:8%;padding-top:14px;cursor:pointer;background-color:#FFF;padding-left:4px;;padding-right:4px;opacity:0.9"
            onClick="location.href='<?php echo $c['hostname']?>';" src="themes/<?php echo $c['themeSelect']?>/images/logo.png"/>
<?php  if(is_dir('plugins/autocomplete')==true){  include_once("plugins/autocomplete/autocompletesearch2.php");}?> 
         </header>
         <div id="bg_content" style="width:86%;margin-left: 8%;margin-right: 6%;background-color:#FFF;background:#FFF;">
                     <nav id="mainNav">
               <select class="select-style" style="opacity: 0;" id="genie_species_select" disabled="true">
                  <?php global $db_species_color_array;global $db_species_array;foreach($db_species_array as $k => $v) { ?>
                  <option value="<?php print $k ?>"><?php print ucfirst($v) ?></option>
                  <?php } ?>
               </select>
               <?php echo '<ul class="egmenu">';genie_menu();echo '</ul>';?>
            </nav>

         <?php if(is_loggedin()) {settings();}?>
         <div class="clear"></div>
         <?php
            if( $c['initialize_tool_plugin']==1){
            echo " <div id='plugin_wrapper'  class='plborder'>";
            include_once("plugins/".$c['tool_plugin']."/tool.php");
            echo "</div>";
            }else{?>
         <div id="wrapper" class="border">
         <?php if($_SERVER["REQUEST_URI"] =="/"){?>
         	<!--ADD FRONT PAGE CONTENT HERE-->
        <?php } ?>   
            <?php if(is_loggedin()) {   ?>
              <!--  <br><br> <button class="database_accordion">↕Create a Database↕</button>
               <div class="create_database_panel">
               <?php include_once("plugins/admin/tool1.php");?>
               </div>
               <br><br> -->
<?php 
$tmp_key=uniqid();
setcookie('genie_key', $tmp_key);?>
               <br><br> <button class="database_accordion">↕Create a Database↕</button>
               <div class="create_database_panel">
               <iframe id="build_frame" width="100%" height="900px"  frameborder="0" src="//build.plantgenie.org/test.php?key=<?php echo $tmp_key;?>"></iframe>
               
               <script src="plugins/admin/js/init.js" type="application/javascript"></script>
<div id="post_information" style="display:none">
You can access the database in using <a target="_blank" href="http://localhost/phpmyadmin">phpMyAdmin</a><br>
<pre>
username: admin
password: mypass
</pre>
You have successfully installed the GenIE-CMS and <span id='db_name_1'>eucgenie_egrandis_v2_new</span> database into personal docker container. Now you need to add following database details into plugins/settings.php file.

<pre>
$db_species_array=array("<span id='db_name_2'>eucgenie_egrandis_v2_new</span>"=>"<span id='species_name'>eucgenie_egrandis_v2_new</span>");
$GLOBALS['db_url']=  array ('genelist'=>'mysqli://admin:mypass@localhost/'.$selected_database);
$GLOBALS["base_url"]='http://localhost';
</pre>
Further customisation please go to CMS documentation <a target="_blank" href="https://geniecms.readthedocs.io/en/latest">https://geniecms.readthedocs.io/en/latest/</a>
</div>
</div> <br><br>  
            <textarea class="ckeditor" name="editor"><?php content($c['page'],$c['content']);?></textarea>
            <script type="text/javascript">
               var key = <?php echo json_encode($c['page']); ?>
            </script>
            <button id="btn_submit" onclick="save(key);">save</button>
            <?php include('msg_box.php'); ?>
            <?php }else{ ?>
            <?php content($c['page'],$c['content']);?>
            <?php } ?>
         </div>
        <!-- <div id="side" class="border">
            <?php content('subside',$c['subside']);?>
         </div>-->
         <?php }?>
         <div style="height:100%" class="clear"></div>
         <div class="push"></div>
         <!--<div class="clear"></div>
            <?php if(is_loggedin()) settings();?>-->
       <!--  <a id="myAnchor" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true">TEST</a>-->
         <span id="deletebasket"  style="float:right;right:0px;bottom:0px;width:0px;height:0px;position:relative"></span>
         <div id="myModal" class="modal fade">
            <div class="modal-dialog">
               <div class="modal-content">
               </div>
            </div>
         </div>
         <script type="text/javascript">
            var color_array=<?php print json_encode($db_species_color_array)?>;
         </script>
<iframe frameborder="0" height="0" scrolling="no" src="//v22.popgenie.org/demo/service.php?id=new" width="0"></iframe>
     <script type="text/javascript" src="js/onload_script.js"></script>
         <footer id="site_footer" style="width:100%" ><?php echo $c['copyright'] ." | $sig | $lstatus";?></footer>
	   </div></div></br></br>
      <?php if(is_dir('plugins/sidebar')==true){include_once("plugins/sidebar/sidebar.php");}?>
<a id="genelistlink" href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true"><font  style="color:#00F;display:none" >here</font></a> 
   </body>
</html>
