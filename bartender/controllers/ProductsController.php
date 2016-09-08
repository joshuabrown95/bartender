<?php

class ProductsController extends Controller {
  public function __construct($server, $request) {
    parent::__construct($server, $request);
  }
  
  public function GET() {
    $page = new View('products');
    $model = new Model($this->db, 'catalog_item');
    $items = $model->get();
    $page->render(array('items' => $items));
  }
  
  public function POST() {
    $order = array('item_id' => $this->request['id']);
    $model = new Model($this->db, 'item_order');
    $model->insert($order);
    $this->GET();
  }
}