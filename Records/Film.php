<?php

namespace NumaxLab\Icaa\Records;

use Assert\Assert;
use Assert\Assertion;
use Stringy\Stringy;

class Film implements RecordInterface
{
    const RECORD_TYPE = 4;

    /**
     * @var string
     */
    private $cinemaTheatreCode;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $ratingRecordNumber;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $distributorCode;

    /**
     * @var string
     */
    private $distributorName;

    /**
     * @var string
     */
    private $originalVersionCode;

    /**
     * @var string
     */
    private $langVersionCode;

    /**
     * @var string
     */
    private $captionsLangCode;

    /**
     * @var string
     */
    private $projectionFormatCode;

    /**
     * Film constructor.
     * @param string $cinemaTheatreCode
     * @param int $id
     * @param string $ratingRecordNumber
     * @param string $title
     * @param string $distributorCode
     * @param string $distributorName
     * @param string $originalVersionCode
     * @param string $langVersionCode
     * @param string $captionsLangCode
     * @param string $projectionFormatCode
     */
    public function __construct(
        $cinemaTheatreCode,
        $id,
        $ratingRecordNumber,
        $title,
        $distributorCode,
        $distributorName,
        $originalVersionCode,
        $langVersionCode,
        $captionsLangCode,
        $projectionFormatCode
    )
    {
        $this->setCinemaTheatreCode($cinemaTheatreCode);
        $this->setId($id);
        $this->setRatingRecordNumber($ratingRecordNumber);
        $this->setTitle($title);
        $this->setDistributorCode($distributorCode);
        $this->setDistributorName($distributorName);
        $this->setOriginalVersionCode($originalVersionCode);
        $this->setLangVersionCode($langVersionCode);
        $this->setCaptionsLangCode($captionsLangCode);
        $this->setProjectionFormatCode($projectionFormatCode);
    }

    /**
     * @param string $cinemaTheatreCode
     */
    private function setCinemaTheatreCode($cinemaTheatreCode)
    {
        Assert::that($cinemaTheatreCode)
            ->notEmpty()
            ->length(6);

        $this->cinemaTheatreCode = $cinemaTheatreCode;
    }

    /**
     * @param int $id
     */
    private function setId($id)
    {
        Assert::that($id)
            ->integer()
            ->greaterThan(0);

        $this->id = $id;
    }

    /**
     * @param string $ratingRecordNumber
     */
    private function setRatingRecordNumber($ratingRecordNumber)
    {
        Assertion::notEmpty($ratingRecordNumber);

        $this->ratingRecordNumber = $ratingRecordNumber;
    }

    /**
     * @param string $title
     */
    private function setTitle($title)
    {
        Assertion::notEmpty($title);

        $this->title = $title;
    }

    /**
     * @param string $distributorCode
     */
    private function setDistributorCode($distributorCode)
    {
        Assertion::notEmpty($distributorCode);

        $this->distributorCode = $distributorCode;
    }

    /**
     * @param string $distributorName
     */
    private function setDistributorName($distributorName)
    {
        Assertion::notEmpty($distributorName);

        $this->distributorName = $distributorName;
    }

    /**
     * @param string $originalVersionCode
     */
    private function setOriginalVersionCode($originalVersionCode)
    {
        Assertion::notEmpty($originalVersionCode);

        $this->originalVersionCode = $originalVersionCode;
    }

    /**
     * @param string $langVersionCode
     */
    private function setLangVersionCode($langVersionCode)
    {
        Assertion::notEmpty($langVersionCode);

        $this->langVersionCode = $langVersionCode;
    }

    /**
     * @param string $captionsLangCode
     */
    private function setCaptionsLangCode($captionsLangCode)
    {
        Assertion::notBlank($captionsLangCode);

        $this->captionsLangCode = $captionsLangCode;
    }

    /**
     * @param string $projectionFormatCode
     */
    private function setProjectionFormatCode($projectionFormatCode)
    {
        Assertion::notBlank($projectionFormatCode);

        $this->projectionFormatCode = $projectionFormatCode;
    }

    /**
     * @return string
     */
    public function getCinemaTheatreCode()
    {
        return $this->cinemaTheatreCode;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRatingRecordNumber()
    {
        return $this->ratingRecordNumber;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDistributorCode()
    {
        return $this->distributorCode;
    }

    /**
     * @return string
     */
    public function getDistributorName()
    {
        return $this->distributorName;
    }

    /**
     * @return string
     */
    public function getOriginalVersionCode()
    {
        return $this->originalVersionCode;
    }

    /**
     * @return string
     */
    public function getLangVersionCode()
    {
        return $this->langVersionCode;
    }

    /**
     * @return string
     */
    public function getCaptionsLangCode()
    {
        return $this->captionsLangCode;
    }

    /**
     * @return string
     */
    public function getProjectionFormatCode()
    {
        return $this->projectionFormatCode;
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $line = (string) self::RECORD_TYPE;
        $line .= Stringy::create($this->getCinemaTheatreCode())->padRight(12, ' ');
        $line .= Stringy::create((string) $this->getId())->padLeft(5, '0');
        $line .= Stringy::create($this->getRatingRecordNumber())->padRight(12, ' ');
        $line .= Stringy::create($this->getTitle())->substr(0, 50)->padRight(50, ' ');
        $line .= Stringy::create($this->getDistributorCode())->padRight(12, ' ');
        $line .= Stringy::create($this->getDistributorName())->substr(0, 50)->padRight(50, ' ');
        $line .= $this->getOriginalVersionCode();
        $line .= $this->getLangVersionCode();
        $line .= $this->getCaptionsLangCode();
        $line .= $this->getProjectionFormatCode();

        return $line;
    }

    /**
     * @param string $line
     * @return Film
     */
    public static function fromLine($line)
    {
        $cinemaTheatreCode = (string) Stringy::create($line)->substr(1, 12)->trimRight();
        $id = (int)(string) Stringy::create($line)->substr(13, 5)->trimLeft('0');
        $ratingRecordNumber = (string) Stringy::create($line)->substr(18, 12)->trimRight();
        $title = (string) Stringy::create($line)->substr(30, 50)->trimRight();
        $distributorCode = (string) Stringy::create($line)->substr(80, 12)->trimRight();
        $distributorName = (string) Stringy::create($line)->substr(92, 50)->trimRight();
        $originalVersionCode = (string) Stringy::create($line)->substr(142, 1);
        $langVersionCode = (string) Stringy::create($line)->substr(143, 1);
        $captionsLangCode = (string) Stringy::create($line)->substr(144, 1);
        $projectionFormatCode = (string) Stringy::create($line)->substr(145, 1);

        return new self(
            $cinemaTheatreCode,
            $id,
            $ratingRecordNumber,
            $title,
            $distributorCode,
            $distributorName,
            $originalVersionCode,
            $langVersionCode,
            $captionsLangCode,
            $projectionFormatCode
        );
    }
}
