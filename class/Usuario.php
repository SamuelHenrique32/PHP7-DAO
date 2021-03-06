<?php

    class Usuario{
        private $idusuario;
        private $deslogin;
        private $dessenha;
        private $dtcadastro;


        public  function getIdusuario(){
            return $this->idusuario;
        }

        public function setIdusuario($idusuario){
            $this->idusuario = $idusuario;
        }

        public function getDeslogin(){
            return $this->deslogin;
        }

        public function setDeslogin($deslogin){
            $this->deslogin = $deslogin;
        }

        public function getDessenha(){
            return $this->dessenha;
        }

        public function setDessenha($dessenha){
            $this->dessenha = $dessenha;
        }

        public function getDtcadastro(){
            return $this->dtcadastro;
        }

        public function setDtcadastro($dtcadastro){
            $this->dtcadastro = $dtcadastro;
        }

        //carrega dados do banco para o obj
        public function loadById($id){
            $sql = new Sql();

            $results = $sql->select("select * from tb_usuarios where idusuario = :ID", array(
                ":ID"=>$id
            ));

            if(count($results) > 0){
                $this->setData($results[0]);
            }
        }

        //lista com todos usuarios da tabela
        //nao sera instanciado
        public static function getList(){
            $sql = new Sql();
            return $sql->select("select * from tb_usuarios order by deslogin;");
        }

        public static function search($login){
            $sql = new Sql();
            return $sql->select("select * from tb_usuarios where deslogin like :SEARCH order by deslogin", array(
                ':SEARCH'=>"%".$login."%"
            ));
        }

        public function login($login, $password){
            $sql = new Sql();

            $results = $sql->select("select * from tb_usuarios where deslogin = :LOGIN and dessenha = :PASSWORD", array(
                ":LOGIN"=>$login,
                ":PASSWORD"=>$password
            ));

            if(count($results) > 0){
                $this->setData($results[0]);
            } else{
                throw new exception("Login e/ou senha inválidos!");
            }
        }

        public function setData($data){
            $this->setIdusuario($data['idusuario']);
            $this->setDeslogin($data['deslogin']);
            $this->setDessenha($data['dessenha']);
            $this->setDtcadastro(new DateTime($data['dtcadastro']));

        }

        public function insert(){
            $sql = new Sql();
            //usa procedure
            $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
                ':LOGIN'=>$this->getDeslogin(),
                ':PASSWORD'=>$this->getDessenha()
            ));

            if(count($results)>0){
                $this->setData($results[0]);
            }
        }

        public function update($login , $password){

            $this->setDeslogin($login);
            $this->setDessenha($password);

            $sql = new Sql();
            $sql-> query("update tb_usuarios set deslogin = :LOGIN, dessenha = :PASSWORD where idusuario = :ID", array(
                ':LOGIN'=>$this->getDeslogin(),
                ':PASSWORD'=>$this->getDessenha(),
                ':ID'=>$this->getIdusuario()

            ));
        }

        public function delete(){
            $sql = new Sql();
            $sql->query("delete from tb_usuarios where idusuario = :ID", array(
                ':ID'=>$this->getIdusuario()
            ));

            $this->setIdusuario(0);
            $this->setDeslogin("");
            $this->setDessenha("");
            $this->setDtcadastro(new DateTime());
        }

        //se nao chamar com construtor nao dara erro
        public function __construct($login = "", $password = ""){
            $this->setDeslogin($login);
            $this->setDessenha($password);
        }

        public function __toString(){
            return json_encode(array(
                "idusuario"=>$this->getIdusuario(),
                "deslogin"=>$this->getDeslogin(),
                "dessenha"=>$this->getDessenha(),
                "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
            ));
        }
    }

?>