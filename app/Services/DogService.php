<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class DogService
{
    // The endpoint we will be getting a random image from.
    const RANDOM_ENDPOINT = 'https://dog.ceo/api/breeds/image/random';
    //const RANDOM_ENDPOINT = 'https://random.dog/woof.json';
    // The endpoint we will hit to get a random image by a given breed name.
    const BREED_ENDPOINT = 'https://dog.ceo/api/breed/%s/images/random';
    
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

            // Return the image URL.
            return $response->message;
            //return $response->url;
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
        $breed = strtolower($breed);
        try {
            // We replace %s    in our endpoint with the given breed name.
            $endpoint = sprintf(self::BREED_ENDPOINT, $breed);

            $response = json_decode(
                $this->client->get($endpoint)->getBody()
            );

            return $response->message;
        } catch (Exception $e) {
            return "Sorry I couldn't get you any photos from your input ($breed). Please try with a different breed.";
        }
    }
}