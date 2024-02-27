<?php

namespace App\Http\Controllers\Aplic\Conversao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Aplic\Analise\CifraController;

class ConversorController extends Controller
{
  private   array   $tonalidadeSustenido = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
  private   array   $tonalidadeBemol     = ['C', 'Db', 'D', 'Eb', 'E', 'F', 'Gb', 'G', 'Ab', 'A', 'Bb', 'B'];
  protected int     $fator;
  protected array   $arrayAcordes;
  
  public function __construct(int $fator)
  {
    $this->fator = $fator;
  }
  public function faseConversao($arrayAcordes)
  {
    $this->arrayAcordes = $arrayAcordes;
    
    collect($arrayAcordes)->map(function (CifraController $cifra) {
      $this->converter($cifra);
    });
    
    return $arrayAcordes;
  }

  private function converter(CifraController $cifra)
  {
    
    $key = $this->setKeyFundamental($cifra);
    $novoTom = $this->buscarEConverter($key);

    if($cifra->inversao['se'] == true){
      $key = $this->setKeyInversao($cifra->inversao);//criar funcao
      $novoTomInv = $this->buscarEConverter($key);
      echo '<br>'.$novoTomInv;
    }
    
    echo '<br>'.$novoTom;
    dd($novoTom);
  }

  private function buscarEConverter($key)
  {
    $resto = (($this->fator + $key)%12);
    return  $this->buscarNovoTom($resto);
  }

  private function setKeyFundamental($cifra)
  {
    if(($cifra->enarmonia['se'] == false)||($cifra->enarmonia['natureza'] == 'sustenido')){
      return array_search($cifra->tonalidade, $this->tonalidadeSustenido);//retorna o número da fundamental.
    }elseif($cifra->enarmonia['natureza'] == 'bemol'){
      return array_search($cifra->tonalidade, $this->tonalidadeBemol);
    }
  }

  private function setKeyInversao($inversao)
  {
    if(($inversao['natureza'] == 'naturalInv')||($inversao['natureza'] == 'sustenidoInv')){
      return array_search($inversao['natureza'], $this->tonalidadeSustenido);//retorna o número da fundamental.
    }elseif($inversao['natureza'] == 'bemolInv'){
      return array_search($inversao['natureza'], $this->tonalidadeBemol);
    }
  }

  private function buscarNovoTom($resto)
  {
    if($resto < 0){
      return $this->tonalidadeSustenido[12 + $resto];
    }else{
      return $this->tonalidadeSustenido[$resto];
    }
  }
}
