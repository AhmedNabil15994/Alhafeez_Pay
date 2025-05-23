<?php
namespace App\Tocaan\Payments\Core;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use App\Tocaan\Payments\traits\ErrorsHandler;
use Illuminate\Http\Client\ConnectionException;

class Client
{
    use ErrorsHandler;

    private string $base_url;
    private $connection_attempts = 1;
    private $connection_timeout = 100;
    public string $method = 'POST';
    private $response;
    private null|string|array $fields;
    private string $auth_type; //basic_auth , bearer or fields
    private array $credentials;
    public bool $sandbox;

    /**
     * Chain 1
     * Auth merchant & auth type
     * @var string $type, like e.g: basic_auth, bearer etc..
     * @var array $credentials
     */
    public function auth(string $type, array $credentials)
    {
        $this->auth_type = $type;
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * Chain 2
     * Setup the gateway (driver) URL
     * @var string $url
     */
    public function url($url)
    {
        $this->base_url = $url;
        return $this;
    }

    /**
     * Chain 3-1
     * Method POST
     * @var null|string|array $fields string for json
     */
    public function post(null|string|array $fields)
    {
        $this->method = 'POST';
        $this->fields = $fields;
        return $this;
    }

    /**
     * Chain 3-2
     * Method GET
     * @var null|array $fields string for json
     */
    public function get(null|string|array $fields)
    {
        $this->method = 'GET';
        $this->fields = $fields;
        return $this;
    }

    /**
     * Chain 3-3
     * Method PUT
     * @var null|array $fields string for json
     */
    public function put(null|string|array $fields)
    {
        $this->method = 'PUT';
        $this->fields = $fields;
        return $this;
    }

    /**
     * Connect using GuzzleClient
     * Using rescue to be in control of exceptions
     */
    public function connect()
    {
        return rescue( fn() => $this->request(), fn() => $this->failure() );
    }

    /**
     * Making request...
     */
    protected function request()
    {
        if( !filter_var($this->base_url, FILTER_VALIDATE_URL) )
        {
            $this->throw('Given URL is not correct!');
        }

        //setup the request
        $this->client = Http::asForm()->retry(
            $this->connection_attempts,
            $this->connection_timeout,
            function(\Exception $exception, PendingRequest $request) {
                return $exception instanceof ConnectionException;
            }
        );

        //set the authentication of request
        if( in_array($this->auth_type, ['basic_auth', 'basic', 'username_password']) )
        {
            $this->client->withBasicAuth($this->credentials['username'], $this->credentials['password'] ?? '');
        } else if( in_array($this->auth_type, ['bearer', 'token']) )
        {
            $this->client->withToken( config('payments.sandbox') ? $this->credentials['test_token'] : $this->credentials['live_token']);
        } else if( in_array($this->auth_type, ['body', 'fields']) )
        {
            $this->fields = array_merge($this->fields, $this->credentials);
        }
        //If fields are json
        if( !is_null($this->fields) && !is_array($this->fields) && $this->isJson($this->fields) )
        {
            $this->client->withBody($this->fields, 'application/json');
        }

        //setup the request method with fields
        switch ( Str::upper($this->method) )
        {
            case 'POST': $this->response = $this->client->post( $this->base_url, is_array($this->fields) ? $this->fields : '' ); break;
            case 'PUT': $this->response = $this->client->put( $this->base_url, is_array($this->fields) ? $this->fields : '' ); break;
            default: $this->response = $this->client->get( $this->base_url, is_array($this->fields) ? $this->fields : '' ); break;
        }

        return $this->response;
    }

    /**
     * Field response, stroe exception in log file
     */
    public function failure()
    {
        \File::append( storage_path('logs/payments-failure-'.date('Y-m-d').'.log'), json_encode($this->fields) );
    }

    protected function isJson($json)
    {
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
     }
}
