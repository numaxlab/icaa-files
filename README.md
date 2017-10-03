# ICAA Files Component [![Build Status](https://travis-ci.org/numaxlab/icaa-files.svg?branch=master)](https://travis-ci.org/numaxlab/icaa-files)

Componente para lectura y escritura de ficheros de comunicación entre buzones homologados y el ICAA (Instituto de la Cinematografía y de las Artes Audiovisuales) según el [BOE-A-2011-11110](http://www.boe.es/boe/dias/2011/06/28/pdfs/BOE-A-2011-11110.pdf).

## Instalación

Este paquete es instalable y autocargable a través de Composer:

```$ composer require numaxlab/icaa-files```

## Uso

### Lectura

```php
use NumaxLab\Icaa\IcaaFile;

$icaaFile = IcaaFile::parse($fileContent);

$box = $icaaFile->getBox();
//...
```

### Escritura

```php
use NumaxLab\Icaa\IcaaFile;

$icaaFile = new IcaaFile();

$icaaFile->setBox($box)
    ->addCinemaTheatre($cinemaTheatre)
    //...
    ->addSession($session)
    //...
    ->addSessionFilm($sessionFilm)
    //...
    ->addFilm($film)
    //...
    ->addSessionScheduling($sessionScheduling);
    
$fileContent = $icaaFile->dump();
```