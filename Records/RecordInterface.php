<?php

namespace NumaxLab\Icaa\Records;

interface RecordInterface
{
    public function toLine();

    public static function fromLine($line);
}
