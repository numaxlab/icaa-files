<?php

namespace NumaxLab\Icaa\Files\Earnings;

use NumaxLab\Icaa\Exceptions\ParserException;
use NumaxLab\Icaa\Files\ParserInterface;
use NumaxLab\Icaa\EarningsFile;
use NumaxLab\Icaa\Records\Box;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\Session;
use NumaxLab\Icaa\Records\SessionFilm;
use NumaxLab\Icaa\Records\SessionScheduling;

class Parser implements ParserInterface
{
    /**
     * @var string
     */
    private $endOfLine;

    /**
     * @var EarningsFile
     */
    private $file;

    /**
     * @var array
     */
    private $typesToRecords = [
        Box::RECORD_TYPE => Box::class,
        CinemaTheatre::RECORD_TYPE => CinemaTheatre::class,
        Session::RECORD_TYPE => Session::class,
        SessionFilm::RECORD_TYPE => SessionFilm::class,
        Film::RECORD_TYPE => Film::class,
        SessionScheduling::RECORD_TYPE => SessionScheduling::class,
    ];

    /**
     * Parser constructor.
     * @param string $eol
     * @param EarningsFile $file
     */
    public function __construct($eol, EarningsFile $file)
    {
        $this->endOfLine = $eol;
        $this->file = $file;
    }

    /**
     * @param $input
     * @return EarningsFile
     * @throws ParserException
     */
    public function parse($input)
    {
        $lines = explode($this->endOfLine, $input);

        foreach ($lines as $line) {
            $recordType = substr($line, 0, 1);

            if (! array_key_exists($recordType, $this->typesToRecords)) {
                throw new ParserException(sprintf('Unexpected record type %s', $recordType));
            }

            $recordTypeClass = $this->typesToRecords[$recordType];
            $record = $recordTypeClass::fromLine($line);

            switch (true) {
                case $record instanceof Box:
                    $this->file->setBox($record);
                    break;
                case $record instanceof CinemaTheatre:
                    $this->file->addCinemaTheatre($record);
                    break;
                case $record instanceof Session:
                    $this->file->addSession($record);
                    break;
                case $record instanceof SessionFilm:
                    $this->file->addSessionFilm($record);
                    break;
                case $record instanceof Film:
                    $this->file->addFilm($record);
                    break;
                case $record instanceof SessionScheduling:
                    $this->file->addSessionScheduling($record);
                    break;
            }
        }

        return $this->file;
    }
}
