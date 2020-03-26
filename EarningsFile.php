<?php

namespace NumaxLab\Icaa;

use Assert\Assertion;
use InvalidArgumentException;
use NumaxLab\Icaa\Files\Earnings\Dumper;
use NumaxLab\Icaa\Files\Earnings\Parser;
use NumaxLab\Icaa\Records\Earnings\Box;
use NumaxLab\Icaa\Records\Earnings\CinemaTheatre;
use NumaxLab\Icaa\Records\Collection;
use NumaxLab\Icaa\Records\Earnings\Film;
use NumaxLab\Icaa\Records\Earnings\Session;
use NumaxLab\Icaa\Records\Earnings\SessionFilm;
use NumaxLab\Icaa\Records\Earnings\SessionScheduling;

class EarningsFile
{
    public const EOL = "\r\n";

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
     * @var string
     */
    private $encryptionKeyData;

    /**
     * @var string
     */
    private $encryptKeyFingerprint;

    /**
     * EarningsFile constructor.
     * @param null|string $encryptionKeyData
     * @param null|string $encryptKeyFingerprint
     * @throws Exceptions\RecordsCollectionException
     */
    public function __construct(string $encryptionKeyData = null, string $encryptKeyFingerprint = null)
    {
        $this->cinemaTheatres = new Collection();
        $this->sessions = new Collection();
        $this->sessionsFilms = new Collection();
        $this->films = new Collection();
        $this->sessionsScheduling = new Collection();

        $this->encryptionKeyData = $encryptionKeyData;
        $this->encryptKeyFingerprint = $encryptKeyFingerprint;
    }

    /**
     * @param Box $box
     * @return EarningsFile
     */
    public function setBox(Box $box): EarningsFile
    {
        $this->box = $box;
        return $this;
    }

    /**
     * @param CinemaTheatre $cinemaTheatre
     * @return EarningsFile
     */
    public function addCinemaTheatre(CinemaTheatre $cinemaTheatre): EarningsFile
    {
        $this->cinemaTheatres->push($cinemaTheatre);
        return $this;
    }

    /**
     * @param Session $session
     * @return EarningsFile
     */
    public function addSession(Session $session): EarningsFile
    {
        $this->sessions->push($session);
        return $this;
    }

    /**
     * @param SessionFilm $sessionFilm
     * @return EarningsFile
     */
    public function addSessionFilm(SessionFilm $sessionFilm): EarningsFile
    {
        $this->sessionsFilms->push($sessionFilm);
        return $this;
    }

    /**
     * @param Film $film
     * @return EarningsFile
     */
    public function addFilm(Film $film): EarningsFile
    {
        $this->films->push($film);
        return $this;
    }

    /**
     * @param SessionScheduling $sessionScheduling
     * @return EarningsFile
     */
    public function addSessionScheduling(SessionScheduling $sessionScheduling): EarningsFile
    {
        $this->sessionsScheduling->push($sessionScheduling);
        return $this;
    }

    /**
     * @return Box
     */
    public function box(): Box
    {
        return $this->box;
    }

    /**
     * @return Collection
     */
    public function cinemaTheatres(): Collection
    {
        return $this->cinemaTheatres;
    }

    /**
     * @return Collection
     */
    public function sessions(): Collection
    {
        return $this->sessions;
    }

    /**
     * @return Collection
     */
    public function sessionsFilms(): Collection
    {
        return $this->sessionsFilms;
    }

    /**
     * @return Collection
     */
    public function films(): Collection
    {
        return $this->films;
    }

    /**
     * @return Collection
     */
    public function sessionsScheduling(): Collection
    {
        return $this->sessionsScheduling;
    }

    /**
     * @param string $input
     * @param string $eol
     * @return EarningsFile
     * @throws Exceptions\ParserException
     * @throws Exceptions\RecordsCollectionException
     */
    public static function parse(string $input, string $eol = self::EOL): EarningsFile
    {
        $parser = new Parser($eol, new self());

        return $parser->parse($input);
    }

    /**
     * @param string $eol
     * @return string
     * @throws \Assert\AssertionFailedException
     */
    public function dump(string $eol = self::EOL): string
    {
        $this->assertProperties();

        $this->updateBoxWithFinalCounts();

        $dumper = new Dumper($eol, $this);

        return $dumper->dump();
    }

    /**
     * @param string $input
     * @return string
     */
    public function encrypt(string $input): string
    {
        $encrypter = new Encrypter($this->encryptionKeyData, $this->encryptKeyFingerprint);

        return $encrypter->encrypt($input);
    }

    /**
     * @throws InvalidArgumentException
     * @throws \Assert\AssertionFailedException
     */
    private function assertProperties(): void
    {
        Assertion::notEmpty($this->box);
        Assertion::greaterThan($this->cinemaTheatres()->count(), 0);
    }

    /**
     *
     */
    private function updateBoxWithFinalCounts(): void
    {
        $fileLinesQty = 1 + $this->cinemaTheatres()->count() +
            $this->sessions()->count() + $this->sessionsFilms()->count() +
            $this->films()->count() + $this->sessionsScheduling()->count();

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
