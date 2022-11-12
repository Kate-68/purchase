<?php

class Model {
    public function get_user_model(): UserModel {
        require_once("user.php");
        return new UserModel();
    }
    
    public function get_purchase_model(): PurchaseModel {
        require_once("purchase.php");
        return new PurchaseModel();
    }
}