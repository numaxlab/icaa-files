<?php

namespace NumaxLab\Icaa;

use NumaxLab\Icaa\Records\Box;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\Collection;
use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\Session;
use NumaxLab\Icaa\Records\SessionFilm;
use NumaxLab\Icaa\Records\SessionScheduling;

class IcaaFile
{
    /**
     * @var Box
     */
    private $box;

    /**
     * @var Collection
     */
    private $cinemaTheatres;

    /**
     * @var Collection
     */
    private $sessions;

    /**
     * @var Collection
     */
    private $sessionsFilms;

    /**
     * @var Collection
     */
    private $films;

    /**
     * @var Collection
     */
    private $sessionsScheduling;

    /**
     * IcaaFile constructor.
     */
    public function __construct()
    {
        $this->cinemaTheatres = new Collection();
        $this->sessions = new Collection();
        $this->sessionsFilms = new Collection();
        $this->films = new Collection();
        $this->sessionsScheduling = new Collection();
    }

    /**
     * @param Box $box
     * @return IcaaFile
     */
    public function setBox(Box $box)
    {
        $this->box = $box;
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\CinemaTheatre $cinemaTheatre
     * @return IcaaFile
     */
    public function addCinemaTheatre(CinemaTheatre $cinemaTheatre)
    {
        $this->cinemaTheatres->push($cinemaTheatre);
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\Session $session
     * @return IcaaFile
     */
    public function addSession(Session $session)
    {
        $this->sessions->push($session);
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\SessionFilm $sessionFilm
     * @return IcaaFile
     */
    public function addSessionFilm(SessionFilm $sessionFilm)
    {
        $this->sessionsFilms->push($sessionFilm);
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\Film $film
     * @return IcaaFile
     */
    public function addFilm(Film $film)
    {
        $this->films->push($film);
        return $this;
    }

    /**
     * @param \NumaxLab\Icaa\Records\SessionScheduling $sessionScheduling
     * @return IcaaFile
     */
    public function addSessionScheduling(SessionScheduling $sessionScheduling)
    {
        $this->sessionsScheduling->push($sessionScheduling);
        return $this;
    }

    /**
     * @return Box
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * @return Collection
     */
    public function getCinemaTheatres()
    {
        return $this->cinemaTheatres;
    }

    /**
     * @return Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * @return Collection
     */
    public function getSessionsFilms()
    {
        return $this->sessionsFilms;
    }

    /**
     * @return Collection
     */
    public function getFilms()
    {
        return $this->films;
    }

    /**
     * @return Collection
     */
    public function getSessionsScheduling()
    {
        return $this->sessionsScheduling;
    }

    /**
     * @param $input
     * @param string $eol
     * @return \NumaxLab\Icaa\IcaaFile
     */
    public static function parse($input, $eol = PHP_EOL)
    {
        $parser = new Parser($eol, new self());

        return $parser->parse($input);
    }

    /**
     * @param string $eol
     * @return string
     */
    public function dump($eol = PHP_EOL)
    {
        $dumper = new Dumper($eol, $this);

        return $dumper->dump();
    }
}
