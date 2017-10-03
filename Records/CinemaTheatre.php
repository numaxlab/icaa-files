<?php

namespace NumaxLab\Icaa\Records;

use Assert\Assert;
use Assert\Assertion;
use Stringy\Stringy;

class CinemaTheatre implements RecordInterface
{
    const RECORD_TYPE = 1;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * CinemaTheatre constructor.
     * @param string $code
     * @param string $name
     */
    public function __construct($code, $name)
    {
        $this->setCode($code);
        $this->setName($name);
    }

    /**
     * @param string $code
     */
    private function setCode($code)
    {
        Assert::that($code)
            ->notEmpty()
            ->length(6);

        $this->code = $code;
    }

    /**
     * @param string $name
     */
    private function setName($name)
    {
        Assertion::notEmpty($name);

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $line = (string) self::RECORD_TYPE;
        $line .= Stringy::create($this->getCode())->padRight(12, ' ');
        $line .= Stringy::create($this->getName())->substr(0, 30)->padRight(30, ' ');

        return $line;
    }

    /**
     * @param string $line
     * @return CinemaTheatre
     */
    public static function fromLine($line)
    {
        $code = (string) Stringy::create($line)->substr(1, 12)->trimRight();
        $name = (string) Stringy::create($line)->substr(13, 30)->trimRight();

        return new self($code, $name);
    }
}
