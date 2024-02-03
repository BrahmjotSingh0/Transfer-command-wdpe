<?php

declare(strict_types=1);

namespace real\Transfer;

use pocketmine\command\{Command, CommandSender};
use pocketmine\network\bedrock\BedrockNetworkSession;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\network\bedrock\protocol\TransferPacket;
use pocketmine\player\Player; 
use pocketmine\plugin\PluginBase;
use function array_shift;
use function count; 

class Transfer extends PluginBase{
    
    public function onCommand(CommandSender $sender, Command $cmd, string $commandLabel, array $args): bool{
        switch($cmd->getName()){
            case "transfer":  
            case "server":
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