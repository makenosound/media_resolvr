<?php
  
  # Setup extra params
  $params = array(
    'skin'      => 'api',
  );
  
  # Encode them to be safe
  $encoded_params = array();
  foreach ($params as $k => $v){
  	$encoded_params[] = urlencode($k).'='.urlencode($v);
  }
  
  # Construct the URI request
  $url = "$url?".implode('&', $encoded_params);
  
  # Load XML from blip.tv
  $dom = new DOMDocument();
  $dom->load($url);
  if ( ! $dom) {
    header("HTTP/1.0 404 Not Found");
  }
  $xml = simplexml_import_dom($dom);
  $embed_url = (string) $xml->payload[0]->asset[0]->embedUrl[0];
  
  if (isset($embed_url)) {
    header("Location: $embed_url", false, 301);
  } else {
    header("HTTP/1.0 404 Not Found");
  }
  
  