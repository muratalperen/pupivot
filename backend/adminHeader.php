<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo _w('adminPanel'); ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" href="<?php echo URL; ?>favicon.ico" type="image/x-icon" sizes="16x16 24x24 32x32"/>
		<meta name="robots" CONTENT="NOFOLLOW">

		<link rel="stylesheet" href="<?php echo URL; ?>assets/admin.css">

  </head>
  <body>
    <nav>
      <ul>
        <li><a href="<?php echo URL; ?>admin/"><?php echo _w('mainPage'); ?></a></li>
        <li><a href="<?php echo URL; ?>admin/editVariables"><?php echo _w('editVariables'); ?></a></li>
        <li><a href="<?php echo URL; ?>admin/editKeywords"><?php echo _w('editManualKeywords'); ?></a></li>
        <li><a href="<?php echo URL; ?>admin/editImages"><?php echo _w('editImages'); ?></a></li>
				<li><a href="<?php echo URL; ?>admin/loadTheme"><?php echo _w('loadTheme'); ?></a></li>
        <li><a href="<?php echo URL; ?>admin/api/logout"><?php echo _w('logout'); ?></a></li>
      </ul>
    </nav>

		<main>
