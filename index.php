<?php
interface ContentType
{
    public function getName(): String;
}

interface Trader
{
    public function getProduct(): ContentType;
    public function getProducts(): array;
}

class Content
{
    protected $type;
    protected $title;
    protected $date_release;

    public function __construct($title, $date_release)
    {
        $this->type         = 'Контент';
        $this->title        = (string)$title;
        $this->date_release = (int)$date_release;
    }

    public function __toString()
    {
        return sprintf("Тип: %s\nНазвание: %s\nДата выхода: %d\n", $this->type, $this->title, $this->date_release);
    }
}

class Film extends Content implements ContentType
{
    private $rating;
    private $hrono;

    public function __construct($title, $date_release, $rating, $hrono)
    {
        parent::__construct($title, $date_release);
        $this->type   = 'Фильм';
        $this->rating = (float)$rating;
        $this->hrono  = (int)$hrono;
    }

    public function getName(): String
    {
        return sprintf("%sРейтинг: %s\nПродолжительность: %s\n\n", parent::__toString(), $this->rating, $this->hrono);
    }
}

class Game extends Content implements ContentType
{
    private $rating;
    private $platform;

    public function __construct($title, $date_release, $rating, $platform)
    {
        parent::__construct($title, $date_release);
        $this->type     = 'Игра';
        $this->rating   = (float)$rating;
        $this->platform = (string)$platform;
    }

    public function getName(): String
    {
        return sprintf("%sРейтинг: %s\nПлатформа: %s\n\n", parent::__toString(), $this->rating, $this->platform);
    }
}

class Platform
{
    protected $title;

    public function __construct($title)
    {
        $this->title = (string)$title;
    }

    public function __toString()
    {
        return $this->title;
    }
}

class WindowsPlatform extends Platform
{
    protected static $_instance;

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self('Windows');
        }
        return self::$_instance;
    }
}

class SwitchPlatform extends Platform
{
    protected static $_instance;

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self('Switch');
        }
        return self::$_instance;
    }
}

class GameStudios implements ContentType
{
    public function getName(): String
    {
        return "Разработчики игр";
    }
}

class FilmStudios implements ContentType
{
    public function getName(): String
    {
        return "Киностудии";
    }
}

class TraderA implements Trader
{
    public function getProduct(): ContentType
    {
        return new RockstarGame();
    }

    public function getProducts(): array
    {
        return [
            new Game('GTA IV', 2008, 8.0, WindowsPlatform::getInstance()),
            new Game('GTA V', 2015, 7.0, WindowsPlatform::getInstance()),
            new Game('Zelda', 2019, 8.0, SwitchPlatform::getInstance()),
            new Game('Arms', 2019, 7.0, SwitchPlatform::getInstance()),
        ];
    }

    public function getName(): String
    {
        return 'Магазин фильмов' . "\n\n";
    }
}

class TraderB implements Trader
{
    public function getProduct(): ContentType
    {
        return new WarnerBrosFilms();
    }

    public function getProducts(): array
    {
        return [
            new Film('DUNE', 2021, 9.0, 152),
            new Film('Гвоздь', 2020, 3.0, 90),
            new Film('Челоук Павук', 2019, 5.0, 120),
        ];
    }

    public function getName(): String
    {
        return 'Магазин игр' . "\n\n";
    }
}

// An array of creators
$traders = [ new TraderA(), new TraderB() ];

// Iterate over creators and create products
foreach ($traders as $trader) {
    if (!empty($trader->getProducts()) && is_array($trader->getProducts())) {
        echo $trader->getName();
        foreach ($trader->getProducts() as $product) {
            echo $product->getName() . "\n";
        }
    }
}