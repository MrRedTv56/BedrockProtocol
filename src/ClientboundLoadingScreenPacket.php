<?php

namespace pocketmine\network\mcpe\protocol;

use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pocketmine\network\mcpe\protocol\serializer\CommonTypes;

class ClientboundLoadingScreenPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::CLIENTBOUND_LOADING_SCREEN_PACKET;

	private ?int $loadingScreenId = null;

	public static function create(?int $loadingScreenId) : self{
		$result = new self;
		$result->loadingScreenId = $loadingScreenId;
		return $result;
	}

	public function getLoadingScreenId() : ?int{ return $this->loadingScreenId; }

	protected function decodePayload(ByteBufferReader $in) : void{
		$this->loadingScreenId = CommonTypes::readOptional($in, LE::readUnsignedInt(...));
	}

	protected function encodePayload(ByteBufferWriter $out) : void{
		CommonTypes::writeOptional($out, $this->loadingScreenId, LE::writeUnsignedInt(...));
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleClientboundLoadingScreen($this);
	}
}