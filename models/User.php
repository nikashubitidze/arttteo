<?php
namespace models;

require_once ('.././helpers/helper.php');
require_once ('.././config/settings.php');
use http\Params;
use mysqli;

class User
{
    protected $email;
    protected $password;
    protected $with_db;

    public function __construct()
    {
        $this->with_db = WITH_DB;
    }

    protected $required_fields = [
      'email', 'password', 'repeat_password'
    ];

    protected $required_fields_login = [
        'email', 'password'
    ];

    /**
     * @param $request
     * @param false $with_db
     */
    public function register($request)
    {
        if (!validateRequirements($this->required_fields, $request)) {
            setSessionData(['register_status' => 400, 'register_message' => 'Please, fill up the form!']);
            redirect("http://localhost/arttteotask/pages/register.php");
        }

        if (!checkPasswordEquals($request)) {
            setSessionData(['register_status' => 400, 'register_message' => 'Passwords doesnt match']);
            redirect("http://localhost/arttteotask/pages/register.php");
        }

        $this->email = $request['email'];
        $this->password = $request['password'];

        if ($this->with_db) {
            if ($this->saveUserToDb($request)) {
                setSessionData(['register_status' => 200, 'register_message' => 'You registered successfully']);
            } else {
                setSessionData(['register_status' => 500, 'register_message' => 'Server Error! code 500, Please try Later']);
            }
        } else {
            setSessionData([
                'register_status' => 200,
                'register_message' => 'You registered successfully',
                'user_data' => ['email' => $this->email, 'password' => $this->password]
            ]);
        }
        redirect("http://localhost/arttteotask/pages/register.php");
    }

    /**
     * @param $request
     */
    public function login($request)
    {
        if (!validateRequirements($this->required_fields_login, $request)) {
            setSessionData(['login_status' => 400, 'login_message' => 'Please, fill up the form!']);
            redirect("http://localhost/arttteotask/pages/login.php");
        }
        $this->findUser($request);
    }

    /**
     * @param $request
     */
    protected function findUser($request)
    {

        if (!$this->with_db) {
            $this->checkUserInSession($request);
        } else {
            $this->getUserFromDb($request);
        }
    }

    /**
     * @param $user
     */
    protected function checkUserInSession($user)
    {

        if (!isset($_SESSION['user_data'])) {
            setSessionData(['login_status' => 400, 'login_message' => 'Please, Register first!']);
            redirect("http://localhost/arttteotask/pages/login.php");
        }
        if ($_SESSION['user_data']['email'] == $user['email']) {
            if ($_SESSION['user_data']['password'] == $user['password']) {
                setSessionData(['login_status' => 200, 'login_message' => 'You are successfully logged in', 'logged_user' => $user]);
                redirect("http://localhost/arttteotask/pages/index.php");
            } else {
                setSessionData(['login_status' => 400, 'login_message' => 'No user found, with this credentials!']);
                redirect("http://localhost/arttteotask/pages/login.php");
            }
        } else {
            setSessionData(['login_status' => 400, 'login_message' => 'No user found, with this credentials!']);
            redirect("http://localhost/arttteotask/pages/login.php");
        }
    }

    /**
     * @param $data
     * @return bool
     */
    protected function saveUserToDb($data)
    {
        $connection = connectToDb();
        $sql = $connection->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $sql->bind_param("ss", $data['email'], $data['password'] );
        $sql->execute();
        $sql->close();
        $connection->close();
        return true;
    }

    /**
     * @param $data
     */
    public function getUserFromDb($data)
    {
        $connection = connectToDb();
        $email = $data['email'];
        $password = $data['password'];
        $sql = "SELECT id, email, password FROM users WHERE email='$email' AND password='$password' ";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $res = $result->fetch_array();
            setSessionData(['login_status' => 200, 'login_message' => 'You are successfully logged in', 'logged_user' => ['email' =>$res['email']], 'password' => $res['password']]);
            redirect("http://localhost/arttteotask/pages/index.php");
        } else {
            echo "0 results";
        }
        $connection->close();
    }

}