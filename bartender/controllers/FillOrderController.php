<?php

class FillOrderController extends Controller {
  public function __construct($server, $request) {
    parent::__construct($server, $request);
  }
  
  public function GET() {
    $page = new View('fillorders');
    $model = new Model($this->db, 'item_order');
    $orders = $model->get('yes');
    $page->render(array('orders' => $orders));
  }
  
  public function POST() {
    $order = array('id' => $this->request['id'], 'fill_status' => $this->request['status']);
    $model = new Model($this->db, 'item_order');
    $model->update($order);
    $this->GET();
  }
}