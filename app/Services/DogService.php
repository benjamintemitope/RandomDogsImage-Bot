<?php

namespace App\Services;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Exception;
use GuzzleHttp\Client;

class DogService
{
    // The endpoint we will be getting a random image from.
    const RANDOM_ENDPOINT = 'https://dog.ceo/api/breeds/image/random';
    // The endpoint we will hit to get a random image by a given breed name.
    const BREED_ENDPOINT = 'https://dog.ceo/api/breed/%s/images/random';
    // The endpoint we will hit to get a random image by a given subBreed name.
    const SUB_BREED_ENDPOINT = 'https://dog.ceo/api/breed/%s/%s/images/random';
    // The endpoint to fecth all avaliable breeds and subBreeds
    const ALL_BREED_ENDPOINT = 'https://dog.ceo/api/breeds/list/all';

    /**
     * Guzzle client.
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * DogService constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * Fetch and return a random image from all breeds.
     *
     * @return string
     */
    public function random()
    {
        try {
            // Decode the json response.
            $response = json_decode(
                // Make an API call an return the response body.
                $this->client->get(self::RANDOM_ENDPOINT)->getBody()
            );
            return $response->message;
        } catch (Exception $e) {
            // If anything goes wrong, we will be sending the user this error message.
            return 'An unexpected error occurred. Please try again later.';
        }
    }
    /**
     * Fetch and return a random image from a given breed.
     *
     * @param string $breed
     * @return string
     */
    public function byBreed($breed)
    {
        try {
            $breed = strtolower($breed);
            $endpoint = sprintf(self::BREED_ENDPOINT, $breed);
            $response = json_decode($this->client->get($endpoint)->getBody());
            return $response->message;
        } catch (Exception $e) {
            $breed = ucfirst($breed);
            return "Sorry I couldn't get you any photos from your input <b>$breed</b>. Please try with a different breed.";
        }
    }
    /**
     * Fetch and return a random image from a given breed and its sub-breed.
     *
     * @param string $breed
     * @param string $subBreed
     * @return string
     */
    public function bySubBreed($breed, $subBreed)
    {
        try {
            $breed = strtolower($breed);
            $endpoint = sprintf(self::SUB_BREED_ENDPOINT, $breed, $subBreed);
            $response = json_decode(
                $this->client->get($endpoint)->getBody()
            );
            return $response->message;
        } catch (Exception $e) {
            $breed = ucfirst($breed);
            $subBreed = ucfirst($subBreed);
            return "Sorry I couldn't get you any photos from  your input <b>$breed $subBreed</b>. Please try with a different breed.";
        }
    }

    /**
     *  Fetch and return all breeds and its sub-breeds.
     *
     * 
     * @return array
    **/

    public function allBreeds()
    {
        try {
            $response = json_decode(
                $this->client->get(self::ALL_BREED_ENDPOINT)->getBody()
            );
            return (array) $response->message;
        } catch (Exception $e) {
            return "Sorry unable to get breed lists";
        }
        
    }
}