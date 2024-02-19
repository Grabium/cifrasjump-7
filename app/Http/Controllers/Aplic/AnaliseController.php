<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnaliseController extends FerramentaAnaliseController
{
  private TextoController $texto;
  private array $arrayLinhas = [];
  private array $arrayAcordes = [];

  public function __construct()
  {
    $this->cifra = new CifraController();//iterar objeto
  }
  
  public function faseAnalise(TextoController $texto)
  {
    $this->texto = $texto;
    $this->chor = $this->texto->array_chor[$this->changeChor];//iterar arraychor
    $this->ac = $this->chor[$this->s];//iterar o s
    $analisado = $this->analisar();
    return $analisado; //[[array_linhas], [array_acordes]]
  }

  private function analisar()
  {
    
    //dd($this->cifra);
    if(($this->ac == ' ')||($this->cifra->invercao == true )){ 
      /*if((($this->chor[0] == "E")||($this->chor[0] == "A"))
        &&(($this->s == 1)||(($this->s == 2)&&($this->chor[1] == 'm')))
        &&($this->cifra->invercao == false )){
        $rotacionar = $this->seEouA($this->locaisEA_menosDois[$this->locaisEA_change], $this->chor, $this->naturais); //:array 
        $funcao = array_shift($rotacionar);
        $this->$funcao(...$rotacionar); //positivo(chor) || increm(chor)
      }else{//positivo porem não EA
        //$chor = substr($chor, 0, ($s));
        $this->positivo();
      }*/
      $this->positivo();
    }
    return ["objCifras" => $this->arrayAcordes, "linas" => $this->arrayLinhas];
  }

  private function positivo()
    {
      $this->cifra->acordeConfirmado = $this->chor;
      $this->cifra->sizeAcordeConfirmado = strlen($this->chor);
      array_push($this->arrayAcordes, $this->cifra);
    }
}
