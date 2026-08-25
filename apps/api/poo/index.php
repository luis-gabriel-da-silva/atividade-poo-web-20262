<?php

require __DIR__ . '/classes/Pessoa.php';
require __DIR__ . '/classes/Aluno.php';
require __DIR__ . '/classes/Professor.php';
require __DIR__ . '/classes/Disciplina.php';
// $pessoa1 = new Pessoa();
// $pessoa1->nome = 'Pedro';
// $pessoa1->email = 'pedro@email.com';
// $pessoa1->telefone = '124135135';

// $aluno1 = new Aluno();
// $aluno1->nome = 'carlinhos maia';
// $aluno1->ra = '139135105';
// $aluno1->matriculas = ['Eng 2', 'Poo 2'];
// var_dump($aluno1);

$professor1 = new $Professor();
$professor1->nome = 'Prof A';
$professor1->email = 'profe@email.com';
$professor1->telefone = '1204912';
$professor1->titulacao = 'Mestre';

$disciplina1 = new Disciplina();
$disciplina1->nome = 'POO';

die;