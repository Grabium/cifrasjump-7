<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{

  private LeituraController $leitura;

  public function __construct(Request $request)
  {
    //fazer o try/cath aqui:
    $this->leitura = new LeituraController($request['texto']);
    //$this->analise = new AnaliseController();
    //$this->conversor = new ConversorController($request['fator']); //classe ainda não criada
  }
  
  public function master()
  {
    $textoResposta = $this->passosBasicos();
    return response()->json(['msg' => [$textoResposta]]);
  }

  private function passosBasicos()
  {
    //preparar texto com marcadores em PreparacaoController (->TextoController) extends MarcadorController
    $textoResposta = $this->leitura->lerTexto();
    //$textoResposta = $this->analise->analisar();
    //converter
    //concatenar
    return $textoResposta;
  }
}
