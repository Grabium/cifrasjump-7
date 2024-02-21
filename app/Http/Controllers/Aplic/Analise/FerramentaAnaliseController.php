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
  protected array $naturais; 
  protected int $changeChor = -1;//itera os chor reservados em TextoController::arrayChor[]
  protected int $s = 0; //índice do $chor a ser analizado
  protected string $ac; //caractere a analisar
  protected string $chor;
  protected bool $possivelInversao = false;
  //protected int $locaisEA_change = 0;//iterar

  public function __construct()
  {
    $this->naturais = (new NaturalController)->naturais;
  }
  
  protected function seEouA()
  {
    if((($this->texto->localEA_menosDois == "%")||($this->texto->localEA_menosDois == '.'))//se início de frase
      &&(!in_array($this->texto->localEA_maisDois, $this->naturais))//e não há um possível acorde o seguindo.
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

  protected function processaEnarmoniaDeAcordOuDissonan()
  {
    if($this->s == 1){
      $this->cifra->enarmonia['se'] = true;
      if($this->ac == '#'){
        $this->cifra->enarmonia['natureza'] = 'sustenido';
      }elseif($this->ac == 'b'){
        $this->cifra->enarmonia['natureza'] = 'bemol';
      }
    } 
    //dissonancia nao classifica a cifra. Serve apenas para abrir/fechar análise.
    $this->cifra->dissonancia = false;
  }

  protected function processaMenor()
  {
    $this->cifra->tercaMenor = true;
  }

  protected function processaCaracMaisOuMenos()
  {
    if(($this->ac == '-')&&($this->cifra->dissonancia == false)){
      $this->processaMenor();
    }
    $this->cifra->dissonancia = false;
  }

  protected function bar()
  {
    $this->cifra->dissonancia = false;
    $this->sAc();
    //echo '- .'.$this->ac.'. - .'.$this->chor;
    if(in_array($this->ac, $this->naturais)){
      $this->possivelInversao = true;
      $this->sAc();
      if($this->ac == " "){
        $this->cifra->inversao = ['se'=>true, 'tom'=>$this->chor[$this->s-1], 'natureza'=>'naturalInv'];
        return 'analisar';
      }elseif(($this->ac == '#')||($this->ac == 'b')){
        if($this->ac == '#'){
          $this->cifra->inversao['natureza'] = "sustenidoInv";
        }elseif($this->ac == 'b'){
          $this->cifra->inversao['natureza'] = "bemolInv";
        }
        $this->sAc();
        if($this->ac == " "){
          $this->cifra->inversao['se'] = true;
          $this->cifra->inversao['tom'] = $this->chor[$this->s-2].$this->chor[$this->s-1];//string($s - 2, 2);
          return 'analisar';
        }
      }else{
        //return $this->seNum();
        return 'analisar';
      }
    }else{//se não naturais
      return $this->seNum();
    }
  }//bar()

  private function sAc()
  {
    //echo $this->chor.' - '.$this->ac.' ->sac<br>';
    $this->s ++;
    $this->ac = $this->chor[$this->s];
  }
  
  private function seNum()
  {
    $numeros = ['2', '3', '4', '5', '6', '7', '9'];
    if((in_array($this->ac, $numeros))&&($this->cifra->dissonancia == false)){
      return $this->numOk();
    }else{
      return 'analisar';
    }
  }

  private function numOk()
  {
    $this->cifra->setDissonancia();
    return 'incrChor';
  }
  
}
