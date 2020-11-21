<?php

namespace App\Tests;

class ImageControllerTest extends WebTestCase
{
    /** @test */
    public function it_will_return_an_image_of_the_specified_size()
    {
        $width = 40;
        $height = 30;

        $client = $this->createClient();

        $client->request('GET', "/{$width}/{$height}");

        $response = $client->getResponse();

        $image = $this->app['intervention.image']->make(
            $response->getContent()
        );

        $this->assertEquals($width, $image->width());
        $this->assertEquals($height, $image->height());
    }
}
