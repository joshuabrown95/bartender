<?php

class ErrorController extends Controller {
  public function __construct($server, $request) {
    parent::__construct($server, $request);
  }
  
  public function GET() {
    $newpage = new View('not_found');
    http_response_code(404);
  }
}