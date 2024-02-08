<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


//grava os índices que possuem naturais

class LeituraController extends InputMarcadorController
{

  private TextoController $texto;
  private string $ordem = 'aberta';
  private int $complChor = 12;
  
  public function __construct(string $textoRecebido)
  {
    $textoMarcado = $this->setTextoRecebido($textoRecebido); //string
    $this->texto = new TextoController($textoMarcado);
  }

  private function separarChor($i)
  {
    $chor = substr($this->texto->textoMarcado, $i, ($this->complChor+1)); 
    $chor = $chor . " "; //pode conter mais de 1 espaço no chor.
    
    if(($chor[0] == "E")||($chor[0] == "A")){
      //seEouA($chor);
      /*
      vai tratar se é:
      lá maior ou mi maior,
      se volta pra análise 
      ou cai direto no negativo 
      */
    }
    
    //(corta no 1° espaço impossibilitando analisar o que vem depois)
    return substr($chor, 0, (strpos($chor, " ")+1)); 
  }

  public function lerTexto()
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
          array_push($this->indicados, $i); 
          array_push($this->array_chor, $this->separarChor($i));
        }
      }
      
      $this->ordem = 'fechada';
    }//for()
    return $this->array_chor;
  }//lerTexto()

  
}//class
