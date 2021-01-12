<?php
include 'business/UserBusinessService.php';

session_start();

echo "TEST FILE";

$userBusinessService = new UserBusinessService();
echo "Completed";

$user = new User("0", "John", "Smith", "jsmith", "password1", "jsmith@gmail.com", "1231231234", "0");
echo "created User";

if($userBusinessService->createUser($user))
{
    echo "Created User Successfully";
}

else
{
    echo "EROEOROREEOR";
}

if($userBusinessService->deleteUser())
{
    echo "Delete user successsfully";
    
}
else
{
    echo "dlkfjlaksdjfl";
}
