<?php

namespace NumaxLab\Icaa;

use NumaxLab\Icaa\Records\Box;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\Collection;
use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\Session;
use NumaxLab\Icaa\Records\SessionScheduling;

class Dumper
{
    /**
     * @var string
     */
    private $endOfLine;

    /**
     * @var \NumaxLab\Icaa\Records\Box
     */
    private $box;

    /**
     * @var \NumaxLab\Icaa\Records\Collection
     */
    private $cinemaTheatres;

    /**
     * @var \NumaxLab\Icaa\Records\Collection
     */
    private $sessions;

    /**
     * @var \NumaxLab\Icaa\Records\Collection
     */
    private $sessionsFilms;

    /**
     * @var \NumaxLab\Icaa\Records\Collection
     */
    private $films;

    /**
     * @var \NumaxLab\Icaa\Records\Collection
     */
    private $sessionsScheduling;

    /**
     * Dumper constructor.
     * @param string $eol
     */
    public function __construct($eol = PHP_EOL)
    {
        $this->endOfLine = $eol;

        $this->cinemaTheatres = new Collection();
        $this->sessions = new Collection();
        $this->sessionsFilms = new Collection();
        $this->films = new Collection();
        $this->sessionsScheduling = new Collection();
    }

    /**
     * @param \NumaxLab\Icaa\Records\Box $box
     * @return Dumper
     */
    public function setBox(Box $box)
    {
        $this->box = $box;
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\CinemaTheatre $cinemaTheatre
     * @return Dumper
     */
    public function addCinemaTheatre(CinemaTheatre $cinemaTheatre)
    {
        $this->cinemaTheatres->push($cinemaTheatre);
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\Session $session
     * @return Dumper
     */
    public function addSession(Session $session)
    {
        $this->sessions->push($session);
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\SessionFilm $sessionFilm
     * @return Dumper
     */
    public function addSessionFilm($sessionFilm)
    {
        $this->sessionsFilms->push($sessionFilm);
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\Film $film
     * @return Dumper
     */
    public function addFilm(Film $film)
    {
        $this->films->push($film);
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\SessionScheduling $sessionScheduling
     * @return Dumper
     */
    public function addSessionScheduling(SessionScheduling $sessionScheduling)
    {
        $this->sessionsScheduling->push($sessionScheduling);
        return $this;
    }

    /**
     * @return \NumaxLab\Icaa\Records\Box
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * @return \NumaxLab\Icaa\Records\Collection
     */
    public function getCinemaTheatres()
    {
        return $this->cinemaTheatres;
    }

    /**
     * @return \NumaxLab\Icaa\Records\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * @return \NumaxLab\Icaa\Records\Collection
     */
    public function getSessionsFilms()
    {
        return $this->sessionsFilms;
    }

    /**
     * @return \NumaxLab\Icaa\Records\Collection
     */
    public function getFilms()
    {
        return $this->films;
    }

    /**
     * @return \NumaxLab\Icaa\Records\Collection
     */
    public function getSessionsScheduling()
    {
        return $this->sessionsScheduling;
    }

    /**
     * @return string
     */
    public function dump()
    {
        $dump = $this->box->toLine().$this->endOfLine;
        /** @var CinemaTheatre $cinemaTheatre */
        foreach ($this->cinemaTheatres as $cinemaTheatre) {
            $dump .= $cinemaTheatre->toLine().$this->endOfLine;
        }
        /** @var Session $session */
        foreach ($this->sessions as $session) {
            $dump .= $session->toLine().$this->endOfLine;
        }
        /** @var \NumaxLab\Icaa\Records\SessionFilm $sessionFilm */
        foreach ($this->sessionsFilms as $sessionFilm) {
            $dump .= $sessionFilm->toLine().$this->endOfLine;
        }
        /** @var Film $film */
        foreach ($this->films as $film) {
            $dump .= $film->toLine().$this->endOfLine;
        }
        /** @var SessionScheduling $sessionScheduling */
        foreach ($this->sessionsScheduling as $sessionScheduling) {
            $dump .= $sessionScheduling->toLine().$this->endOfLine;
        }

        return $dump;
    }
}
