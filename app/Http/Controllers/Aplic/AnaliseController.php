<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnaliseController extends FerramentaAnaliseController
{
  //private TextoController $cifra;

  public function __construct()
  {
    //$this->cifra = new CifraController();
  }

  public function analisar(array $array_chor){
    return $array_chor;
  }
}
