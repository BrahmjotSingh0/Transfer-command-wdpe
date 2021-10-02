<?php

declare(strict_types=1);

namespace real\Transfer;

use pocketmine\command\{Command, CommandSender};
use pocketmine\utils\TextFormat as TF;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\network\mcpe\protocol\TransferPacket;
use pocketmine\player\Player;
use function array_shift;
use function count;

class transfer extends PluginBase{
    
    public function onCommand(CommandSender $sender, Command $cmd, string $commandLabel, array $args): bool{
        switch($cmd->getName()){
            case "transfer":
                if(count($args) < 1){
                    throw new InvalidCommandSyntaxException();
                }
                if($sender instanceof Player){
                    if(!$sender->hasPermission("wdpe.transfer.command")){
                        $sender->sendMessage("§cYou don't have permission to use this command!");
                        return false;
                    }
                    $server = array_shift($args);
                    $sender->sendMessage("§aTransferring you to {$server}");
                    $pk = new TransferPacket();
		            $pk->address = $server;
		            $pk->port = 1;
		            $sender->getNetworkSession()->sendDataPacket($pk);
                }else{
                    $sender->sendMessage("§crun this command in-game only!");
                	return false;
                }
            break;
        }
        return true;
    }
    
}