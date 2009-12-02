<?php

  Class extension_media_resolvr extends Extension
  {    
  /*-------------------------------------------------------------------------
    Extension definition
  -------------------------------------------------------------------------*/
    public function about()
    {
      return array('name' => 'Media Resolvr',
             'version' => '0.1',
             'release-date' => '2009-12-01',
             'author' => array('name' => 'Max Wheeler',
                       'website' => 'http://makenosound.com/',
                       'email' => 'max@makenosound.com'),
             'description' => 'Resolves page URIs to their embeddable media.'
             );
    }
    
    /*-------------------------------------------------------------------------
      Un/installation
    -------------------------------------------------------------------------*/
  
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
      
      ## Cannot use $1 in a preg_replace replacement string, so using a token instead
      $token = md5(time());
      
      $rule = "
	### START RESOLVR RULES
	RewriteRule ^resolvr/((.*\/?))?$ /{$rewrite_base}extensions/media_resolvr/lib/resolvr.php?url={$token}&%{QUERY_STRING}	[NC,L]
	### END RESOLVR RULES\n\n";
      
      $htaccess = self::__removeAPIRules($htaccess);
      
      $htaccess = preg_replace('/RewriteRule .\* - \[S=14\]\s*/i', "RewriteRule .* - [S=14]\n{$rule}\t", $htaccess);
      
      ## Replace the token with the real value
      $htaccess = str_replace($token, '$1', $htaccess);
      
      return @file_put_contents(DOCROOT . '/.htaccess', $htaccess);
    }
    
    private static function __removeAPIRules($htaccess){
      return preg_replace('/### START RESOLVR RULES(.)+### END RESOLVR RULES[\n]/is', NULL, $htaccess);
    }
  }