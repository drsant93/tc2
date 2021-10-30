<?php
class receitasController extends controller{
    public function index(){
        
        $usuarios = new Usuarios;
        
        $dados = $usuarios->select($_SESSION['civil']['idUsuarios']);
        
        if($dados['tipoUsuario'] == 'paciente'){
            $receitas = new Receitas;
            $dados['dadosPaciente'] = $dados;
            $dados['dadosPaciente']['receitas'] = $receitas->selectReceitasUsuario($dados['idUsuarios']);
        }
        
        $this->loadTemplate('receita', $dados);
    }

    public function consultaPaciente(){

        $usuarios = new Usuarios;
        
        $dados = $usuarios->select($_SESSION['civil']['idUsuarios']);
        
        if(isset($_POST['cpf'])){
            $receitas = new Receitas;
            $dados['dadosPaciente'] = $usuarios->selectCPF($_POST['cpf']);
            if(isset($dados['dadosPaciente']['idUsuarios'])){
                $dados['dadosPaciente']['receitas'] = $receitas->selectReceitasUsuario($dados['dadosPaciente']['idUsuarios']);
            }else{
                $alerta = new Core();
                $alerta->setAlerta('danger', 'Paciente não localizado.');
            }
        }else{
            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha no recebimento do formulário. Campo CPF.');
        }
        
        $this->loadTemplate('receita', $dados);
    }

    public function novo(){ 

        if (isset($_POST['cpf']) && isset($_FILES['receita']) ){
            if(isset($_FILES['receita']['tmp_name']) && !empty($_FILES['receita']['tmp_name'])){
                if($_FILES['receita']['error'] == 0){
                    
                    $receitas = new Receitas();
                    $usuarios = new Usuarios();
                    
                    //enviados pelo form
                    $dados = $_POST;
                    $arquivo = $_FILES['receita'];

                    //dados do paciente pelo cpf enviado no form
                    $dadosPaciente = $usuarios->selectCPF($dados['cpf']);
        
                    //gravação do arquivo
                    $ext = explode("/",$arquivo['type']);
                    $ext = $ext[1];
                    $novoNome = md5(time().rand(0,99)).'.'.$ext;
                    move_uploaded_file($arquivo['tmp_name'], 'receitas/'.$novoNome);
                    
                    $dados['idMedico'] = $_SESSION['civil']['idMedicos'];
                    $dados['idUsuario'] = $dadosPaciente['idUsuarios'];
                    $dados['status'] = "aberta";
                    $dados['anexo'] = $novoNome;

                    if(!$receitas->insert($dados)){
                        $alerta = new Core();
                        $alerta->setAlerta('danger', 'Falha na inserção da reeita.');
                    }
                    

                    
                    //reseta dados tela
                    $paciente =  $usuarios->selectCPF($dados['cpf']);
                    $dados = $usuarios->select($_SESSION['civil']['idUsuarios']);
                    $dados['dadosPaciente'] = $paciente;
                    $dados['dadosPaciente']['receitas'] = $receitas->selectReceitasUsuario($dados['dadosPaciente']['idUsuarios']);
                    

                    $this->loadTemplate('receita', $dados);
                }else{
                    $alerta = new Core();
                    $alerta->setAlerta('danger', 'Erro no recebimento do arquivo');
                    unlink($_FILES['receita']['tmp_name']);
                    header('Location: '.BASE_URL.'receitas');
                    exit;
                }                    
            }
        }else{
            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha no recebimento do formulário.');
            header('Location: '.BASE_URL.'receitas');
        }
    }

    public function addNovo(){ 

        $usuarios = new Usuarios();

        $dados = $_POST;
        $dados['pass'] = password_hash($dados['pass'], PASSWORD_BCRYPT);
        
        $dados['idUsuarios'] = $usuarios->insert($dados);

        if($dados['tipoUsuario'] == "medico"){
            $usuarios->insertMedicos($dados);
        }
        if($dados['tipoUsuario'] == "farmaceutico"){
            $usuarios->insertFarmaceuticos($dados);
        }


        header('Location: '.BASE_URL);

        /*
        //[nome] => 
        //[email] => 
        //[telefone] => 
        //[endereco] => 
        //[tipoUsuario] => medico
        //[crm] => 
        //[crf] => 
        //[pass] => 

        if($checkCampos === true){
            $candidato = new Candidatos();
            
            $dados['candidato'] = $_POST;
            
            $dados['candidato']['rg_orgao_emissor'] = $dados['candidato']['rg_orgao_emissor'].'/'.$dados['candidato']['rg_estado_emissor'];            
            
            $dados['candidato']['cnh'] = isset($dados['candidato']['cnh']) ? implode("", $dados['candidato']['cnh']) : '';

            $dados['candidato']['data_nascimento'] = substr($dados['candidato']['data_nascimento'], 6,4)."-".substr($dados['candidato']['data_nascimento'], 3,2)."-".substr($dados['candidato']['data_nascimento'], 0,2);

            $dados['candidato']['rg_data_emissao'] = substr($dados['candidato']['rg_data_emissao'], 6,4)."-".substr($dados['candidato']['rg_data_emissao'], 3,2)."-".substr($dados['candidato']['rg_data_emissao'], 0,2);

            $dados['candidato']['rg'] = str_replace('.','',$dados['candidato']['rg']);
            $dados['candidato']['rg'] = str_replace('-','',$dados['candidato']['rg']);

            $dados['candidato']['cpf'] = str_replace('.','',$dados['candidato']['cpf']);
            $dados['candidato']['cpf'] = str_replace('-','',$dados['candidato']['cpf']);


            foreach($dados['candidato'] as $key => $elemento){
                if(gettype($elemento) == "string" && $key != 'email'){
                    $dados['candidato'][$key] = mb_strtoupper($dados['candidato'][$key], 'UTF-8');
                }
            }
            
            $idCandidatoInserido = $candidato->insert($dados['candidato']);

            if(isset($idCandidatoInserido) && !empty($idCandidatoInserido)){
                $token = md5(time().rand(0,99));
                $candidato->updateToken($idCandidatoInserido, $token);

                $email = new emailController();
                $email->emailSetSenha($dados['candidato'], $token);

                header('Location: '.BASE_URL.'candidatos');
            }
            
            header('Location: '.BASE_URL.'candidatos');
        }else{
            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha nos dados recebidos no formulário. Verificar os campos: '. $checkCampos);
            header('Location: '.BASE_URL);
        }
        */


        
    }

    public function baixa($idReceita){ 

        $usuarios = new Usuarios();

        $receitas = new Receitas();
        $receitas->updateStatus($idReceita);





        //reseta dados tela
        $paciente = $usuarios->selectIdReceita($idReceita);
        
        $dados = $usuarios->select($_SESSION['civil']['idUsuarios']);
        $dados['dadosPaciente'] = $paciente;
        $dados['dadosPaciente']['receitas'] = $receitas->selectReceitasUsuario($dados['dadosPaciente']['idUsuarios']);

        $this->loadTemplate('receita', $dados);

        
    }
}