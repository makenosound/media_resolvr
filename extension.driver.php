<?php

  Class extension_flickr_resolvr extends Extension
  {    
  /*-------------------------------------------------------------------------
    Extension definition
  -------------------------------------------------------------------------*/
    public function about()
    {
      return array('name' => 'Flickr Resolvr',
             'version' => '1.0',
             'release-date' => '2009-12-01',
             'author' => array('name' => 'Max Wheeler',
                       'website' => 'http://makenosound.com/',
                       'email' => 'max@makenosound.com'),
             'description' => 'Resolves various Flickr image sizes from their photo page URI.'
             );
    }
  
    public function uninstall()
    {
      $htaccess = @file_get_contents(DOCROOT . '/.htaccess');

      if($htaccess === false) return false;

      $htaccess = self::__removeAPIRules($htaccess);

      return @file_put_contents(DOCROOT . '/.htaccess', $htaccess);
    }
  
    public function install()
    {
      $htaccess = @file_get_contents(DOCROOT . '/.htaccess');

      if($htaccess === false) return false;

      ## Find out if the rewrite base is another other than /
      $rewrite_base = NULL;
      if(preg_match('/RewriteBase\s+([^\s]+)/i', $htaccess, $match)){
        $rewrite_base = trim($match[1], '/') . '/';
      }
      $rule = "
	### START RESOLVR RULES
	RewriteRule ^flickr-resolvr(\/(.*\/?))?$ {$rewrite_base}extensions/flickr_resolver/lib/flickr.photos.getSizes.php?url=%{QUERY_STRING}	[NC,L]
	### END RESOLVR RULES\n\n";

      $htaccess = self::__removeAPIRules($htaccess);

      $htaccess = preg_replace('/RewriteRule .\* - \[S=14\]\s*/i', "RewriteRule .* - [S=14]\n{$rule}\t", $htaccess);

      return @file_put_contents(DOCROOT . '/.htaccess', $htaccess);
    }
    
    private static function __removeAPIRules($htaccess){
      return preg_replace('/### START RESOLVR RULES(.)+### END RESOLVR RULES[\n]/is', NULL, $htaccess);
    }
  }