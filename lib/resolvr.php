<?php

  # GET params strip extra / in http://, ensure URI is formed correctly
  $url = "http://" . ltrim($_GET['url'], "http:/");
  $pieces = parse_url($url);
  $host = ltrim($pieces['host'], "www.");
  
  # Pass off to the right processor
  switch ($host) {
    case "flickr.com":
      require_once("flickr.photos.php");
      break;
    case "blip.tv":
      require_once("bliptv.play.php");
      break;
  }