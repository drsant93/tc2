<?php
class Login extends model{

	public function getUsers($filtros = array()){
		if (isset($filtros['email']) && !empty($filtros['email'])){
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
                    WHERE email = '".$filtros['email']."'";
            $sql = $this->db->query($sql);

            if ($sql->rowCount() > 0) {
                $sql = $sql->fetch();
                return $sql;
            }else{
                echo "Email não encontrado";
                return array();
            }
		}
    }

}