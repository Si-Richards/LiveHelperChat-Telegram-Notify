<?php

class erLhcoreClassExtensionTelegram {

	public function __construct() {
		
	}
	 
	public function run() {
		
		$dispatcher = erLhcoreClassChatEventDispatcher::getInstance();
		
		// Attatch event listeners
		$dispatcher->listen('chat.chat_started', array($this,'telegram'));
	}
		
	/**
	 * Arguments
	 * array('chat' => & $chat)
	 * */
	 
	public function telegram($params) {
		
		$text = "";
	    $conf = include 'extension/telegram/settings/settings.ini.php';
		$url = 'https://api.telegram.org/bot'.$conf['telegramBot'].'/sendMessage?parse_mode=Markdown';
		$chat = $params['chat'];
		
        foreach ($conf['receivers'] as $receiver) {

            $internalurl = $url.$receiver['chatid'];
			$text = "NEW CHAT REQUEST\nName: ";
			$text = (isset($chat->nick)) ? $text.$chat->nick : $text;
			$text .= "\nDept:";
			switch ($chat->dep_id) {
							case 0:
								$text .= " Something Went Wrong\n";
								break;
							case 1:
								$text .= " Retail Support Team\n";
								break;
							case 2:
								$text .= " Retail Sales Team\n";
								break;
							case 3:
								$text .= " Wholesale Support Team\n";
								break;
							case 4:
								$text .= " Wholesale Sales Team\n";
								break;
						}
			$text .= "Message:".$params['msg']->msg."\n";
			$internalurl .= "&text=".urlencode($text);
            file_get_contents($internalurl);
        }

	}

}