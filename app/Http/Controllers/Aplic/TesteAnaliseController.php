<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TesteAnaliseController extends Controller
{
  public CifraController $cifra;
  
  public function __construct()
  {
    $this->cifra = new CifraController();
  }
  protected function seEouA(string $localEA_menosDois, string $chor, array $naturais)
  {
    if((($localEA_menosDois == "%")||($localEA_menosDois == '.'))
      &&(!in_array($chor[2], $naturais)
      &&($chor[2] != "%"))){//&&($chor[1] != " ") 3º analise
      $chor = "*eanao*";//o if acima testa se a letra é início de frase.
      return ['increm', $chor]; //AnaliseController::increm($chor);
    }elseif(($localEA_menosDois == "%")
           &&($chor[1] == 'm')
           &&(!in_array($chor[3], $naturais)
           &&($chor[3] != "%"))){
      $chor = "*eanao*";
      return ['increm', $chor];
    }else{
      //$chor = substr($chor, 0, $s);//no cifra7 ja foi feito esse corte.
      return ['positivo', $chor]; // encaminha para AnaliseController::positivo($chor);
    }
  }
}
