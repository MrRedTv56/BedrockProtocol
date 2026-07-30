<?php
declare(strict_types=1);
namespace pocketmine\network\mcpe\protocol\types\furnace;

use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class FurnaceOptions {
    public const LEFT_TAB_NONE = 0;
    public const LEFT_TAB_RECIPE_FOOD = 1;
    public const LEFT_TAB_RECIPE_ITEMS = 2;
    public const LEFT_TAB_RECIPE_BLOCKS = 3;
    public const LEFT_TAB_RECIPE_SEARCH = 4;
    public const LEFT_TAB_INVENTORY = 5;

    public const LAYOUT_NONE = 0;
    public const LAYOUT_INVENTORY_ONLY = 1;
    public const LAYOUT_DEFAULT = 2;

    public function __construct(
        public int $leftTab,
        public bool $filtering,
        public int $layout
    ) {}

    public static function read(ByteBufferReader $in) : self {
        return new self(
            VarInt::readSignedInt($in),
            $in->readBool(),
            VarInt::readSignedInt($in)
        );
    }

    public function write(ByteBufferWriter $out) : void {
        VarInt::writeSignedInt($out, $this->leftTab);
        $out->writeBool($this->filtering);
        VarInt::writeSignedInt($out, $this->layout);
    }
}
