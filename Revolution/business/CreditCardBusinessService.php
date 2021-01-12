<?php

session_start();

include_once '../../data/CreditCardDataService.php';

class CreditCardBusinessService
{
    private $service;
    
    function __construct()
    {
        $dataService = new CreditCardDataService();
        $this->service = $dataService;
    }
    
    public function createCard(CreditCard $card)
    {
        $currentUser = $_SESSION['currentUser'];
        $userId = $currentUser->getIdNum();
        return $this->service->createCreditCard($card, $userId);
    }
    
    public function updateCard(CreditCard $card, int $cardId)
    {
        return $this->service->updateCard($card, $cardId);
    }
    
    public function deleteCard(int $cardId)
    {
        return $this->service->deleteCard($cardId);
    }
    
    public function viewAllCards()
    {
        return $this->service->viewAllCards();
    }
    
    public function viewCardById(int $cardId)
    {
        return $this->service->viewCardByID($cardId);
    }
    
    public function viewCardByUserId(int $userId)
    {
        return $this->service->viewCardByUserID($userId);
    }
}