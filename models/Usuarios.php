<?php
class Usuarios extends model { 
    public function select($id){

        $sql = "SELECT 
                    u.idUsuarios, 
                    u.nome, 
                    u.telefone, 
                    u.cpf, 
                    u.email, 
                    u.endereco, 
                    u.senha, 
                    u.tipoUsuario, 
                    m.idMedicos, 
                    m.crm, 
                    f.idFarmaceuticos, 
                    f.crf FROM usuarios AS u 
                LEFT JOIN medicos AS m ON m.idUsuarios = u.idUsuarios 
                LEFT JOIN farmaceuticos AS f ON f.idUsuarios = u.idUsuarios 
                WHERE u.idUsuarios = ".$id."";
        
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0){
            $sql = $sql->fetch();
            return $sql;
        }
    }

    public function selectCPF($cpf){

        $sql = "SELECT
                    *
                FROM usuarios
                WHERE cpf = '".$cpf."'";
        
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0){
            $sql = $sql->fetch();
            return $sql;
        }
    }

    public function selectIdReceita($idReceita){

        $sql = "SELECT
                    u.idUsuarios,
                    u.nome, 
                    u.telefone,
                    u.cpf,
                    u.email,
                    u.endereco,
                    u.senha,
                    u.tipoUsuario
                FROM usuarios AS u
                LEFT JOIN receitas AS r ON u.idUsuarios = r.idUsuario
                WHERE r.idReceitas = ".$idReceita."";
        
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0){
            $sql = $sql->fetch();
            return $sql;
        }
    }

    public function selectAll(){
        $sql = "SELECT
                    users.IDUSER,
                    users.NOME,
                    users.EMAIL
                FROM users
                ORDER BY users.NOME";

        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0){
            $sql = $sql->fetchAll();
            return $sql;
        }
    }

    public function insert($data = array()){ 
        $sql = "INSERT INTO usuarios (nome, telefone, cpf, email, endereco, senha, tipoUsuario) 
                VALUES (:NOME, :TELEFONE, :CPF, :EMAIL, :ENDERECO, :SENHA, :TIPOUSUARIO)";
		$sql = $this->db->prepare($sql);
		
        $sql->bindValue(":NOME",        $data['nome']);
        $sql->bindValue(":TELEFONE",    $data['telefone']);
        $sql->bindValue(":CPF",         $data['cpf']);
        $sql->bindValue(":EMAIL",       $data['email']);
        $sql->bindValue(":ENDERECO",    $data['endereco']);
        $sql->bindValue(":SENHA",       $data['pass']);
        $sql->bindValue(":TIPOUSUARIO", $data['tipoUsuario']);

        if ($sql->execute()){
            $lastUsuarioID = $this->db->lastInsertId();
            return $lastUsuarioID;

		}else{
            return "Falha na inserção do usuário";
        }
    }

    public function insertMedicos($data = array()){ 
        $sql = "INSERT INTO medicos (idUsuarios, crm) 
                VALUES (:IDUSUARIOS, :CRM)";
		$sql = $this->db->prepare($sql);
		
        $sql->bindValue(":IDUSUARIOS",  $data['idUsuarios']);
        $sql->bindValue(":CRM",         $data['crm']);

        if ($sql->execute()){
            $lastMedicosID = $this->db->lastInsertId();
            return $lastMedicosID;

		}else{
            return "Falha na inserção do médico";
        }
    }

    public function insertFarmaceuticos($data = array()){ 


        $sql = "INSERT INTO farmaceuticos (idUsuarios, crf) 
                VALUES (:IDUSUARIOS, :CRF)";
		$sql = $this->db->prepare($sql);
		
        $sql->bindValue(":IDUSUARIOS",  $data['idUsuarios']);
        $sql->bindValue(":CRF",         $data['crf']); 

        if ($sql->execute()){
            $lastFarmaceuticosID = $this->db->lastInsertId();
            return $lastFarmaceuticosID;

		}else{
            return "Falha na inserção do farmaceutico";
        }
    }

    /*
    public function update($data = array()){ 
        $sql = "UPDATE users
                SET NOME = :NOME, 
                    EMAIL = :EMAIL
                WHERE IDUSER = :iduser";
        $sql = $this->db->prepare($sql);

        $sql->bindValue(":NOME",    $data['nome']);
        $sql->bindValue(":EMAIL",   $data['email']);
        $sql->bindValue(":iduser",  $data['iduser']);


        if($sql->execute()){
            $alerta = new Core();
            $alerta->setAlerta('success', 'Informações gravadas com sucesso');
        }else{
            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha ao realizar operação no banco de dados. Informe ao suporte o erro: ', '', $erros);
        }
    }

    public function updateSenha($data = array()){ 
        $sql = "UPDATE users
                SET SENHA = :SENHA
                WHERE IDUSER = :iduser";
        $sql = $this->db->prepare($sql);

        $sql->bindValue(":SENHA",   $data['senha']);
        $sql->bindValue(":iduser",  $data['iduser']);


        if($sql->execute()){
            $alerta = new Core();
            $alerta->setAlerta('success', 'Informações gravadas com sucesso');
        }else{
            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha ao realizar operação no banco de dados. Informe ao suporte o erro: ', '', $erros);
        }
    }

    public function delete($id){
        $sql = $this->db->prepare("DELETE FROM users WHERE IDUSER = :iduser");
        $sql->bindValue(':iduser', $id);

        if ($sql->execute()) {
            $alerta = new Core();
            $alerta->setAlerta('success', 'Informações gravadas com sucesso');
        } else {
            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha ao realizar operação no banco de dados. Informe ao suporte o erro: ', 'candidato', $sql->errorInfo());
        }
    }


    public function updateToken($id, $token){
        $sql = "UPDATE users
                SET TOKEN = :TOKEN
                WHERE IDUSER = :iduser";
		$sql = $this->db->prepare($sql);

        $sql->bindValue(":TOKEN",   $token);
        $sql->bindValue(":iduser",  $id);
        
		if ($sql->execute()){
            $alerta = new Core();
            $alerta->setAlerta('success', 'Informações gravadas com sucesso');
		}else{
            $alerta = new Core();
            $alerta->setAlerta('danger', 'Falha ao realizar operação no banco de dados. Informe ao suporte o erro: ', '', $sql->errorInfo());
        }
    }


    public function selectToken($token){
        $sql = "SELECT 
            users.IDUSER,
            users.EMAIL
        FROM users
        WHERE TOKEN = '".$token."'";
        
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0){
            $usuario = $sql->fetch();
            return $usuario;
        }
    }

    public function selectEsqueciSenha($filtros) {
        $sql = "SELECT 
            users.IDUSER,
            users.EMAIL
        FROM users
         WHERE users.EMAIL = '".$filtros['email']."'";
        
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0){
            $usuario = $sql->fetch();
            return $usuario;
        }
    }


    public function checkEmailsCadastrados($email){
        $sql = "SELECT *
                FROM users
                WHERE users.EMAIL = '".$email."'";
        
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0){
            return false;
        }else{
            return true;
        }
    }
    */
}