<?php

$method = getenv('PLUGIN_METHOD');
$body = getenv('PLUGIN_BODY');
$url = getenv('PLUGIN_URL');
$debug = getenv('PLUGIN_DEBUG');

$ch = curl_init();

if (isset($debug) and $debug === "true") {
  echo "URL: " . $url . "\n";
  echo "METHOD: " . $method . "\n";
  echo "BODY: " . $body . "\n";
}

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
if ($method === "post") {
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
}

$output = curl_exec($ch);
curl_close($ch);
echo $output;
