<?php

namespace NumaxLab\Icaa;

use gnupg;

class Encrypter
{
    /**
     * @var gnupg
     */
    private $gpg;

    /**
     * Encrypter constructor.
     * @param string $signKey
     */
    public function __construct($signKey)
    {
        putenv("GNUPGHOME=/tmp");

        $gpg = new gnupg();
        $gpg->setsignmode(GNUPG_SIG_MODE_CLEAR);
        $gpg->seterrormode(GNUPG_ERROR_EXCEPTION);

        $keyInfo = $gpg->import($signKey);
        $gpg->addencryptkey($keyInfo['fingerprint']);

        $this->gpg = $gpg;
    }

    /**
     * @param string $input
     * @return string
     */
    public function encrypt($input)
    {
        return $this->gpg->encrypt($input);
    }
}
