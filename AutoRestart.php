<?php

/*
__PocketMine Plugin__
name=AutoRestart
description=Auto Restart after an user set interval if properly configured.
version=1.0.0
author=99leonchang
class=AutoRestart
apiversion=9,10
*/

class AutoRestart implements Plugin{
	
	private $api;
	private $minute;
	private $server;
	private $servname;
	
	public function __construct(ServerAPI $api, $server = false){
		$this->api = $api;
		$this->server = ServerAPI::request();
	}
	
	public function init(){
		$this->config = new Config($this->api->plugin->configPath($this)."config.yml", CONFIG_YAML, array(
			"minutes" => "30",
		));
		$this->minute = $this->config->get("minutes");
		$this->api->console->register("restart", "Auto Restart after an user set interval if properly configured.", array($this, "command"));
		$this->api->addHandler("player.spawn", array($this, "eventHandler"), 100);
		
		$this->api->schedule(1200, array($this, "timerSchedule"), array(), true);
	}
	
	public function eventHandler($data, $event)
	{
		switch($event)
		{
			case "player.spawn":
					$data->sendChat("****************************************************");
					$data->sendChat("%% Welcome to ".($this->server->name)."!");
					$data->sendChat("%% Currently Online: ".count($this->api->player->getAll())."/".$this->server->maxClients);
					$data->sendChat("%% Server restarts automatically.");
					$data->sendChat("%% ".($this->minute)." minutes left before server restarts.");
					$data->sendChat("****************************************************");
					break;
		}
	}
	
	public function timerSchedule()
	{
		$this->minute--;
		if($this->minute < 25 and $this->minute > 1)
		{
			$this->api->chat->broadcast(($this->minute)." minutes until restart");
		}
		if($this->minute == 1)
		{
			$this->api->chat->broadcast("1 minute left. Get ready to rejoin!");
		}
		if($this->minute == 0)
		{
			$this->api->chat->broadcast("Server restarting.");
			$this->api->console->run("stop");
		}
	}
	
	public function command($cmd, $arg){
		switch($cmd){
			case "restart":
				console("****************************************************");
				console("%% ".($this->server->name)."::Restart Info");
				console("%% Currently Online: ".count($this->api->player->getAll())."/".$this->server->maxClients);
				console("%% ".($this->minute)." minutes left until server restarts.");
				console("****************************************************");
				break;
		}
		if($issuer instanceof Player)
		{
			$output .= "This command can only be run from the console.";
			return $output;
		}
	}
	public function __destruct(){
	}
}