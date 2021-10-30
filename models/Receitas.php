<?php
class Receitas extends model { 
    public function select($id){

        $sql = "SELECT
                    *
                FROM usuarios
                WHERE idUsuarios = ".$id."";
        
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
    
    public function selectReceitasUsuario($idUsuario){
        $sql = "SELECT 
                    r.idReceitas, 
                    r.status, 
                    r.anexo, 
                    u.nome AS nomeMedico 
                FROM `receitas` AS r 
                LEFT JOIN `medicos` AS m ON r.idMedico = m.idMedicos 
                LEFT JOIN `usuarios` AS u ON m.idUsuarios = u.idUsuarios 
                WHERE r.idUsuario = ".$idUsuario."";

        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0){
            $sql = $sql->fetchAll();
            return $sql;
        }
    }

    public function insert($data = array()){ 
        
        $sql = "INSERT INTO receitas (idMedico, idUsuario, status, anexo) 
                VALUES (:IDMEDICO, :IDUSUARIO, :STATUS, :ANEXO)";
		$sql = $this->db->prepare($sql);
		
        $sql->bindValue(":IDMEDICO",    $data['idMedico']);
        $sql->bindValue(":IDUSUARIO",   $data['idUsuario']);
        $sql->bindValue(":STATUS",      $data['status']);
        $sql->bindValue(":ANEXO",       $data['anexo']);

        if ($sql->execute()){
            $lastReceitasID = $this->db->lastInsertId();
            return $lastReceitasID;

		}else{
            return "Falha na inserção da receita";
        }
    }

    public function updateStatus($idReceita){

        $sql = "UPDATE receitas 
                SET status = 'baixada'
                WHERE idReceitas = ".$idReceita."";
        
        $sql = $this->db->query($sql);
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