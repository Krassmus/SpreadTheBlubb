<?php


class InitConfig extends Migration {
    
	function description() {
        return 'initializes the config-entries for this plugin';
    }

    public function up() {
	    $config = Config::get();
        if (!isset($config["BLUBBER_TWITTER_CONSUMER_SECRET"])) {
            $config->create("BLUBBER_TWITTER_CONSUMER_SECRET", array('section' => "plugins", 'is_default' => "", 'value' => "", 'type' => "string", 'range' => "global", 'description' => "Twitter API key also known as 'consumer key' for blubber to send blubbs to tweets.", 'comment' => ""));
        }
        if (!isset($config["BLUBBER_TWITTER_CONSUMER_KEY"])) {
            $config->create("BLUBBER_TWITTER_CONSUMER_KEY", array('section' => "plugins", 'is_default' => "", 'value' => "", 'type' => "string", 'range' => "global", 'description' => "Twitter API key also known as 'consumer key' for blubber to send blubbs to tweets.", 'comment' => ""));
        }
    }
	
	public function down() {
        Config::get()->delete("BLUBBER_TWITTER_CONSUMER_SECRET");
        Config::get()->delete("BLUBBER_TWITTER_CONSUMER_KEY");
    }
}