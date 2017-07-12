<?php

namespace NumaxLab\Icaa\Records;


use NumaxLab\Icaa\Exceptions\MissingPropertyException;
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
     */
    public function __construct()
    {

    }

    /**
     * @param string $code
     * @return CinemaTheatre
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param string $name
     * @return CinemaTheatre
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     * @throws \NumaxLab\Icaa\Exceptions\MissingPropertyException
     */
    private function checkProperties()
    {
        $throwException = false;
        $missingProperty = '';

        if (is_null($this->getCode())) {
            $throwException = true;
            $missingProperty = 'code';
        }
        if (! $throwException && is_null($this->getName())) {
            $throwException = true;
            $missingProperty = 'name';
        }

        if ($throwException) {
            throw new MissingPropertyException(sprintf("Missing property %s", $missingProperty));
        }
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $this->checkProperties();

        $line = (string) self::RECORD_TYPE;
        $line .= Stringy::create($this->getCode())->padRight(12, ' ');
        $line .= Stringy::create($this->getName())->substr(0, 30)->padRight(30, ' ');

        return $line;
    }

    /**
     * @param string $line
     * @return \NumaxLab\Icaa\Records\CinemaTheatre
     */
    public static function fromLine($line)
    {
        $self = new self();

        $self->setCode((string) Stringy::create($line)->substr(1, 12)->trimRight());
        $self->setName((string) Stringy::create($line)->substr(13, 30)->trimRight());

        return $self;
    }
}
