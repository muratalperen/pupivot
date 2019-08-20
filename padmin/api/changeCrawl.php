<?php

$settings->enableCrawl = ! $settings->enableCrawl;

echo file_put_contents(DIR . 'backend/settings.json', json_encode($settings));
?>
