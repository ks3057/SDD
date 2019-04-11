<?php
  // originally taken from here: http://coreymaynard.com/blog/creating-a-restful-api-with-php/
  
  abstract class RestService {
                                // path format is /<endpoint>/<arg0>/<arg1>
    protected $method   = '';   // GET, POST, PUT or DELETE
    protected $endpoint = '';   // the requested resource e.g. /files
    protected $args     = [];   // any add'l URI components after the endpoint has been removed
    protected $file     = null; // stores the input of the PUT request
    

    public function __construct() {
      $request = !empty( $_REQUEST["request"] ) ? $_REQUEST["request"] : "";
      $all_headers = getallheaders();
      $this->args = explode( "/", rtrim( $request, "/" ) );
      $this->endpoint = array_shift( $this->args );

      $this->method = $_SERVER["REQUEST_METHOD"];
      if ( $this->method === "POST" && array_key_exists( "HTTP_X_HTTP_METHOD", $all_headers ) ) {
        $this->method = $all_headers["HTTP_X_HTTP_METHOD"];
      }
    }
    
    /** 
     * publicly exposed method in the service's API to determine if the concrete class
     * implements a method for the endpoint that the client requested. If yes, 
     * it calls that method, otherwise a 404 response is returned
     */
    public function processAPI() {

      switch ( $this->method ) {
        // for POST and PUT requests, get the (JSON) data from the payload
        // php://input returns all raw request data
        // $_POST only includes application/x-www-form-urlencoded and multipart/form-data-encoded data
        // see: https://www.php.net/manual/en/wrappers.php.php
        case 'POST':
        case 'PUT':
          $request_data = file_get_contents( "php://input" );
          $this->request_data = json_decode( $this->_cleanInputs( $request_data ) );
        // for all methods, get and sanitize path (now query string) arguments
        case 'GET':
        case 'DELETE':
          $this->args = $this->_cleanInputs( $this->args );
          break;
        default:
          return $this->response( "Method $this->method not supported", 405 );
      }
      
      if ( method_exists($this, $this->endpoint) ) {
        return $this->{$this->endpoint}($this->args);
      }
      return $this->response("No Endpoints: $this->endpoint", 404);
    }

	  /** 
	   * handles returning the response to the client
	   */
    protected function response($data, $status = 200) {
      header( "HTTP/1.1 " . $status . " " . $this->_requestStatus( $status ) );
      header( "Content-Type: application/json" );
      
      // deal with errors
      if ( $status >= 400 ) {
        $data = [ "error" => $data ];
      }
      return json_encode( $data );
    }

	  /** 
	   * does some sanitization 
	   */
    private function _cleanInputs( $data ) {
      $clean_input = Array();
      if ( is_array( $data ) ) {
        foreach ( $data as $k => $v ) {
          $clean_input[$k] = $this->_cleanInputs( $v );
        }
      } 
      else {
        $clean_input = trim( strip_tags( $data ) );
      }
      return $clean_input;
    }

	  /** 
	   * creates an array of HTTP status codes
	   */
    private function _requestStatus($code ) {
      $status = array(  
        200 => 'OK',
        201 => 'Created',
        400 => 'Bad Request',
        404 => 'Not Found',   
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
      ); 
      return ( $status[$code] ) ? $status[$code] : $status[500]; 
    }
  }
?>