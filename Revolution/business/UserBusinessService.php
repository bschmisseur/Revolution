<?php
include_once '../../data/UserDataService.php';

class UserBusinessService
{
    private $userDataService;
    
    function __construct()
    {
        $this->userDataService = new UserDataService();
    }
    
    public function createUser(User $user)
    {
        return $this->userDataService->createUser($user);
    }
    
    public function updateUser(User $user)
    {
        return $this->userDataService->updateUser($user, $user->getIdNum());
    }
    
    public function deleteUser()
    {
        $currentUserID = $_SESSION['currentUser']->getIdNum();
        return $this->userDataService->deleteUser($currentUserID);
    }
    
    public function validateUser(User $user)
    {
        $validUser = false; 
        $userList = $this->userDataService->viewUsers();
        
        for($i = 0; $i < count($userList); $i++)
        {
            $currentUser = $userList[$i];
            
            if(strcmp($currentUser->getUserName(), $user->getUserName()) == 0 && strcmp($currentUser->getPassword(), $user->getPassword()) == 0)
            {
                $validUser = true;
                $_SESSION['currentUser'] = $currentUser;
            }
        }
        return $validUser;
    }
    
    public function viewAllUsers()
    {
        return $this->userDataService->viewUsers();
    }
    
    public function getPermission()
    {
        $currentUser = $_SESSION['currentUser'];
        $userId = $currentUser->getIdNum();
        return $this->userDataService->getPermission($userId);
    }
}