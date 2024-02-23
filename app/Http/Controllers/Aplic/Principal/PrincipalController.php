<?php

namespace App\Http\Controllers\Aplic\Principal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Aplic\ConversorController;
use App\Http\Controllers\Aplic\ConcatenacaoController;
use App\Http\Controllers\Aplic\Leitura\LeituraController;
use App\Http\Controllers\Aplic\Analise\AnaliseController;

class PrincipalController extends Controller
{

  private LeituraController $leitura;

  public function __construct(Request $request)
  {
    //fazer o try/cath aqui:
    $this->leitura = new LeituraController((string)$request['texto']);//que instaura texto
    $this->analise = new AnaliseController();//que instaura cifra
    $this->conversao = new ConversorController($request['fator']); //classe ainda não criada
    $this->concatenacao = new ConcatenacaoController();
  }
  
  public function master()
  {
    $textoResposta = $this->passosBasicos();
    return response()->json(['textoResposta' => $textoResposta]);
  }

  private function passosBasicos()
  {
    $arrChorLines = $this->leitura->faseLeitura();
    dd($arrChorLines);
    $linhasAcordes = $this->analise->faseAnalise($arrChorLines);
    $achordesConvertidos = $this->conversao->faseConversao($linhasAcordes);
    return $this->concatenacao->faseConcatenacao($achordesConvertidos);
  }
}
