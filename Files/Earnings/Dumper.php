<?php

namespace NumaxLab\Icaa\Files\Earnings;

use NumaxLab\Icaa\Files\DumperInterface;
use NumaxLab\Icaa\EarningsFile;
use NumaxLab\Icaa\Records\Earnings\CinemaTheatre;
use NumaxLab\Icaa\Records\Earnings\Film;
use NumaxLab\Icaa\Records\Earnings\Session;
use NumaxLab\Icaa\Records\Earnings\SessionFilm;
use NumaxLab\Icaa\Records\Earnings\SessionScheduling;

class Dumper implements DumperInterface
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
     * Dumper constructor.
     * @param string $eol
     * @param EarningsFile $file
     */
    public function __construct($eol, EarningsFile $file)
    {
        $this->endOfLine = $eol;
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function dump(): string
    {
        $dump = $this->file->box()->toLine().$this->endOfLine;
        /** @var CinemaTheatre $cinemaTheatre */
        foreach ($this->file->cinemaTheatres() as $cinemaTheatre) {
            $dump .= $cinemaTheatre->toLine().$this->endOfLine;
        }
        /** @var Session $session */
        foreach ($this->file->sessions() as $session) {
            $dump .= $session->toLine().$this->endOfLine;
        }
        /** @var SessionFilm $sessionFilm */
        foreach ($this->file->sessionsFilms() as $sessionFilm) {
            $dump .= $sessionFilm->toLine().$this->endOfLine;
        }
        /** @var Film $film */
        foreach ($this->file->films() as $film) {
            $dump .= $film->toLine().$this->endOfLine;
        }
        /** @var SessionScheduling $sessionScheduling */
        foreach ($this->file->sessionsScheduling() as $key => $sessionScheduling) {
            $dump .= $sessionScheduling->toLine();

            if ($key !== $this->file->sessionsScheduling()->count() - 1) {
                $dump .= $this->endOfLine;
            }
        }

        return utf8_decode($dump);
    }
}
