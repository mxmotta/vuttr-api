<?php
 
namespace Tests;

use App\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

 
class ApiTestCase extends TestCase
{
    use DatabaseTransactions;
    
    protected $headers = [];
    protected $url_base = '/api/v1';
    
    public function setUp() : void
    {
        parent::setUp();
        
        $this->headers['Content-Type'] = 'application/json';
        $this->headers['Accept'] = 'application/json';
    }

    public function get($uri, array $headers = [])
    {
        $server = $this->transformHeadersToServerVars($headers);
        $cookies = $this->prepareCookiesForRequest();

        return $this->call('GET', $this->url_base.$uri, [], $cookies, [], $server);
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        $server = $this->transformHeadersToServerVars($headers);
        $cookies = $this->prepareCookiesForRequest();

        return $this->call('POST', $this->url_base.$uri, $data, $cookies, [], $server);
    }
}