<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FerramentaAnaliseController extends Controller
{
  //protected ExpressaoTesteController $exp;
  protected int $changeChor = 0;//iterar
  protected int $locaisEA_change = 0;//iterar
  protected int $s = 1; //índice do $chor a ser analizado
  protected string $ac; //caractere a analisar
  protected string $chor;

  protected TesteAnaliseController $teste;

  public function __contruct()
  {
    $this->teste = new TesteAnaliseController();
    //$this->exp = new ExpressaoTesteController();
  }
}
