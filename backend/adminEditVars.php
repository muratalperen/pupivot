<?php
if ( ! isset($editWhich))
  redirect('editKeywords');

if (isset($_GET['lan']))
	if ( ! preg_match('/^[A-Za-z]+$/', $_GET['lan'])) // Language names has only alphabet
		redirect('editKeywords');

$languageNowFolder = (isset($_GET['lan']) ? $_GET['lan'] : $settings->language);
$jsonName = ($editWhich == 'K') ? 'content' : 'variables';
$jsonDataDirectory = DIR . 'theme/backend/data/' . $languageNowFolder . '/' . $jsonName . '.json';

if ( ! file_exists(DIR . 'backend/languages/' . $languageNowFolder . '.php')) { // If there are no data file
	header('Location: ' . URL . substr($uriPath->uri, -strlen($_GET['lan'])));
	exit();
}

// Get data
if (file_exists($jsonDataDirectory))
{
	$table = json_decode(file_get_contents($jsonDataDirectory));
	$languageCopiedFromAnother = FALSE;
}
else
{
	$languageCopiedFromAnother = TRUE;
	if (file_exists(DIR . 'theme/backend/data/' . $settings->language . '/' . $jsonName . '.json')) // If main language exists
	{
		// Copy from that
		$table = json_decode(file_get_contents(DIR . 'theme/backend/data/' . $settings->language . '/' . (($editWhich == 'K') ? 'content' : 'variables') . '.json'));
	}
	else
	{
		// Get one of exist language package
    if ($dizin = opendir(DIR . 'theme/backend/data/'))
    {
  		while (false !== ($langDirName = readdir($dizin)))
      {
  			if ($langDirName[0] != '.' && is_dir(DIR . 'theme/backend/data/' . $langDirName))
        {
          if (file_exists(DIR . 'theme/backend/data/' . $langDirName . '/' . $jsonName . '.json')) {
          	$table = json_decode(file_get_contents(DIR . 'theme/backend/data/' . $langDirName . '/' . $jsonName . '.json'));
						break;
          }
  			}
  		}

			if ( ! isset($table)) // There are no language package in theme
			{
				$table = array();
				echo _w('noLangPackInTheme');
			}
  	}
	}
}

?>

<h1><?php echo _w(($editWhich == 'K') ? 'editManualKeywords' : 'editVariables'); ?></h1>

<div class="box">
	<?php echo ((( ! is_null($table)) && $languageCopiedFromAnother) ? '<p>' . _w('langCopiedFromAnother') . '</p>' : ''); ?>
	<form action="<?php echo URL; ?>admin/api/editVars?type=<?php echo (($editWhich == 'K') ? 'k' : 'v') . '&amp;lang=' . $languageNowFolder; ?>" method="post">
	  <table id="dataTable" style="width: 100%;">
	    <?php foreach ($table as $key => $value): ?>
	      <tr id="<?php echo $key ?>-col">
	        <td><?php echo $key; ?></td>
	        <td><input type="text" name="<?php echo $key ?>" value="<?php echo htmlspecialchars($value); ?>" style="width:90%;"></td>
					<?php if ($editWhich != 'K'): ?>
						<td><input type="button" value="<?php echo _w('delete'); ?>" onclick="del('<?php echo $key; ?>')"></td>
					<?php endif; ?>
	      </tr>
	    <?php endforeach; ?>
	  </table>

	  <input type="submit" value="<?php echo _w('send'); ?>">
	</form>

	<?php if ($editWhich != 'K'): ?>
		<div>
		  <h3><?php echo _w('add'); ?></h3>
		  <input type="text" placeholder="<?php echo _w('keyword'); ?>">
		  <input type="text" placeholder="<?php echo _w('value'); ?>">
		  <input type="button" onclick="add(this.parentNode);" value="<?php echo _w('add'); ?>">
		</div>
	<?php endif; ?>

</div>

<div class="box">
	<h3><?php echo _w('editOtherLang'); ?></h3>
	<select onchange="goLang(this.value);">
		<?php
		// List all language files
		if ($dizin = opendir(DIR . 'backend/languages/'))
		{
			while (false !== ($dosya = readdir($dizin)))
			{
				if ($dosya != '.' && $dosya != '..')
				{
					$dosya = substr($dosya, 0, (strlen($dosya) - 4));
					echo '<option value="' . $dosya . '" ' . (($languageNowFolder == $dosya) ? 'selected' : '') . '>' . $dosya . '</option>';
				}
			}
		}
		?>
	</select>
</div>

<script type="text/javascript">
  function del(keyname) {
    document.getElementById(keyname + '-col').remove();
  }

  function add(elem) {
    var key = elem.getElementsByTagName('input')[0].value;
    var word = elem.getElementsByTagName('input')[1].value;



		if (elem.getElementsByTagName('input')[0].value.match(/^[A-Za-z]+$/)) { // Regexp check is alphabet
			elem.getElementsByTagName('input')[0].value = '';
      elem.getElementsByTagName('input')[1].value = '';

      document.getElementById('dataTable').innerHTML += '\
      <tr id="' + key + '-col">\
        <td>' + key + '&nbsp;</td>\
        <td><input type="text" name="' + key + '" value="' + word + '" style="width:90%;"></td>\
        <td><input type="button" value="<?php echo _w('delete'); ?>" onclick="del(\'' + key + '\')"></td>\
      </tr>\
      ';
		}
    else
    {
      alert("<?php echo _w('useOnlyAlphabet') ?>");
    }
  }

	function goLang(lan) {
		window.location.href = "<?php echo URL . 'admin/' . (($editWhich == 'K') ? 'editKeywords' : 'editVariables'); ?>?lan=" + lan;
	}
</script>
