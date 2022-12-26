<?php

class Controller {
    private Model $model;
    public $viewName;

    function __construct(Model $m) {
        $this->model = $m;
        $this->process_request();
    }

    private function cleanup_uri($uri) {
        if($uri[strlen($uri) - 1] == '/') {
            return substr($uri, 0, strlen($uri) - 1);
        }

        return $uri;
    }

    public function process_request() {
        // $_SERVER["REQUEST_METHOD"] // POST / GET / DELETE

        $cleaned_uri = $this->cleanup_uri($_SERVER["REQUEST_URI"]);
        $switch_uri = strtok($cleaned_uri, "?");

        switch($switch_uri) {
            case "":
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        if (LOGGED_IN) {
                            // Redirect to spendings
                            header("Location: /spendings");
                            die();
                        }
                        
                        $this->viewName = "homepage";
                        break;
                    default:
                        $this->viewName = "not-found";
                        break;
                }
                break;
            case "/login":
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        // Show login page
                        $this->viewName = "login";
                        break;
                    case "POST":
                        // Login existing user
                        $userModel = $this->model->get_user_model();
                        $userModel->login();

                        // Redirect to spendings
                        header("Location: /spendings");
                        die();
                    default:
                        $this->viewName = "not-found";
                        break;
                }
                break;
            case "/register":
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        // Show registration page
                        $this->viewName = "register";
                        break;
                    case "POST":
                        // Register new user
                        $userModel = $this->model->get_user_model();
                        $userModel->register();

                        // Redirect to login page
                        header("Location: /login");
                        die();
                    default:
                        $this->viewName = "not-found";
                        break;
                }
                break;
            case "/spendings":
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $this->viewName = "spendings";
                        break;
                    case "POST":
                        switch($_POST["action"]) {
                            case "delete":
                                // Remove a purchase
                                $purchaseModel = $this->model->get_purchase_model();
                                $purchaseModel->removePurchase();
                                
                                
                                header("Location: /spendings");
                                die();
                            default:
                                $this->viewName = "not-found";
                                break;
                        }
                        break;
                    default:
                        $this->viewName = "not-found";
                        break;
                }
                break;
            case "/purchases":
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        $this->viewName = "purchases";
                        break;
                    case "POST":
                        // Register new purchase
                        $purchaseModel = $this->model->get_purchase_model();
                        $purchaseModel->makePurchase();

                        // Redirect to spendings page
                        header("Location: /spendings");
                        die();
                    default:
                        $this->viewName = "not-found";
                        break;    
                }
                break;
            case "/logout":
                switch($_SERVER["REQUEST_METHOD"]) {
                    case "GET":
                        session_destroy();
                        
                        // Redirect to homepage
                        header("Location: /");
                        die();
                    default:
                        $this->viewName = "not-found";
                        break;
                }
            default:
                $this->viewName = "not-found";
                break;
        }
    }
}