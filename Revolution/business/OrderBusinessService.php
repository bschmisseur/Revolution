<?php

include_once '../../data/OrderDataService.php';

class OrderBusinessService
{
    private $service;
    
    function __construct()
    {
        $dataService = new OrderDataService();
        $this->service = $dataService;
    }
    
    public function viewAllOrders()
    {
        return $this->service->viewAllOrders();
    }
}