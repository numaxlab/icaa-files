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
     * @param string $encryptionKeyData
     * @param string $encryptKeyFingerprint
     */
    public function __construct($encryptionKeyData, $encryptKeyFingerprint)
    {
        putenv("GNUPGHOME=/tmp");

        $gpg = new gnupg();
        $gpg->setsignmode(GNUPG_SIG_MODE_CLEAR);
        $gpg->seterrormode(GNUPG_ERROR_EXCEPTION);

        $gpg->import($encryptionKeyData);

        $gpg->addencryptkey($encryptKeyFingerprint);

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
