<?php
/**
 *  ____  _            _______ _          _____
 * |  _ \| |          |__   __| |        |  __ \
 * | |_) | | __ _ _______| |  | |__   ___| |  | | _____   __
 * |  _ <| |/ _` |_  / _ \ |  | '_ \ / _ \ |  | |/ _ \ \ / /
 * | |_) | | (_| |/ /  __/ |  | | | |  __/ |__| |  __/\ V /
 * |____/|_|\__,_/___\___|_|  |_| |_|\___|_____/ \___| \_/
 *
 * Copyright (C) 2018 iiFlamiinBlaze
 *
 * iiFlamiinBlaze's plugins are licensed under MIT license!
 * Made by iiFlamiinBlaze for the PocketMine-MP Community!
 *
 * @author iiFlamiinBlaze
 * Twitter: https://twitter.com/iiFlamiinBlaze
 * GitHub: https://github.com/iiFlamiinBlaze
 * Discord: https://discord.gg/znEsFsG
 */
declare(strict_types=1);

namespace iiFlamiinBlaze\BlazinSmelt;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class BlazinSmelt extends PluginBase{

    public const VERSION = "v1.0.0";
    public const PREFIX = TextFormat::AQUA . "BlazinSmelt" . TextFormat::GOLD . " > ";

    /** @var self $instance */
    private static $instance;

    public function onEnable() : void{
        self::$instance = $this;
        $this->getLogger()->info("BlazinSmelt " . self::VERSION . " by iiFlamiinBlaze is enabled");
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new BlazinSmeltListener(), $this);
        $this->economyCheck();
    }

    private function economyCheck() : bool{
        if($this->getConfig()->get("economy") === "on"){
            if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") === null){
                $this->getLogger()->error(TextFormat::RED . "BlazinSmelt disabled! You must enable/install EconomyAPI or turn off economy support in the config!");
                $this->getPluginLoader()->disablePlugin($this);
                return false;
            }
        }elseif($this->getConfig()->get("economy") === "off") return false;
        return true;
    }

    public static function getInstance() : self{
        return self::$instance;
    }
}