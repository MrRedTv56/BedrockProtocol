<?php
declare(strict_types=1);
namespace pocketmine\network\mcpe\protocol;

use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pocketmine\network\mcpe\protocol\types\furnace\FurnaceOptions;

class SetPlayerFurnaceOptionsPacket extends DataPacket implements ClientboundPacket {
    public const NETWORK_ID = ProtocolInfo::SET_PLAYER_FURNACE_OPTIONS_PACKET;

    private int $furnaceType;
    private FurnaceOptions $furnaceOptions;

    public static function create(int $furnaceType, FurnaceOptions $furnaceOptions) : self {
        $result = new self;
        $result->furnaceType = $furnaceType;
        $result->furnaceOptions = $furnaceOptions;
        return $result;
    }

    public function getFurnaceType() : int { return $this->furnaceType; }
    public function getFurnaceOptions() : FurnaceOptions { return $this->furnaceOptions; }

    protected function decodePayload(ByteBufferReader $in) : void {
        $this->furnaceType = Byte::readUnsigned($in);
        $this->furnaceOptions = FurnaceOptions::read($in);
    }

    protected function encodePayload(ByteBufferWriter $out) : void {
        Byte::writeUnsigned($out, $this->furnaceType);
        $this->furnaceOptions->write($out);
    }

    public function handle(PacketHandlerInterface $handler) : bool {
        return $handler->handleSetPlayerFurnaceOptions($this);
    }
}
