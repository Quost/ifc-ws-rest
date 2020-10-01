<?php

class Disciplina{
    private $conexao;

    private $id;
    private $codigo;
    private $nome;
    private $carga;
    private $ementa;
    private $semestre;
    private $idCurso;

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

    public function getCarga(){
        return $this->carga;
    }

    public function setCarga($carga){
        $this->carga = $carga;
    }

    public function getEmenta(){
        return $this->ementa;
    }

    public function setEmenta($ementa){
        $this->ementa = $ementa;
    }

    public function getSemestre(){
        return $this->semestre;
    }

    public function setSemestre($semestre){
        $this->semestre = $semestre;
    }

    public function getIdCurso(){
        return $this->idCurso;
    }

    public function setIdCurso($idCurso){
        $this->idCurso = $idCurso;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function __construct($conexao){
        $this->conexao = $conexao;
    }

    // Faz o select de disciplinas
    public function read($id = null){
        $sql = "select * from discipina ";

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

        $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $disciplinas;
    }

    // Faz o insert de disciplina
    public function insert(){
        $sql = "insert into discipina (codigo,nome,carga,ementa,semestre,id_curso) values (:codigo,:nome,:carga,:ementa,:semestre,:id_curso)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(':codigo',$this->codigo);
        $stmt->bindValue(':nome',$this->nome);
        $stmt->bindValue(':carga',$this->carga);
        $stmt->bindValue(':ementa',$this->ementa);
        $stmt->bindValue(':semestre',$this->semestre);
        $stmt->bindValue(':id_curso',$this->idCurso);

        try{
            $stmt->execute();
        } catch(PDOException $e){
            throw $e;
        }
    }

    // Faz o update de disciplina
    public function update(){
        $sql = "update discipina set codigo=:codigo,nome=:nome,carga=:carga,ementa=:ementa,semestre=:semestre,id_curso=:id_curso where id=:id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(':id',$this->id);
        $stmt->bindValue(':codigo',$this->codigo);
        $stmt->bindValue(':nome',$this->nome);
        $stmt->bindValue(':carga',$this->carga);
        $stmt->bindValue(':ementa',$this->ementa);
        $stmt->bindValue(':semestre',$this->semestre);
        $stmt->bindValue(':id_curso',$this->idCurso);

        try{
            $stmt->execute();
        } catch(PDOException $e){
            throw $e;
        }
    }

    // Faz o delete de disciplina
    public function delete(){
        $sql = "delete from discipina where id=:id";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(':id',$this->id);

        try{
            $stmt->execute();
        } catch(PDOException $e){
            throw $e;
        }
    }
}