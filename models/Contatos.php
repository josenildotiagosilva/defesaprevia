<?php
class Contatos extends model {

	public function getAll() {
		$array = array();

		$sql = "SELECT * FROM defesaprevia ORDER BY id DESC LIMIT 5";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}

	public function getAll2() {
		$array = array();

		$sql = "SELECT * FROM defesaprevia";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}

	public function get($id) {
		$array = array();

		$sql = "SELECT * FROM usuarios WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function get2($id) {
		$array = array();

		$sql = "SELECT * FROM defesaprevia WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function add($nome, $email) {
		if($this->emailExists($email) == false) {
			//$sql = "INSERT INTO contatos (nome, email) VALUES (:nome, :email)";
			$sql = "INSERT INTO defesaprevia SET requerente = :requerente, processo = :processo, 
                                    penalidade = :penalidade, autos = :autos, 
                                    veiculo_modelo = :veiculo_modelo, placa = :placa, 
                                    cor = :cor, ano_fab = :ano_fab, dos_fatos = :dos_fatos, 
                                    dos_meritos = :dos_meritos, decisao = :decisao, 
                                    estatos = :estatos";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':nome', $nome);
			$sql->bindValue(':email', $email);
			$sql->execute();

			return true;
		} else {
			return false;
		}
	}

	public function addDefesa($requerente, $processo, $penalidade, $autos, $artigo, $cod_infra, $veiculo_modelo, 
							$placa, $uf, $cor, $ano_fab, $dos_fatos, $dos_meritos, $decisao, 
							$estatos, $operador) {
		$sql = "INSERT INTO defesaprevia SET requerente = :requerente, processo = :processo, 
									penalidade = :penalidade, autos = :autos, artigo = :artigo, 
									cod_infra = :cod_infra, veiculo_modelo = :veiculo_modelo, placa = :placa, uf = :uf, 
									cor = :cor, ano_fab = :ano_fab, dos_fatos = :dos_fatos, 
									dos_meritos = :dos_meritos, decisao = :decisao, 
									estatos = :estatos, operador = :operador";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':requerente', $requerente);
			$sql->bindValue(':processo', $processo);
			$sql->bindValue(':penalidade', $penalidade);
			$sql->bindValue(':autos', $autos);
			$sql->bindValue(':artigo', $artigo);
			$sql->bindValue(':cod_infra', $cod_infra);
			$sql->bindValue(':veiculo_modelo', $veiculo_modelo);
			$sql->bindValue(':placa', $placa);
			$sql->bindValue(':uf', $uf);
			$sql->bindValue(':cor', $cor);
			$sql->bindValue(':ano_fab', $ano_fab);
			$sql->bindValue(':dos_fatos', $dos_fatos);
			$sql->bindValue(':dos_meritos', $dos_meritos);
			$sql->bindValue(':decisao', $decisao);
			$sql->bindValue(':estatos', $estatos);
			$sql->bindValue(':operador', $operador);
			$sql->execute();
			if ($sql->rowCount() > 0 ) {
				$_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>Adicionado com sucesso!
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
				</div>";
				header("Location: http://localhost/defesaprevia/home");
				return true;
			} else {
				$_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>Não foi possivel inserir!
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
				</div>";
				header("Location: http://localhost/defesaprevia/home");
				return false;
			}
	}

	public function edit($nome, $id) {
		$sql = "UPDATE contatos SET nome = :nome WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':id', $id);
		$sql->execute();
	}

	public function delete($id) {
		$sql = "DELETE FROM contatos WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
	}

	private function emailExists($email) {
		$sql = "SELECT * FROM contatos WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':email', $email);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function login($email, $senha){
        $sql = $this->db->prepare("SELECT id FROM usuarios WHERE email = :email AND senha = :senha");
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", md5($senha));
		$sql->execute();

		if($sql->rowCount() > 0) {
			$dado = $sql->fetch();
			$_SESSION['login'] = $dado['id'];
			$_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>Logado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
			return true;
		} else {
			$_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>E-mail e/ou senha inválido!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
			</div>";
			return false;
		}
    }
}