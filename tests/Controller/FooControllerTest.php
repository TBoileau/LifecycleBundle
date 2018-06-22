<?php
/**
 * Created by PhpStorm.
 * User: tboileau-desktop
 * Date: 08/05/18
 * Time: 02:41
 */

namespace TBoileau\LifecycleBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class FooControllerTest extends WebTestCase
{
    public function testFoo()
    {
        $client = static::createClient();
        $client->request('GET', '/show');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/redirect');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $client->request('GET', '/granted');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());

        $client->request('GET', '/fail');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}