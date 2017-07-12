<?php

namespace NumaxLab\Icaa\Records;

use NumaxLab\Icaa\Exceptions\MissingPropertyException;
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
     * @throws \NumaxLab\Icaa\Exceptions\MissingPropertyException
     */
    private function checkProperties()
    {
        $throwException = false;
        $missingProperty = '';

        if (is_null($this->getCinemaTheatreCode())) {
            $throwException = true;
            $missingProperty = 'cinemaTheatreCode';
        }
        if (! $throwException && is_null($this->getId())) {
            $throwException = true;
            $missingProperty = 'id';
        }
        if (! $throwException && is_null($this->getClassificationRecordCode())) {
            $throwException = true;
            $missingProperty = 'classificationRecordCode';
        }
        if (! $throwException && is_null($this->getTitle())) {
            $throwException = true;
            $missingProperty = 'title';
        }
        if (! $throwException && is_null($this->getDistributorCode())) {
            $throwException = true;
            $missingProperty = 'distributorCode';
        }
        if (! $throwException && is_null($this->getDistributorName())) {
            $throwException = true;
            $missingProperty = 'distributorName';
        }
        if (! $throwException && is_null($this->getOriginalVersionCode())) {
            $throwException = true;
            $missingProperty = 'originalVersionCode';
        }
        if (! $throwException && is_null($this->getLangVersionCode())) {
            $throwException = true;
            $missingProperty = 'langVersionCode';
        }
        if (! $throwException && is_null($this->getCaptionsLangCode())) {
            $throwException = true;
            $missingProperty = 'captionsLangCode';
        }
        if (! $throwException && is_null($this->getProjectionFormat())) {
            $throwException = true;
            $missingProperty = 'projectionFormat';
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
        $line .= Stringy::create($this->getCinemaTheatreCode())->padRight(12, ' ');
        $line .= Stringy::create((string) $this->getId())->padLeft(5, '0');
        $line .= Stringy::create($this->getClassificationRecordCode())->padRight(12, ' ');
        $line .= Stringy::create($this->getTitle())->substr(0, 50)->padRight(50, ' ');
        $line .= Stringy::create($this->getDistributorCode())->padRight(12, ' ');
        $line .= Stringy::create($this->getDistributorName())->substr(0, 50)->padRight(50, ' ');
        $line .= $this->getOriginalVersionCode();
        $line .= $this->getLangVersionCode();
        $line .= $this->getCaptionsLangCode();
        $line .= $this->getProjectionFormat();

        return $line;
    }

    /**
     * @param string $line
     * @return \NumaxLab\Icaa\Records\Film
     */
    public static function fromLine($line)
    {
        $self = new self();

        $self->setCinemaTheatreCode(rtrim(substr($line, 1, 12)));
        $self->setId((int) ltrim(substr($line, 13, 5), '0'));
        $self->setClassificationRecordCode(rtrim(substr($line, 18, 12)));
        $self->setTitle(rtrim(substr($line, 30, 50)));
        $self->setDistributorCode(rtrim(substr($line, 80, 12)));
        $self->setDistributorName(rtrim(substr($line, 92, 50)));
        $self->setOriginalVersionCode(substr($line, 142, 1));
        $self->setLangVersionCode(substr($line, 143, 1));
        $self->setCaptionsLangCode(substr($line, 144, 1));
        $self->setProjectionFormat(substr($line, 145, 1));

        return $self;
    }
}
