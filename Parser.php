<?php

namespace NumaxLab\Icaa;

class Parser
{
    /**
     * @var \NumaxLab\Icaa\IcaaFile
     */
    private $file;

    /**
     * Parser constructor.
     * @param \NumaxLab\Icaa\IcaaFile $file
     */
    public function __construct(IcaaFile $file)
    {
        $this->file = $file;
    }

    /**
     * @param $input
     * @return \NumaxLab\Icaa\IcaaFile
     */
    public function parse($input)
    {

        return $this->file;
    }
}
