<?php

namespace NumaxLab\Icaa\Records;

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
    private $classificationRecordCode;

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
    private $projectionFormat;

    /**
     * Film constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param string $cinemaTheatreCode
     * @return Film
     */
    public function setCinemaTheatreCode($cinemaTheatreCode)
    {
        $this->cinemaTheatreCode = $cinemaTheatreCode;
        return $this;
    }

    /**
     * @param int $id
     * @return Film
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $classificationRecordCode
     * @return Film
     */
    public function setClassificationRecordCode($classificationRecordCode)
    {
        $this->classificationRecordCode = $classificationRecordCode;
        return $this;
    }

    /**
     * @param string $title
     * @return Film
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $distributorCode
     * @return Film
     */
    public function setDistributorCode($distributorCode)
    {
        $this->distributorCode = $distributorCode;
        return $this;
    }

    /**
     * @param string $distributorName
     * @return Film
     */
    public function setDistributorName($distributorName)
    {
        $this->distributorName = $distributorName;
        return $this;
    }

    /**
     * @param string $originalVersionCode
     * @return Film
     */
    public function setOriginalVersionCode($originalVersionCode)
    {
        $this->originalVersionCode = $originalVersionCode;
        return $this;
    }

    /**
     * @param string $langVersionCode
     * @return Film
     */
    public function setLangVersionCode($langVersionCode)
    {
        $this->langVersionCode = $langVersionCode;
        return $this;
    }

    /**
     * @param string $captionsLangCode
     * @return Film
     */
    public function setCaptionsLangCode($captionsLangCode)
    {
        $this->captionsLangCode = $captionsLangCode;
        return $this;
    }

    /**
     * @param string $projectionFormat
     * @return Film
     */
    public function setProjectionFormat($projectionFormat)
    {
        $this->projectionFormat = $projectionFormat;
        return $this;
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
    public function getClassificationRecordCode()
    {
        return $this->classificationRecordCode;
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
    public function getProjectionFormat()
    {
        return $this->projectionFormat;
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $line = (string) self::RECORD_TYPE;
        $line .= str_pad($this->getCinemaTheatreCode(), 12, ' ');
        $line .= str_pad($this->getId(), 5, '0', STR_PAD_LEFT);
        $line .= str_pad($this->getClassificationRecordCode(), 12, ' ');
        $line .= str_pad($this->getTitle(), 50, ' ');
        $line .= str_pad($this->getDistributorCode(), 12, ' ');
        $line .= str_pad($this->getDistributorName(), 50, ' ');
        $line .= $this->getOriginalVersionCode();
        $line .= $this->getLangVersionCode();
        $line .= $this->getCaptionsLangCode();
        $line .= $this->getProjectionFormat();

        return $line;
    }
}
