<?php $tmp_key=uniqid();
setcookie('genie_key', $tmp_key);?>
<iframe id="build_frame" width="100%" height="900px"  frameborder="0" src="http://build.plantgenie.org/test.php?key=<?php echo $tmp_key;?>">
</iframe>
<span id="demo"></span>
<script src="plugins/admin/js/init.js" type="application/javascript"></script>