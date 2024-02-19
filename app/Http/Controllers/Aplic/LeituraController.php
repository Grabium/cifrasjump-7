<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 /******
 *  grava os índices que possuem naturais para análise.
 *  grava os parÂmetros que servirão para definir E e A.
 /******/

class LeituraController extends InputMarcadorController
{

  private TextoController $texto;
  private string $ordem = 'aberta';
  private int $complChor = 12;
  
  public function __construct(string $textoRecebido)
  {
    $this->texto = new TextoController($this->inserirMarcadores($textoRecebido));
  }

  public function faseLeitura()
  {
    $l = strlen($this->texto->textoMarcado);
    for($i=0; $i<$l; $i++){

      $car = $this->texto->textoMarcado[$i];

      if($car == ' '){
        $this->ordem = 'aberta';
        continue;
      }

      if($this->ordem == 'aberta'){
        if(in_array($car, $this->naturais)){
          $this->indicarParaAnalise($i, $car);
          array_push($this->texto->array_chor, $this->separarChor($i));
        }
      }

      $this->ordem = 'fechada';

    }//for()
    return $this->texto;
  }//lerTexto()

  private function separarChor($i)
  {
    $chor = substr($this->texto->textoMarcado, $i, ($this->complChor+1)); 
    $chor = $chor . " ";
    return substr($chor, 0, (strpos($chor, " ")+1)); 
  }

  private function indicarParaAnalise($i, $car)
  {
    array_push($this->texto->indicados, $i);
    
    if(($car == "E")||($car == "A")){
      array_push($this->texto->locaisEA_menosDois, $this->texto->textoMarcado[$i-2]);
      array_push($this->texto->locaisEA, $i);
    }
  }
}//class
