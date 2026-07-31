<?php

/*
 * This file is part of BedrockProtocol.
 * Copyright (C) 2014-2022 PocketMine Team <https://github.com/pmmp/BedrockProtocol>
 *
 * BedrockProtocol is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;
use pocketmine\network\mcpe\protocol\serializer\CommonTypes;
use function count;

class ResourcePackClientResponsePacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACK_CLIENT_RESPONSE_PACKET;

	public const STATUS_REFUSED = 1;
	public const STATUS_SEND_PACKS = 2;
	public const STATUS_HAVE_ALL_PACKS = 3;
	public const STATUS_COMPLETED = 4;

	public int $status;
	/** @var string[] */
	public array $packIds = [];

	/**
	 * @generate-create-func
	 * @param string[] $packIds
	 */
	public static function create(int $status, array $packIds) : self{
		$result = new self;
		$result->status = $status;
		$result->packIds = $packIds;
		return $result;
	}

	protected function decodePayload(ByteBufferReader $in) : void{
		$responseTypeId = Byte::readSigned($in); // int8
		$this->responseType = CommonTypes::getString($in); // "cancel", "downloading", etc.

		$this->packIds = [];
		if($responseTypeId === self::STATUS_SEND_PACKS){ // 2 = Downloading
			for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
				$this->packIds[] = CommonTypes::getString($in);
			}
		}
	}

	protected function encodePayload(ByteBufferWriter $out) : void{
		Byte::writeSigned($out, $this->responseStatus);
		CommonTypes::putString($out, $this->responseType);

		if($this->responseStatus === self::STATUS_SEND_PACKS){
			VarInt::writeUnsignedInt($out, count($this->packIds));
			foreach($this->packIds as $packId){
				CommonTypes::putString($out, $packId);
			}
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleResourcePackClientResponse($this);
	}
}
