<?php

namespace App\Domain\Interfaces;

interface IGenericoRepository
{
    public function listar();
    public function buscarPorId($id);
    public function adicionar(array $data);
    public function atualizar(array $data, $id);
    public function remover($id);
}
