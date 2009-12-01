<?php

  $url = $_GET['url'];
  $size = $_GET['size'];
  
  $pattern = '/photos\/[^\/]+\/([0-9]+)/i';
  if( ! preg_match($pattern, $url, $matches)) header("HTTP/1.0 404 Not Found");

  # Setup params
  $params = array(
    'api_key'   => '4405910e8de51bbdffd8dcfbf996b78f',
    'method'    => 'flickr.photos.getSizes',
    'photo_id'  => $matches[1],
    'format'    => 'php_serial'
  );
  
  # Encode them to be safe
  $encoded_params = array();
  foreach ($params as $k => $v){
  	$encoded_params[] = urlencode($k).'='.urlencode($v);
  }
  # Construct the URI request from Flickr
  $uri = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);

  # Get CURL going
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $uri);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  $tmp = curl_exec($ch);
  curl_close($ch);
  
  # Deal with the response
  $rsp = unserialize($tmp);
  $sizes = $rsp['sizes']['size'];
  
  # Get the specified size, default to "medium"
  $size = (isset($size) && $size < count($sizes)) ? $size : 3;
  $photo = $sizes[$size];
  if (isset($photo) && $photo['media'] == 'photo')
  {
    header("Location: " . $photo['source'], false, 301);
  } else {
    header("HTTP/1.0 404 Not Found");
  }