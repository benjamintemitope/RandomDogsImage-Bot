<?php

namespace App\Conversations;

use App\Services\DogService;
use App\Http\Controllers\Controller;

class SubBreedController extends Controller
{
    // The endpoint we will hit to get a random image by a given breed name and its sub-breed.
    const SUB_BREED_ENDPOINT = 'https://dog.ceo/api/breed/%s/%s/images/random';
    /**
     * Controller constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->photos = new DogService;
    }

    /**
     * Return a random dog image from all breeds.
     *
     * @return void
     */
    public function random($bot, $breed, $subBreed)
    {
        $bot->reply($this->photos->bySubBreed($breed, $subBreed));
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
            $endpoint = sprintf(self::SUB_BREED_ENDPOINT, $breed, $subBreed);

            $response = json_decode(
                $this->client->get($endpoint)->getBody()
            );

            return $response->message;
        } catch (Exception $e) {
            return "Sorry I couldn\"t get you any photos from $breed. Please try with a different breed.";
        }
    }
}