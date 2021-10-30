<?php
class usuariosController extends controller{
    public function index(){
        
        $this->loadTemplate('usuarios');
    }

    public function novo(){ 

        $this->loadTemplate('novoUsuario');
    }

    public function addNovo(){ 


        //echo "<pre>";
        //print_r($_POST);
        //die;


        $usuarios = new Usuarios();

        $dados = $_POST;
        $dados['pass'] = password_hash($dados['pass'], PASSWORD_BCRYPT);
        
        $dados['idUsuarios'] = $usuarios->insert($dados);

        if($dados['idUsuarios'] != 'Falha na inserção do usuário') {
            if($dados['tipoUsuario'] == "medico"){
                $usuarios->insertMedicos($dados);
            }
            if($dados['tipoUsuario'] == "farmaceutico"){
                $usuarios->insertFarmaceuticos($dados);
            }

            $alerta = new Core();
            $alerta->setAlerta('success', 'Usuário criado com sucesso');
            header('Location: '.BASE_URL);
        } else{
            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha na inserção de usuário');
            $this->loadTemplate('novoUsuario');
        }
        
    }


}