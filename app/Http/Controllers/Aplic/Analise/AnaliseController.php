<?php

namespace App\Http\Controllers\Aplic\Analise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Aplic\Leitura\TextoController;

class AnaliseController extends FerramentaAnaliseController
{
  private array $arrayLinhas  = [];
  private array $arrayAcordes = [];
  private   int $finalIndex   = 0;
  
  public function faseAnalise(TextoController $texto)
  {
    $this->texto = $texto;
    $this->incrArrayChor();
    return ["objCifras" => $this->arrayAcordes, "linhas" => $this->arrayLinhas];
  }

  public function incrArrayChor()
  {
    $this->cifra = new CifraController();
    $this->s = 0;
    $this->changeChor++;
    $this->possivelInversao = false;
    if($this->changeChor < count($this->texto->arrayChor)){
      $this->chor = $this->texto->arrayChor[$this->changeChor];
      if(($this->chor[0] == 'A')||($this->chor[0] == 'E')){
        $this->texto->localEA_menosDois  = array_shift(  $this->texto->preEA);
        $this->texto->localEA_maisDois   = array_shift(  $this->texto->posEA);
        $this->texto->localEmAm_maisDois = array_shift($this->texto->posEmAm);
      }
      //echo $this->chor.' será analisado:<br /> ';
      $this->incrChor();
    }
  }

  public function incrChor()
  {
    $this->s++;
    $this->ac = $this->chor[$this->s];
    $this->analisar();
  }

  private function analisar()
  {
    require "ExpressoesTestes.php";
    //echo '- .'.$this->ac.'. - .'.$this->chor.'. testando.<br>';
    if($espaçoOuInversao){ 
      if($ouMiOuLaMaiorOuMenor){
        $funcao = $this->seEouA();
        $this->$funcao(); //positivo() || negativo()
      }else{//positivo porem não EA
        $this->positivo();
      }
    }elseif($menor){
      $this->processaMenor();
      $this->incrChor();
    }elseif($enarmoniaDeAcordOuDissonan){
      $this->processaEnarmoniaDeAcordOuDissonan();
      $this->incrChor();
    }elseif($caracMaisOuMenos){
      $this->processaCaracMaisOuMenos();
      $this->incrChor();
    }elseif($barra){
      $rotacionar = $this->bar();
      //echo '- .'.$this->ac.'. - .'.$this->chor.' rot= '.$rotacionar.'. possInv= .'.$this->possivelInversao.'.<br>';
      $this->$rotacionar(); //analisar() || incrChor()
    }else{
      $this->negativo();
    }
  }

  private function positivo()
  {
    //echo $this->chor.' é acorde.<br /> ';
    $this->cifra->acordeConfirmado = $this->chor;
    $this->cifra->sizeAcordeConfirmado = strlen($this->chor);
    $this->cifra->getDissonancia();
    $this->InputInArray('arrayAcordes', 'cifra');
    $this->incrArrayChor();
  }

  private function InputInArray($cifraLinhaArray, $cifraLinha)
  {
    $stringIndex = $this->finalIndex;
    settype($stringIndex, "string");
    $this->$cifraLinhaArray['0'.$stringIndex] = $this->$cifraLinha;
    $this->finalIndex++ ;
  }

  private function negativo()
  {
    //echo $this->chor.' não é acorde com .'.$this->ac.'.<br /> ';
    $this->incrArrayChor();
  }
}