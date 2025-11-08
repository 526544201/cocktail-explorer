<?php
declare(strict_types=1);

namespace Tests\Service;

use App\Service\CocktailDbService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\TestCase;

class CocktailDbServiceTest extends TestCase
{
    private $clientMock;
    private $service;

    protected function setUp(): void
    {
        // create a mock for the Guzzle client so no real HTTP requests are made
        $this->clientMock = $this->createMock(Client::class);

        // use a dummy base URL for constructing the service
        $dummyBaseUrl = 'https://www.dummydummy123.de/api/json/v1/1/';

        // instantiate the service with the mocked client and dummy URL
        $this->service = new CocktailDbService($this->clientMock, $dummyBaseUrl);
    }

    // test the searchByName method for successful API response - only this function is tested
    // as an  example. Other methods like searchByIngredient, getDetailsById, getRandom
    // would have similar tests (except the data), as they use the same makeRequest() 
    // internally the same way.
    public function testSearchByNameReturnsDataOnSuccess(): void
    {
        // fake JSON payload returned by the API
        $fakeJson = '{
            "drinks": [
                {"idDrink": "11007", "strDrink": "Margarita"}
            ]
        }';
        
        // mock the response body stream and make getContents() return the fake JSON
        $streamMock = $this->createMock(Stream::class);
        $streamMock->method('getContents')->willReturn($fakeJson);
        
        // mock the HTTP response to return the mocked stream as the body
        $responseMock = $this->createMock(Response::class);
        $responseMock->method('getBody')->willReturn($streamMock);

        // configure the client mock to return the prepared response when request() is called
        $this->clientMock
            ->method('request')
            ->willReturn($responseMock);

        // call the service method under test
        $result = $this->service->searchByName('Margarita');

        // verify the result is parsed and contains expected data
        $this->assertNotNull($result);
        $this->assertIsArray($result);
        $this->assertEquals('11007', $result[0]['idDrink']);
    }

    public function testSearchByNameReturnsNullOnApiError(): void
    {
        // simulate an exception thrown by the HTTP client (e.g., network/API error)
        $this->clientMock
            ->method('request')
            ->willThrowException(new RequestException("API is down", new Request('GET', 'test')));

        // the service should handle the exception and return null
        $result = $this->service->searchByName('Margarita');

        $this->assertNull($result);
    }
}