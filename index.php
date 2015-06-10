<?php
	require_once ( 'email.class.php' );
	require_once ( '../config.php' );
	require_once ( 'twitteroauth.php' );
        
	$dir = DIR_LINK.'/';
	if (is_dir($dir)) {
		$files = scandir($dir,1);
	
		array_pop($files); // '..'
		array_pop($files); // '.'
	
		foreach($files as $file):
			
			$email = new EmailParser( file_get_contents(DIR_LINK.'/'.$file));
			
			var_dump($email);
	
			$to = $email->getHeader('to');
			
			if($to == TOADD ) :
				$text = $email->getText();
				
				$text = str_replace('Morning All!','',$text);
				$text = str_replace('This Puzzle has no Perfect Solution!','',$text);
				$text = str_replace('"Best of luck!"','',$text);
	
				$yes = tweet($text);
				if($yes) :
					unlink($dir.''.$file);
				endif;
			endif;
		endforeach;
	} 
	
	function tweet($message) {
		$connection = new TwitterOAuth( CountDownKey1, CountDownKey2, CountDownKey3, CountDownKey4);
		$connection->get('account/verify_credentials');
		$connection->post('statuses/update',array('status' => $message));
	}
