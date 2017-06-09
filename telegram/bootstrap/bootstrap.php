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

            $internalurl = $url."&chat_id=xxxxxxxxx";
			$text = "=== NEW CHAT REQUEST ===\nNAME: ";
			$text = (isset($chat->nick)) ? $text.$chat->nick : $text;
			$text .= "\nDEPT:".$chat->department;
			$text .= "\nMESSAGE:".$params['msg']->msg."\n";
			$text .= "IP:". erLhcoreClassIPDetect::getIP()."\n";
			$text .= 'https://' . $_SERVER['HTTP_HOST'] . erLhcoreClassDesign::baseurl('chat/accept').'/'.erLhcoreClassModelChatAccept::generateAcceptLink($chat);
			$internalurl .= "&text=".urlencode($text);
            file_get_contents($internalurl);
        }

	}

}
