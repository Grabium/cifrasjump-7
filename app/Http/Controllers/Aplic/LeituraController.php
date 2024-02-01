<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


//grava os índices que possuem naturais

class LeituraController extends MarcadorController
{

  private TextoController $texto;
  private string $ordem = 'aberta';
  
  public function __construct($textoRecebido)
  {
    $this->texto = new TextoController($textoRecebido);
  }

  public function getTextoRecebido()
  {
    return $this->texto->textoRecebido;
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
        if(in_array($car, $this->naturais)){  //de MarcadorController
          array_push($this->indicados, $i); //de MarcadorController
        }
      }
      
      $this->ordem = 'fechada';
    }//for()
    return $this->indicados;
  }//lerTexto()
}//class
