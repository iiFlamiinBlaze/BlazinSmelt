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

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;

class BlazinSmeltListener implements Listener{

    public function onBlockBreak(BlockBreakEvent $event) : void{
        $player = $event->getPlayer();
        $inv = $player->getInventory();
        if($event->isCancelled()) return;
        if($player->isCreative()) return;
        switch($event->getBlock()->getId()){
            case Item::GOLD_ORE:
                if(BlazinSmelt::getInstance()->getConfig()->get("auto-smelt") === "on"){
                    if(BlazinSmelt::getInstance()->getConfig()->get("economy") === "on"){
                        foreach($event->getDrops() as $drops) $inv->addItem(Item::get(Item::GOLD_INGOT, 0, 1));
                        BlazinSmelt::getInstance()->getServer()->getPluginManager()->getPlugin("EconomyAPI")->getInstance()->reduceMoney($player, (float)BlazinSmelt::getInstance()->getConfig()->get("auto-smelt-price"));
                        $event->setDrops([]);
                    }else{
                        foreach($event->getDrops() as $drops) $inv->addItem(Item::get(Item::GOLD_INGOT, 0, 1));
                        $event->setDrops([]);
                    }
                }elseif(BlazinSmelt::getInstance()->getConfig()->get("auto-smelt") === "off"){
                    foreach($event->getDrops() as $drops) $inv->addItem($drops);
                    $event->setDrops([]);
                }
                return;
            case Item::IRON_ORE:
                if(BlazinSmelt::getInstance()->getConfig()->get("auto-smelt") === "on"){
                    if(BlazinSmelt::getInstance()->getConfig()->get("economy") === "on"){
                        foreach($event->getDrops() as $drops) $inv->addItem(Item::get(Item::IRON_INGOT, 0, 1));
                        BlazinSmelt::getInstance()->getServer()->getPluginManager()->getPlugin("EconomyAPI")->getInstance()->reduceMoney($player, (float)BlazinSmelt::getInstance()->getConfig()->get("auto-smelt-price"));
                        $event->setDrops([]);
                    }else{
                        foreach($event->getDrops() as $drops) $inv->addItem(Item::get(Item::IRON_INGOT, 0, 1));
                        $event->setDrops([]);
                    }
                }elseif(BlazinSmelt::getInstance()->getConfig()->get("auto-smelt") === "off"){
                    foreach($event->getDrops() as $drops) $inv->addItem($drops);
                    $event->setDrops([]);
                }
                return;
            default:
                if(BlazinSmelt::getInstance()->getConfig()->get("auto-inv") === "on"){
                    if($inv->canAddItem($event->getItem())){
                        foreach($event->getDrops() as $drops) $inv->addItem($drops);
                        $event->setDrops([]);
                    }else{
                        $player->sendMessage(str_replace("&", "§", BlazinSmelt::getInstance()->getConfig()->get("inv-full-message")));
                    }
                }
                return;
        }
    }
}