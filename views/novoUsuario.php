
<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<form class="login100-form validate-form" action="<?php echo BASE_URL?>usuarios/addNovo" method="POST">
				<span class="login100-form-title p-b-26">
					Cadastro de Usuário
				</span>

				<!--Cadastro Generico-->
				<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="nome">
					<span class="focus-input100" data-placeholder="Nome"></span>
				</div>
				<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="cpf">
					<span class="focus-input100" data-placeholder="CPF"></span>
				</div>
				<div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
					<input class="input100" type="text" name="email">
					<span class="focus-input100" data-placeholder="Email"></span>
				</div>
				<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="telefone">
					<span class="focus-input100" data-placeholder="Telefone"></span>
				</div>

				<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="endereco">
					<span class="focus-input100" data-placeholder="Endereço, número"></span>
				</div>

				<p class="tipodeusuario">Tipo de usuário</p>
				<select class="form-select" aria-label="Tipo de usuário" name="tipoUsuario" onchange="tipoUsuarioToggle()" id="tipoUsuario">
					<option selected>Selecione</option>
					<option value="medico">Médico</option>
					<option value="farmaceutico">Farmacêutico</option>
					<option value="paciente">Paciente</option>
				</select>

				
				

				

				<!--cadastro medico-->
				<div class="wrap-input100 validate-input" id="divCRM" style="display: none">
					<input class="input100" type="text" name="crm">
					<span class="focus-input100" data-placeholder="CRM"></span>
				</div>

				<div class="wrap-input100 validate-input" id="divCRF" style="display: none">
					<input class="input100" type="text" name="crf">
					<span class="focus-input100" data-placeholder="CRF"></span>
				</div>

				<!--senha-->
				<div class="wrap-input100 validate-input" data-validate="Enter password">
					<span class="btn-show-pass">
						<i class="zmdi zmdi-eye"></i>
					</span>
					<input class="input100" type="password" name="pass">
					<span class="focus-input100" data-placeholder="Senha"></span>
				</div>
				<div class="wrap-input100 validate-input" data-validate="Enter password">
					<span class="btn-show-pass">
						<i class="zmdi zmdi-eye"></i>
					</span>
					<input class="input100" type="password" name="pass">
					<span class="focus-input100" data-placeholder="Confirme a senha"></span>
				</div>

				<div class="container-login100-form-btn">
					<div class="wrap-login100-form-btn">
						<div class="login100-form-bgbtn"></div>
						<button class="login100-form-btn">
							Salvar
						</button>
					</div>
				</div>
				<div class="text-center p-t-115">
					<a class="txt2" href="<?php echo BASE_URL?>usuarios/login">
						Voltar
					</a>
				</div>
				<div class="text-center">
					<a class="txt1" href="#">
						Versão 01.00.01
					</a>
				</div>
			</form>
		</div>
	</div>
</div>
<script>

	function tipoUsuarioToggle(){
		var radio = document.getElementById("tipoUsuario")
		var crm = document.getElementById("divCRM")
		var crf = document.getElementById("divCRF")

		if(radio.value == "medico"){
			crm.style.display = "block";
			crf.style.display = "none";
			

		}
		if(radio.value == "farmaceutico"){
			crf.style.display = "block";
			crm.style.display = "none";

		}
		if(radio.value == "paciente"){
			crf.style.display = "none";
			crm.style.display = "none";

		}
	}	
</script>

<?php $this->loadAlert() ?>