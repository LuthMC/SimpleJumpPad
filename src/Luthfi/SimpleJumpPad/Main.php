<?php

declare(strict_types=1);

namespace Luthfi\SimpleJumpPad;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use pocketmine\block\BlockLegacyIds;

class Main extends PluginBase implements Listener {

    private float $jumpPower;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->reloadConfig();

        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->jumpPower = $config->get("jump_power", 2.0);

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        
        if ($block->getId() === BlockLegacyIds::LIGHT_WEIGHTED_PRESSURE_PLATE) {
            $player->setMotion(new Vector3(0, $this->jumpPower, 0));
        }
    }
}
