<?php if (extension_loaded('zip')): ?>

	<h1><?php echo _w('loadTheme'); ?></h1>

	<?php if (isset($_GET['themeUpladed'])): ?>
	  <p><?php echo _w('themeUpladedText'); ?>:</p>
	  <ul>
	    <li><a href="<?php echo URL; ?>admin/editVariables"><?php echo _w('editVariables'); ?></a></li>
	    <li><a href="<?php echo URL; ?>admin/editKeywords"><?php echo _w('editManualKeywords'); ?></a></li>
	    <li><a href="<?php echo URL; ?>admin/"><?php echo _w('siteIconChangeText'); ?></a></li>
	    <li><a href="<?php echo URL; ?>"><?php echo _w('mainPage'); ?></a></li>
	  </ul>
	<?php endif; ?>

	<div class="box">
		<form action="api/loadTheme" method="post" enctype="multipart/form-data" id="themeForm">
		  <label for="zipfileform"><?php echo _w('zipfile'); ?>:</label> <input type="file" name="theme" id="zipfileform">
		  <input type="button" value="<?php echo _w('send'); ?>" onclick="ask();">
		</form>
	</div>

	<div class="box">
		<h3><?php echo _w('downloadBackup'); ?></h3>
		<input type="button" value="<?php echo _w('download'); ?>" onclick="window.location.href='<?php echo URL; ?>admin/api/downloadBackup';">
	</div>

	<script type="text/javascript">
		function ask() {
			if (document.getElementById('zipfileform').value == '')
			{
				alert('Lütfen önce bir tema seçiniz.');
			}
			else
			{
				// Do you sure changing theme? That will deletes your all data
				if (confirm("<?php echo _w('thisProcessDeleteEverythingSure'); ?>")) {
					document.getElementById('themeForm').submit();
				}
			}
		}
	</script>

<?php else: ?>

	<h3 style="color:red;"><?php echo _w('noZipExtension') ?></h3>
	<div class="box">
		<p><?php echo _w('noZipExtensionText'); ?></p>
	</div>

<?php endif; ?>
