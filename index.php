<?php
	require_once ( '../config.php' );
	require_once ( 'twitteroauth.php' );
 	$m_box = imap_open ("{localhost:995/pop3/ssl/novalidate-cert}INBOX", POP_USER, POP_PASS);
	if( $m_box ) {
	    	// check messages
		$check = imap_mailboxmsginfo($m_box);
		// if there is a message in your inbox - process
		if( $check->Nmsgs > 0 ) { 
		     	$message = quoted_printable_decode(imap_body($m_box, 1)); 
		     	$start=strpos($message,'Morning all!');
			$end = strpos($message,'Best of luck!');
			$content = substr($message,$start,$end-$start);
		     	$content = str_replace('Morning all!','',$content);
			$content = str_replace('Best of luck!','',$content);
			$text = $content .'Good luck. #CountDownRocks';
			echo "Message: {$text}";
			tweet($text);
		}
		// delete mail. clear deleted and close
		imap_delete($m_box, 1);
		imap_expunge($m_box);
	     	imap_close($m_box); 
	}
	
	function tweet($message) {
		$connection = new TwitterOAuth( CountDownKey1, CountDownKey2, CountDownKey3, CountDownKey4);
		$connection->get('account/verify_credentials');
		$connection->post('statuses/update',array('status' => $message));
	}
