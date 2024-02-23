<?php

namespace App\Http\Controllers\Aplic\Analise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Aplic\Leitura\TextoController;
use Illuminate\Support\Collection;

class AnaliseController extends FerramentaAnaliseController
{
  private array $arrayLinhas  = [];
  private array $arrayAcordes = [];
  private array $arrayNegat   = [];//chor que deverá ser indexado para retorno da fase.
  private   int $lastIndex    = 0;
  
  
  public function faseAnalise(TextoController $texto): array
  {
    $this->texto = $texto;
    //dd($this->texto);
    collect($this->texto->arrayChor)->map(function (string $itemChor) {//$itemChor é item de arrayChor
      $this->chor = $itemChor;
      $this->incrArrayChor();
    });
    return ["objCifras" => $this->arrayAcordes, "linhas" => $this->arrayLinhas, "negativos" => $arrayNegat];
  }

  private function incrArrayChor()
  {
    $this->cifra = new CifraController();
    $this->s = 0;
    $this->possivelInversao = false;
    $this->parentesis = false;
    if(($this->chor[0] == 'A')||($this->chor[0] == 'E')){
      $this->preparaEApAnalise();
    }
    //echo $this->chor.' será analisado:<br /> ';
    $this->incrChor();
  }

  private function incrChor()
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
      $funcao = $this->processaBarra();
      //echo '-ac .'.$this->ac.'. - chor .'.$this->chor.' - rotac->'.$funcao.' - diss .'.$this->cifra->dissonancia.'. -barra<br>';
      $this->$funcao(); //analisar() || incrChor()
    }elseif($abreParentesis){
      //echo '- .'.$this->ac.'. - .'.$this->chor.'.<br>';
      $funcao = $this->processaAbreParentesis();
      //echo '- .'.$this->ac.'. - .'.$funcao.'.<br>';
      $this->$funcao(); //analisar(para cair em negativo) || incremChor(para seguir analise)
    }elseif($fechaParentesis){//apenas para números
      $funcao = $this->processaFechaParentesis();
      //echo $this->chor.' - '.$funcao.' - '.$this->ac.'<br>';
      $this->$funcao(); //analisar(para cair em negativo) || incremChor(para seguir analise)
    }elseif($numero){
      $this->processaNumero();
      $this->incrChor();
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
  }

  private function InputInArray($cifraLinhaArray, $cifraLinha)
  {
    $stringIndex = $this->lastIndex;
    settype($stringIndex, "string");
    $this->$cifraLinhaArray['0'.$stringIndex] = $this->$cifraLinha;
    $this->lastIndex++ ;
  }

  private function negativo()
  {
    //echo $this->chor.' não é acorde com .'.$this->ac.'.<br /> ';
  }
}