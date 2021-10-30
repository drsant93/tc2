<?php
class loginController extends controller{
    public function index(){
        
        $this->loadTemplate('login');
    }

    public function login(){ 

        $login = new Login();

        if(isset($_POST['email']) && !empty($_POST['email']) ){

            $filtros['email'] = $_POST['email'];
            $filtros['pass'] = $_POST['pass'];
            
            $user = array();
            $user = $login->getUsers($filtros);

            if (count($user) > 0){
                if (password_verify($filtros['pass'], $user['senha'])){
                
                    $_SESSION['civilLogado'] = true;

                    $_SESSION['civil'] = $user;
                    
                    header('Location: '.BASE_URL.'receitas');
                    
                }else{
                    $alerta = new Core();
                    $alerta->setAlerta('danger', 'Falha no login');
                    $this->loadTemplate('login');
                }
            }else{
                $alerta = new Core();
                $alerta->setAlerta('danger', 'Falha no login');
                $this->loadTemplate('login');
            }
        }else{

            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha no login');
            $this->loadTemplate('login');
        }
    }

    public function logout(){ 

        session_unset();
		session_destroy();


        $alerta = new Core();
        $alerta->setAlerta('success', 'Sessão encerrada');

		header('Location: '.BASE_URL);
    }

}