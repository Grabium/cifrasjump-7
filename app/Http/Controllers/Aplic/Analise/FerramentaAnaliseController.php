<?php

namespace App\Http\Controllers\Aplic\Analise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Aplic\Leitura\TextoController;
use App\Http\Controllers\Aplic\Principal\NaturalController;

class FerramentaAnaliseController extends Controller
{
  protected TextoController $texto;
  protected CifraController $cifra;
  protected int $changeChor = -1;//itera os chor reservados em TextoController::arrayChor[]
  protected int $s = 0; //índice do $chor a ser analizado
  protected string $ac; //caractere a analisar
  protected string $chor;
  //protected int $locaisEA_change = 0;//iterar
  
  protected function seEouA()
  {
    $naturais = (new NaturalController)->naturais;
    if((($this->texto->localEA_menosDois == "%")||($this->texto->localEA_menosDois == '.'))//se início de frase
      &&(!in_array($this->texto->localEA_maisDois, $naturais))//e não há um possível acorde o seguindo.
      &&($this->texto->localEA_maisDois != "%")&&($this->texto->localEA_maisDois != " ")){//e não é fim de linha de acordes.
      return 'negativo'; //AnaliseController->incrChor();
    }elseif(($this->texto->localEA_menosDois == "%")
        &&($this->chor[1] == 'm')
        &&($this->texto->localEmAm_maisDois != "%")
        &&($this->texto->localEmAm_maisDois != " ")){
      return 'negativo';
    }else{
      return 'positivo'; // encaminha para AnaliseController->positivo();
    }
  }

  protected function processaSustenidoEBemol()
  {
    if($this->s == 1){
      $this->cifra->enarmonia[0] = true;
      if($this->ac == '#'){
        $this->cifra->enarmonia[1] = 'sus';
      }elseif($this->ac == 'b'){
        $this->cifra->enarmonia[1] = 'bem';
      }
    } 
    //dissonancia nao classifica a cifra. Serve apenas para abrir/fechar análise.
    $this->cifra->dissonancia = false;
  }
}
