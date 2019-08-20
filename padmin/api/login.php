<?php
if (isset($_POST['mail']))
{
  // TODO: Save from bruteforce

  if ($_POST['mail'] == $settings->mail)
  {
    if (md5($_POST['password']) == $settings->password)
    {
      // User name and password is true. Go to homepage
      $_SESSION['user'] = 'admin';
      header('Location: ' . URL . 'admin/' . (isset($_POST['redirect']) ? $_POST['redirect'] : '' ));
    }
    else
    {
      // Password is wrong
      header('Location: ../login?error=wrongPassword');
    }
  }
  else
  {
    // User name is wrong
    header('Location: ../login?error=wrongMail');
  }

}
else
{
  // Came to this page without posting user data
  header('Location: ../login');
}
?>
