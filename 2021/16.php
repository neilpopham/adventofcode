<?php

require('libs/core.php');


class Packet {
    public $binary;
    public $pointer = 0;
    public $versions = 0;
    public $result = [];

    function __construct($binary) {
        $this->binary = $binary;
    }

    public function read($bytes, $decimal = false) {
        $output = substr($this->binary, $this->pointer, $bytes);
        if (strlen($output) < $bytes) {
            $this->pointer = strlen($this->binary);
            return false;
        }
        $this->pointer += $bytes;
        return $decimal ? bindec($output) : $output;
    }

    public function subpacket($bytes) {
        $packet = new Packet($this->read($bytes));
        $response = $packet->parse();
        $this->versions += $packet->versions;
        return $response;
    }

    public function parse() {
        $values = [];
        do {
            $value = $this->readPacket();
            if (false !== $value) {
                $values[] = $value;
            }
        } while (false !== $value);
        return $values;
    }

    public function readPacket() {

        if (false === $version = $this->read(3, true)) {
            return false;
        }

        $this->versions += $version;

        if (false === $typeId = $this->read(3, true)) {
            return false;
        }

        switch ($typeId) {

            case 4:
                $binary = '';
                do {
                    $prefix = $this->read(1);
                    $binary .= $this->read(4);
                } while ($prefix == 1);
                $return = bindec($binary);
                break;

            default:
                $len = [0 => 15, 1 => 11];
                $lengthTypeId = $this->read(1);
                $decimal = $this->read($len[$lengthTypeId], true);
                if ($decimal === false) {
                    return false;
                }
                if ($lengthTypeId == 0) {
                    $values = $this->subpacket($decimal);
                } else {
                    $values = [];
                    for ($i = 0; $i < $decimal; $i++) {
                        $values[] = $this->readPacket();
                    }
                }
                switch ($typeId) {
                    // sum
                    case 0:
                        $return = array_sum($values);
                        break;
                    // product
                    case 1:
                        $return = array_product($values);
                        break;
                    // minimum
                    case 2:
                        $return = min($values);
                        break;
                    // maximum
                    case 3:
                        $return = max($values);
                        break;
                    // greater than
                    case 5:
                        $return = $values[0] > $values[1] ? 1 : 0;
                        break;
                    // less than
                    case 6:
                        $return = $values[0] < $values[1] ? 1 : 0;
                        break;
                    // equal to
                    case 7:
                        $return = $values[0] == $values[1] ? 1 : 0;
                        break;
                }
        }

        return $return;
    }
}

function input2binary($hex) {
    $binary = '';
    for ($i = 0; $i < strlen($hex); $i++) {
        $binary .= str_pad(base_convert($hex[$i], 16, 2), 4, '0', STR_PAD_LEFT);
    }
    return $binary;
}

$data = load_file("16.txt");

$binary = input2binary($data);

$packet = new Packet($binary);

print $packet->parse()[0];
print "\n";
print $packet->versions;
print "\n";
