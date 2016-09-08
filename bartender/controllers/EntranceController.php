<?php

class EntranceController extends Controller {
  public function __construct($server, $request) {
    parent::__construct($server, $request);
  }

  public function GET() {
    $newpage = new View('entrance');
    $parameters = array();
    $newpage->render($parameters);
  }
}