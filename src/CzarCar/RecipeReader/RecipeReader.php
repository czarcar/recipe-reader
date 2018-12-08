<?php
namespace CzarCar\RecipeReader;

use GuzzleHttp\ClientInterface;
use CzarCar\RecipeReader\Interfaces\ParserFactoryInterface;

/**
 * Created by PhpStorm.
 * User: brent
 * Date: 12/1/18
 * Time: 6:52 AM
 */
class RecipeReader
{
    protected $client;

    public function __construct(ClientInterface $client, ParserFactoryInterface $parserFactory)
    {
        $this->client = $client;
        $this->parserFactory = $parserFactory;
        return $this;
    }

    public function fromUrl($uri)
    {
        $parser = $this->selectParser($uri);
        $html = $this->client->request('GET', $uri)->getBody();
        return $parser->setHtml($html);
    }

    protected function selectParser($uri)
    {
        return $this->parserFactory->create(parse_url($uri, PHP_URL_HOST));
    }
}