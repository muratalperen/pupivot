<?php
if (isset($_FILES['icon']))
{
  // Upload website main icon named as favicon.ico on root directory

  // If there is an error
  if ($_FILES['icon']['error'] > 0)
  {
    redirectTo('?result=false');
    // die($_FILES['icon']['error']);
  }

  if (move_uploaded_file($_FILES['icon']['tmp_name'], DIR . 'favicon.ico'))
  {
    redirectTo('?result=true');
  }
  else
  {
    redirectTo('?result=false');
  }


}
else
{
  // No file sent. Go to main page
  redirectTo('');
}

?>
