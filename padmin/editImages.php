<h1><?php echo _w('editImages'); ?></h1>

<style media="screen">
.imageCard{
	background-color: #fff;
	border: 1px solid #ccc;
	display: inline-block;
	text-align: center;
	padding: 20px;
	margin: 10px;
}
.imageCard > img{
	min-width: 100px;
	max-width: 300px;
}
.imageCard > form{
	margin-top: 10px;
}

</style>

<div class="box">
	<p><?php echo _w('editImagePageText'); ?></p>
	<br>
	<?php
	const IMGDIRSTRLEN = 17; // strlen('theme/assets/img')
	// IDEA: Can look at all theme folder. So Everybody can put images everywhere
	// TODO: Sort by alphabet
	$images = new RecursiveIteratorIterator(
	 new RecursiveDirectoryIterator(DIR . 'theme/assets/img/'), RecursiveIteratorIterator::SELF_FIRST
	);

	foreach($images as $imageDir):
		if (substr($imageDir, -1) === '.') continue;
		$imageDir = substr($imageDir, strlen(DIR)); // Cuts DIR

		// If image changed, try to save from damn of cache
		$imageLink = URL . ( isset($_GET['changedImage']) ? ( ($_GET['changedImage'] == substr($imageDir, IMGDIRSTRLEN)) ? $imageDir . '?updated=updated' : $imageDir ) : $imageDir ) ;
		?>

		<div class="imageCard">
			<p><?php echo substr($imageDir, IMGDIRSTRLEN); ?></p>
			<img src="<?php echo URL; ?>assets/img/holder.svg" beSrc="<?php echo $imageLink; ?>" onmouseover="if(this.src !== this.getAttribute('beSrc')){this.src = this.getAttribute('beSrc');}">
			<form action="<?php echo URL; ?>admin/api/editImage" method="post" enctype="multipart/form-data">
				<input type="hidden" name="name" value="<?php echo substr($imageDir, IMGDIRSTRLEN); ?>">
				<input type="file" name="image" required>
				<input type="submit" value="<?php echo _w('send'); ?>">
			</form>
		</div>

	<?php endforeach;	?>
</div>
