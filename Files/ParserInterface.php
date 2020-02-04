<?php

namespace NumaxLab\Icaa\Files;

interface ParserInterface
{
    /**
     * @param string $input
     * @return mixed
     */
    public function parse($input);
}
