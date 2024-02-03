<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


//grava os índices que possuem naturais

class LeituraController extends MarcadorController
{

  private TextoController $texto;
  private string $ordem = 'aberta';
  private int $complChor = 12;
  
  public function __construct(string $textoRecebido)
  {
    $this->texto = new TextoController($textoRecebido);
  }

  private function separarChor($i)
  {
    $chor = substr($this->texto->textoRecebido, $i, ($this->complChor+1)); 
    $chor = $chor . " ";
    return substr($chor, 0, (strpos($chor, " ")+1));
    
  }

  
  public function lerTexto()
  {
    $l = strlen($this->texto->textoRecebido);
    for($i=0; $i<$l; $i++){
        
      $car = $this->texto->textoRecebido[$i];
      
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
    return [$this->indicados, $this->array_chor];
  }//lerTexto()
}//class
