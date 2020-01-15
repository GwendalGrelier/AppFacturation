<?php

class SecurityModel extends Model
{

    /**
     * Tries to login the admin to get acces to all the cruds
     *
     * @return void
     */
    public function login()
    {
        
        if (isset($_POST) && !empty($_POST["username"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $request = $this->connexion->prepare("SELECT * FROM client WHERE nom_societe=:username and password=:password");
            $request->bindParam(':username', $username);
            $request->bindParam(':password', $password);

            $result = $request->execute();
            $client = $request->fetch(PDO::FETCH_ASSOC);

            if ($client) {
                $_SESSION['user']["name"] = $client['nom_societe'];
                $_SESSION['user']["id"] = $client['id'];
                $_SESSION['user']["rank"] = $client['rank'];
            } else if ($username == "admin" && $password == "1234") {
                $_SESSION['user']['name'] = "Admin";
                $_SESSION['user']['id'] = "0";
                $_SESSION['user']['rank'] = "1";
                return true;
            } else {
                return false;
            }
        }
    }


    public function logout()
    {
        unset($_SESSION['user']);
    }

    /**
     * Logs in the visitor to the web site 
     * 
     * He will be able to see his quotes and bills
     *
     * @param int $clientId
     * @return void
     */
    public function loginVisitor($clientId)
    {
        $_SESSION['user'] = $clientId;
    }
}
