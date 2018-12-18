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
        $html = $this->client->request('GET', $uri, ['referer' => true,
                                                     'headers' => [
                                                         'User-Agent' => 'RecipeReader/v1.0',
                                                         'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                                                    //     'Accept-Encoding' => 'gzip, deflate, br',
                                                     ]])->getBody();

        $parser = $this->parserFactory->create($this->getHostNameFromURL($uri), $html);

        return $parser->setHtml($html);
    }

    protected function getHostNameFromURL($uri)
    {
        return parse_url($uri, PHP_URL_HOST);
    }
}