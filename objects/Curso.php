<?php

class Curso{
    private $conexao;

    private $id;
    private $nome;
    private $descricao;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }

    public function __construct($conexao){
        $this->conexao = $conexao;
    }

    // Faz o select de curso
    public function read($id = null){
        $sql = "select * from curso ";

        if(isset($id)){
            $sql .= " where id=:id ";
        }

        $sql .= " order by nome ";

        $stmt = $this->conexao->prepare($sql);

        if(isset($id)){
            $stmt->bindParam(':id',$id);
        }
        try{
            $stmt->execute();
        } catch(PDOException $e){
            throw $e;
        }

        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $cursos;
    }

    // Faz o insert de curso
    public function insert(){
        $sql = "insert into curso (nome,descricao) values (:nome,:descricao)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(':nome',$this->nome);
        $stmt->bindValue(':descricao',$this->descricao);
        try{
            $stmt->execute();
        } catch(PDOException $e){
            throw $e;
        }
       
    }

    // Faz o update de curso
    public function update(){
        $sql = "update curso set nome=:nome, descricao=:descricao where id=:id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(':id',$this->id);
        $stmt->bindValue(':nome',$this->nome);
        $stmt->bindValue(':descricao',$this->descricao);

        try{
            $stmt->execute();
        } catch(PDOException $e){
            throw $e;
        }
    }

    // Faz o delete de curso
    public function delete(){
        $sql = "delete from curso where id=:id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(':id',$this->id);

        try{
            $stmt->execute();
        } catch(PDOException $e){
            throw $e;
        }
    }
}