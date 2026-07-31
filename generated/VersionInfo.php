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

class VersionInfo {

	/** Actual Minecraft: PE protocol version */
	public const CURRENT_PROTOCOL = self::PROTOCOL_1_26_50;
	/** Display version shown in the server logs. This should match the version on the game's home screen. */
	public const MINECRAFT_VERSION = 'v26.50';
	/** Version sent on the network for client side compatibility checks. This may differ from the display version. */
	public const MINECRAFT_VERSION_NETWORK = '1.26.50.22';

	public const ACCEPTED_PROTOCOL = [
		self::PROTOCOL_1_26_0,
		self::PROTOCOL_1_26_10,
		self::PROTOCOL_1_26_20,
		self::PROTOCOL_1_26_30,
		self::CURRENT_PROTOCOL,
	];

	public const PROTOCOL_1_26_50 = 2171;
	public const PROTOCOL_1_26_30 = 1001;
	public const PROTOCOL_1_26_20 = 975;
	public const PROTOCOL_1_26_10 = 944;
	public const PROTOCOL_1_26_0  = 924;
}
