<?php

namespace App\Repositories;

use App\Domain\Models\Grupo;
use App\Domain\Interfaces\IGrupoRepository;

class GrupoRepository extends GenericoRepository implements IGrupoRepository
{
    public function __construct(Grupo $grupo) {
        parent::__construct($grupo);
    }

    // Aqui adicionamos metodos especificos para o grupo, se necessario
}
