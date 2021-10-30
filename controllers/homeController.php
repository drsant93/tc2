<?php
class homeController extends controller{
    public function index(){
        if(isset($_SESSION['civil']) && !empty($_SESSION['civil'])){
            $this->loadTemplate('home');
        }else{
            header('Location: '.BASE_URL.'login');
        }
        
    }

}