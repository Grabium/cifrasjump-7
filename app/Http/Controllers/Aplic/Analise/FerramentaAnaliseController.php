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
  protected bool $parentesis = false;
  //protected bool $possivelComposto = false;
  //protected int $locaisEA_change = 0;//iterar

  public function __construct()
  {
    $this->naturais = (new NaturalController)->naturais;
  }

  protected function preparaEApAnalise()
  {
    $this->texto->localEA_menosDois  = array_shift(  $this->texto->preEA);
    $this->texto->localEA_maisDois   = array_shift(  $this->texto->posEA);
    $this->texto->localEmAm_maisDois = array_shift($this->texto->posEmAm);
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

  protected function processaBarra()
  {
    //$this->cifra->dissonancia = false;
    $this->sAc();
    //echo '- .'.$this->ac.'. - .'.$this->chor.' dentro barr - parent'.$this->parentesis.'<br>';
    if(in_array($this->ac, $this->naturais)){
      return $this->seInversao();
    }elseif(($this->ac == '(')&&($this->parentesis == false)){
      //echo $this->chor. ' abre<br>';
      return $this->processaAbreParentesis();
    }else{//se não naturais
      return $this->seNum();//testar numeros
    }
  }

  private function sAc()
  {
    //echo $this->chor.' - '.$this->ac.' ->sac<br>';
    $this->s ++;
    $this->ac = $this->chor[$this->s];
  }
  
  protected function seNum()
  {
    //echo $this->ac.' - diss: .'.$this->cifra->dissonancia.'. <br>';
    if($this->cifra->dissonancia == false){
      $numAte9 = ['2', '3', '4', '5', '6', '7', '9'];
      if(in_array($this->ac, $numAte9)){
        return $this->numOk();
      }elseif($this->ac == '1'){
        $numAte14 = ['0', '1', '2', '3', '4'];
        $this->sAc();
        if(in_array($this->ac, $numAte14)){
          return $this->numOk();
        }
      }
    }
    return 'analisar';//caso == barra fecha-parentesis ou negativo
  }

  private function numOk()
  {
    $this->cifra->setDissonancia();
    return 'incrChor';
  }

  protected function processaAbreParentesis()
  {
    $this->parentesis = true;
    return $this->processaBarra();//mesmos passos.
  }

  private function seInversao()
  {
    $this->possivelInversao = true;
    $this->sAc();
    if(($this->ac == ' ')||(($this->parentesis == true)&&($this->ac == ')'))){
      if(($this->parentesis = true)&&($this->ac == ')')){$this->processaFechaParentesis();}
      $this->cifra->inversao = ['se'=>true, 'tom'=>$this->chor[$this->s-1], 'natureza'=>'naturalInv'];
    }elseif(($this->ac == '#')||($this->ac == 'b')){
      if($this->ac == '#'){
        $this->cifra->inversao['natureza'] = "sustenidoInv";
      }elseif($this->ac == 'b'){
        $this->cifra->inversao['natureza'] = "bemolInv";
      }
      $this->sAc();
      if(($this->ac == ' ')||(($this->parentesis == true)&&($this->ac == ')'))){
        if(($this->parentesis = true)&&($this->ac == ')')){$this->processaFechaParentesis();}
        $this->cifra->inversao['se'] = true;
        $this->cifra->inversao['tom'] = $this->chor[$this->s-2].$this->chor[$this->s-1];//string($s - 2, 2);
      }
    }
    return 'analisar';
  }

  protected function processaFechaParentesis()
  {
    $this->parentesis = false;
    $this->cifra->dissonancia = false;
    return 'incrChor';
  }

  protected function processaNumero()
  {
    if($this->cifra->dissonancia == false){echo 'Dissonancia indevida!';}//gerar exception
    $this->cifra->dissonancia = false;
  }
  
}
