<?php

namespace NumaxLab\Icaa\Records;

use Carbon\Carbon;
use NumaxLab\Icaa\Exceptions\InvalidFormatException;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;

class Box implements RecordInterface
{
    const RECORD_TYPE = 0;
    const FILE_TYPE_REGULAR = 'FL';
    const FILE_TYPE_DELAYED = 'AT';

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $fileType;

    /**
     * @var \Carbon\Carbon
     */
    private $lastScheduledFileSentAt;

    /**
     * @var \Carbon\Carbon
     */
    private $currentFileSentAt;

    /**
     * @var int
     */
    private $fileLinesQty;

    /**
     * @var int
     */
    private $sessionsQty;

    /**
     * @var int
     */
    private $ticketsQty;

    /**
     * @var float
     */
    private $earnings;

    /**
     * Box constructor.
     * @param $fileType
     */
    public function __construct($fileType)
    {
        switch ($fileType) {
            case self::FILE_TYPE_REGULAR:
            case self::FILE_TYPE_DELAYED:
                $this->fileType = $fileType;
                break;
            default:
                throw new InvalidFormatException("The file type must be one of the valid constants: FILE_TYPE_REGULAR, FILE_TYPE_DELAYED");
                break;
        }
    }

    /**
     * @param string $code
     * @return \NumaxLab\Icaa\Records\Box
     * @throws \NumaxLab\Icaa\Exceptions\InvalidFormatException
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param \Carbon\Carbon $lastScheduledFileSentAt
     * @return Box
     */
    public function setLastScheduledFileSentAt(Carbon $lastScheduledFileSentAt)
    {
        $this->lastScheduledFileSentAt = $lastScheduledFileSentAt;
        return $this;
    }

    /**
     * @param \Carbon\Carbon $currentFileSentAt
     * @return Box
     */
    public function setCurrentFileSentAt(Carbon $currentFileSentAt)
    {
        $this->currentFileSentAt = $currentFileSentAt;
        return $this;
    }

    /**
     * @param int $fileLinesQty
     * @return Box
     */
    public function setFileLinesQty($fileLinesQty)
    {
        $this->fileLinesQty = $fileLinesQty;
        return $this;
    }

    /**
     * @param int $sessionsQty
     * @return Box
     */
    public function setSessionsQty($sessionsQty)
    {
        $this->sessionsQty = $sessionsQty;
        return $this;
    }

    /**
     * @param int $ticketsQty
     * @return Box
     */
    public function setTicketsQty($ticketsQty)
    {
        $this->ticketsQty = $ticketsQty;
        return $this;
    }

    /**
     * @param float $earnings
     * @return Box
     */
    public function setEarnings($earnings)
    {
        $this->earnings = $earnings;
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
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getLastScheduledFileSentAt()
    {
        return $this->lastScheduledFileSentAt;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getCurrentFileSentAt()
    {
        return $this->currentFileSentAt;
    }

    /**
     * @return int
     */
    public function getFileLinesQty()
    {
        return $this->fileLinesQty;
    }

    /**
     * @return int
     */
    public function getSessionsQty()
    {
        return $this->sessionsQty;
    }

    /**
     * @return int
     */
    public function getTicketsQty()
    {
        return $this->ticketsQty;
    }

    /**
     * @return float
     */
    public function getEarnings()
    {
        return $this->earnings;
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
        if (! $throwException && is_null($this->getLastScheduledFileSentAt())) {
            $throwException = true;
            $missingProperty = 'lastScheduledFileSentAt';
        }
        if (! $throwException && is_null($this->getCurrentFileSentAt())) {
            $throwException = true;
            $missingProperty = 'currentFileSentAt';
        }
        if (! $throwException && is_null($this->getFileLinesQty())) {
            $throwException = true;
            $missingProperty = 'fileLinesQty';
        }
        if (! $throwException && is_null($this->getSessionsQty())) {
            $throwException = true;
            $missingProperty = 'sessionsQty';
        }
        if (! $throwException && is_null($this->getTicketsQty())) {
            $throwException = true;
            $missingProperty = 'ticketsQty';
        }
        if (! $throwException && is_null($this->getEarnings())) {
            $throwException = true;
            $missingProperty = 'earnings';
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

        $firstDayOfYear = Carbon::createFromDate(Carbon::now()->year, 1, 1);

        $line = (string) self::RECORD_TYPE;
        $line .= $this->getCode();
        $line .= $this->getFileType();
        $line .= str_pad(
            (string) $firstDayOfYear->diffInDays($this->getLastScheduledFileSentAt()),
            3,
            '0',
            STR_PAD_LEFT
        );
        $line .= str_pad(
            (string) $firstDayOfYear->diffInDays($this->getCurrentFileSentAt()),
            3,
            '0',
            STR_PAD_LEFT
        );
        $line .= str_pad((string) $this->getFileLinesQty(), 11, '0', STR_PAD_LEFT);
        $line .= str_pad((string) $this->getSessionsQty(), 11, '0', STR_PAD_LEFT);
        $line .= str_pad((string) $this->getTicketsQty(), 11, '0', STR_PAD_LEFT);
        $line .= str_pad(
            (string) number_format($this->getEarnings(), 2, '.', ''),
            11,
            '0',
            STR_PAD_LEFT
        );

        return $line;
    }
}
