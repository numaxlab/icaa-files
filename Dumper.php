<?php

namespace NumaxLab\Icaa;

use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\Session;
use NumaxLab\Icaa\Records\SessionFilm;
use NumaxLab\Icaa\Records\SessionScheduling;

class Dumper
{
    /**
     * @var string
     */
    private $endOfLine;

    /**
     * @var \NumaxLab\Icaa\IcaaFile
     */
    private $file;

    /**
     * Dumper constructor.
     * @param string $eol
     * @param \NumaxLab\Icaa\IcaaFile $file
     */
    public function __construct($eol, IcaaFile $file)
    {
        $this->endOfLine = $eol;
        $this->file = $file;
    }

    /**
     * @throws \NumaxLab\Icaa\Exceptions\MissingPropertyException
     */
    protected function checkProperties()
    {
        $throwException = false;
        $missingProperty = '';

        if (is_null($this->file->getBox())) {
            $throwException = true;
            $missingProperty = 'box';
        }
        if (! $throwException && $this->file->getCinemaTheatres()->count() === 0) {
            $throwException = true;
            $missingProperty = 'cinemaTheatres';
        }
        if (! $throwException && $this->file->getSessions()->count() === 0) {
            $throwException = true;
            $missingProperty = 'sessions';
        }
        if (! $throwException && $this->file->getSessionsFilms()->count() === 0) {
            $throwException = true;
            $missingProperty = 'sessionsFilms';
        }
        if (! $throwException && $this->file->getFilms()->count() === 0) {
            $throwException = true;
            $missingProperty = 'films';
        }
        if (! $throwException && $this->file->getSessionsScheduling()->count() === 0) {
            $throwException = true;
            $missingProperty = 'sessionsScheduling';
        }

        if ($throwException) {
            throw new MissingPropertyException(sprintf("Missing property %s", $missingProperty));
        }
    }

    /**
     * @return string
     */
    public function dump()
    {
        $this->checkProperties();

        $dump = $this->file->getBox()->toLine().$this->endOfLine;
        /** @var CinemaTheatre $cinemaTheatre */
        foreach ($this->file->getCinemaTheatres() as $cinemaTheatre) {
            $dump .= $cinemaTheatre->toLine().$this->endOfLine;
        }
        /** @var Session $session */
        foreach ($this->file->getSessions() as $session) {
            $dump .= $session->toLine().$this->endOfLine;
        }
        /** @var SessionFilm $sessionFilm */
        foreach ($this->file->getSessionsFilms() as $sessionFilm) {
            $dump .= $sessionFilm->toLine().$this->endOfLine;
        }
        /** @var Film $film */
        foreach ($this->file->getFilms() as $film) {
            $dump .= $film->toLine().$this->endOfLine;
        }
        /** @var SessionScheduling $sessionScheduling */
        foreach ($this->file->getSessionsScheduling() as $sessionScheduling) {
            $dump .= $sessionScheduling->toLine().$this->endOfLine;
        }

        return $dump;
    }
}
