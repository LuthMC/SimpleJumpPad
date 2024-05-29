<?php

declare(strict_types=1);

namespace Luthfi\SimpleJumpPad;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    private float $jumpPower;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->reloadConfig();

        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->jumpPower = $config->get("jump_power", 2.0);

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $block = $player->getWorld()->getBlock($player->getPosition()->floor()->down());
        
        if ($block->getTypeId() === VanillaBlocks::LIGHT_WEIGHTED_PRESSURE_PLATE()->getTypeId()) {
            $player->setMotion(new Vector3(0, $this->jumpPower, 0));
        }
    }
}
