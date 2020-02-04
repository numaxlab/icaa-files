<?php

namespace NumaxLab\Icaa\Files;

interface DumperInterface
{
    /**
     * @return string
     */
    public function dump(): string;
}
