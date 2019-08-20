<?php
// Upload Image
if (isset($_FILES['image']))
{

  // If there is an error
  if ($_FILES['image']['error'] > 0)
  {
    redirectTo('editImages?result=false');
  }

	// It should be image
	if (substr($_FILES['image']['type'], 0, 5) !== 'image')
	{
		redirectTo('editImages?result=shouldBeImageYouUploaded');
	}

	// Files should have same extension
	if (substr($_FILES['image']['name'], -3) !== substr($_POST['name'], -3) )
	{
		redirectTo('editImages?result=shouldBeSameExtension');
	}

  if (move_uploaded_file($_FILES['image']['tmp_name'], DIR . 'theme/assets/img/' . $_POST['name']))
  {
    redirectTo('editImages?result=true&changedImage=' . $_POST['name']);
  }
  else
  {
    redirectTo('editImages?result=false');
  }


}
else
{
  // No file sent. Go to editImages page
  redirectTo('editImages');
}

?>
