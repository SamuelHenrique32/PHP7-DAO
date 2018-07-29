<?php

    require_once ("config.php");

    /*$sql = new Sql();
    $usuarios = $sql->select("select * from tb_usuarios");
    echo json_encode($usuarios);*/

    /*carrega um usuario
    $root = new Usuario();
    $root->loadbyId(3);
    echo $root;*/

    //carrega uma lista de usuarios
   /* $lista = Usuario::getList();
    echo json_encode($lista);*/

   //carrega uma lista de usuarios buscando pelo login
   /* $search = Usuario::search("jo");
    echo json_encode($search);*/

   //carrega um usuario usando o login e a senha
    /*$usuario = new Usuario();
    $usuario->login("root", "789");
    echo $usuario;*/

    //insere aluno no banco
   /* $aluno = new Usuario("aluno", "123");
    $aluno->insert();
    echo $aluno;*/

   //altera um usuario
   /*$usuario = new Usuario();
   $usuario->loadById(8);
   $usuario->update("professor", "senha");
   echo $usuario;*/

    $usuario = new Usuario();
    $usuario->loadById(7);
    $usuario->delete();
    echo $usuario;
?>