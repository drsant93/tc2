
<div>
    <div class='topo-receitas'>
        <h1 class="align-middle">Controle de receitas</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="container">
                <div class="login-usuario row mt-3" >
                    <div class="col">
                        Login: <?php echo $viewData['nome']?>
                    </div>

                    <div class="col-3">
                        <a href="<?php echo BASE_URL?>login/logout" class="btn btn-danger w-100">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row ">
            <div class="col-5">

                <form class="container" method="POST" action="<?php echo BASE_URL?>receitas/consultaPaciente" >
                    <div class="form-group row mt-4">
                        <label for="cpf" class="col-sm-3 col-form-label">CPF:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cpf" name="cpf"
                                <?php echo ($viewData['tipoUsuario'] == 'paciente') ? ' readonly ' : '' ?>
                                value="<?php echo (isset($viewData['dadosPaciente'])) ? $viewData['dadosPaciente']['cpf'] : '' ?>" 
                            >
                        </div>
                        
                        <?php if($viewData['tipoUsuario'] != 'paciente'): ?>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary">Consultar</button>
                            </div>
                        <?php endif ?>
                    
                    </div>
                    <div class="form-group row">
                        <label for="nome" class="col-sm-3 col-form-label">NOME:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control " id="nome" readonly
                            value="<?php echo (isset($viewData['dadosPaciente'])) ? $viewData['dadosPaciente']['nome'] : '' ?>"
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefone" class="col-sm-3 col-form-label">TELEFONE:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control " id="telefone" readonly
                            value="<?php echo (isset($viewData['dadosPaciente'])) ? $viewData['dadosPaciente']['telefone'] : '' ?>"
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="endereco" class="col-sm-3 col-form-label">ENDEREÇO:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control " id="endereco" readonly
                                value="<?php echo (isset($viewData['dadosPaciente'])) ? $viewData['dadosPaciente']['endereco'] : '' ?>"
                            >
                        </div>
                    </div>
                </form>







            </div>

            <div class="col-7 mt-4">
                <table class="table table-striped">
                    <tr>
                        <th scope="col">ID RECEITA</th>
                        <th scope="col">MÉDICO</th>
                        <th scope="col">ANEXO</th>
                        <th scope="col">STATUS</th>
                    </tr>
                    <?php if (isset($viewData['dadosPaciente']['receitas'])) : ?>
                        <?php foreach ($viewData['dadosPaciente']['receitas'] as $receita) : ?>
                            <tr>
                                <td> <?php echo $receita['idReceitas'] ?> </td>
                                <td> <?php echo $receita['nomeMedico'] ?> </td>
                                <td>
                                <a href="<?php echo BASE_URL.'receitas/'.$receita['anexo'] ?>" 7
                                    class="btn btn-bordered" title="Receita">
                                    <i class="fas fa-edit text-warning "></i>
                                </a>    
                                </td>
                                <td> 
                                    <?php echo $receita['status'] ?> 

                                    <?php if ($viewData['tipoUsuario'] == 'farmaceutico' && $receita['status'] == "aberta")  : ?>
                                        <a class="btn btn-success" href="<?php echo BASE_URL.'receitas/baixa/'.$receita['idReceitas'] ?>">
                                            dar baixa
                                        </a>
                                    <?php endif ?>
                                    
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </table>
                

                <?php if($viewData['tipoUsuario'] == 'medico' && isset($viewData['dadosPaciente'])): ?>
                    <form class="container" method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL?>receitas/novo" >
                        <div class="form-group row mt-4">
                                
                            <div class="col-sm-8">
                                <input type="text" class="d-none" name="cpf" 
                                    value="<?php echo (isset($viewData['dadosPaciente'])) ? $viewData['dadosPaciente']['cpf'] : '' ?>"
                                >
                                <input id="receita" type="file" name="receita" class="form-control form-control-sm" title="Selecione a receita">
                            </div>

                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary">Adicionar receita</button>
                            </div>

                            
                        </div>
                        
                    </form> 

                <?php endif ?>

                
            </div>

        </div>


        
        <div class='bot-receitas'>
            
        </div>
    </div>
</div>

<?php $this->loadAlert() ?>