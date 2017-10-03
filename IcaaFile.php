<?php

namespace NumaxLab\Icaa;

use Assert\Assertion;
use InvalidArgumentException;
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
     * @param CinemaTheatre $cinemaTheatre
     * @return IcaaFile
     */
    public function addCinemaTheatre(CinemaTheatre $cinemaTheatre)
    {
        $this->cinemaTheatres->push($cinemaTheatre);
        return $this;
    }

    /**
     * @param Session $session
     * @return IcaaFile
     */
    public function addSession(Session $session)
    {
        $this->sessions->push($session);
        return $this;
    }

    /**
     * @param SessionFilm $sessionFilm
     * @return IcaaFile
     */
    public function addSessionFilm(SessionFilm $sessionFilm)
    {
        $this->sessionsFilms->push($sessionFilm);
        return $this;
    }

    /**
     * @param Film $film
     * @return IcaaFile
     */
    public function addFilm(Film $film)
    {
        $this->films->push($film);
        return $this;
    }

    /**
     * @param SessionScheduling $sessionScheduling
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
    public function box()
    {
        return $this->box;
    }

    /**
     * @return Collection
     */
    public function cinemaTheatres()
    {
        return $this->cinemaTheatres;
    }

    /**
     * @return Collection
     */
    public function sessions()
    {
        return $this->sessions;
    }

    /**
     * @return Collection
     */
    public function sessionsFilms()
    {
        return $this->sessionsFilms;
    }

    /**
     * @return Collection
     */
    public function films()
    {
        return $this->films;
    }

    /**
     * @return Collection
     */
    public function sessionsScheduling()
    {
        return $this->sessionsScheduling;
    }

    /**
     * @param $input
     * @param string $eol
     * @return IcaaFile
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
        $this->assertProperties();

        $this->updateBoxWithFinalCounts();

        $dumper = new Dumper($eol, $this);

        return $dumper->dump();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertProperties()
    {
        Assertion::notEmpty($this->box());
        Assertion::greaterThan($this->cinemaTheatres()->count(), 0);
        Assertion::greaterThan($this->sessions()->count(), 0);
        Assertion::greaterThan($this->sessionsFilms()->count(), 0);
        Assertion::greaterThan($this->films()->count(), 0);
        Assertion::greaterThan($this->sessionsScheduling()->count(), 0);
    }

    /**
     *
     */
    private function updateBoxWithFinalCounts()
    {
        $fileLinesQty = 1 + $this->cinemaTheatres()->count() +
            $this->sessions()->count() + $this->sessionsFilms()->count() +
            $this->films()->count() + $this->sessionsScheduling();

        $sessionsQty = $this->sessions()->count();

        $ticketsQty = 0;
        $earnings = 0;
        /** @var Session $session */
        foreach ($this->sessions() as $session) {
            $ticketsQty += $session->getTicketsQty();
            $earnings += $session->getEarnings();
        }

        $this->box()->setFileLinesQty($fileLinesQty);
        $this->box()->setSessionsQty($sessionsQty);
        $this->box()->setTicketsQty($ticketsQty);
        $this->box()->setEarnings($earnings);
    }
}
