<h1><?php echo _w('general'); ?></h1>

<div class="box">
	<h3><?php echo _w('siteIconChangeText'); ?></h3>
	<form action="<?php echo URL; ?>admin/api/changeIcon" method="post" enctype="multipart/form-data">
  	<input type="file" name="icon">
  	<input type="submit" value="<?php echo _w('send'); ?>">
	</form>
	<small><?php echo _w('selectIconIcoType'); ?></small>
</div>


<div class="box">
  <?php echo _w('crawlingEnableText') ?>
  <input type="checkbox" onchange="changeCrawl(this);" <?php echo ($settings->enableCrawl) ? 'checked="checked"' : '' ; ?>>
</div>


<div class="box">
  <?php echo _w('language'); ?>
  <select onchange="changeLanguage(this);">
    <?php
    // List all language files
    if ($dizin = opendir(DIR . 'backend/languages/'))
    {
  		while (false !== ($dosya = readdir($dizin)))
      {
  			if ($dosya != '.' && $dosya != '..')
        {
          $dosya = substr($dosya, 0, (strlen($dosya) - 4));
  				echo '<option value="' . $dosya . '" ' . (($dosya == $settings->language) ? 'selected' : '') . '>' . $dosya . '</option>';
  			}
  		}
  	}
    ?>
  </select>
	<small><?php echo _w('languageForDefaultAndAdmin'); ?></small>
</div>

<script src="<?php echo URL; ?>assets/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript">
  function changeLanguage(obj) {
    obj.disable="disable";

    $.post("<?php echo URL; ?>admin/api/changeLang", {lang: obj.value}, function (cevap, stat){
			if(cevap == null || cevap == "" || stat != "success"){
        alert("<?php echo _w('procError') ?>");
      }else if (cevap[0] == "1") { // DEBUG: file_put_contents returns 101?
				window.location.reload();
      }else{
        alert("<?php echo _w('procError') ?>: \n\n" + cevap);
      }
	  });
  }

  function changeCrawl(obj) {
    obj.disable="disable";

		$.post("<?php echo URL; ?>admin/api/changeCrawl", {}, function (cevap, stat){
			if(cevap == null || cevap == "" || stat != "success"){
				alert("<?php echo _w('procError') ?>");
			}else if (cevap == "1") {
				window.location.reload();
			}else{
				alert("<?php echo _w('procError') ?>: \n\n" + cevap);
			}
			obj.removeAttribute('disable');
	  });
  }
</script>
