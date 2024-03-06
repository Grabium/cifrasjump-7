<?php

namespace App\Http\Controllers\Aplic\Principal;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Http\Requests\FatorRequest;
use App\Http\Controllers\Aplic\Conversao\ConversorController;
use App\Http\Controllers\Aplic\Concatenacao\ConcatenacaoController;
use App\Http\Controllers\Aplic\Leitura\LeituraController;
use App\Http\Controllers\Aplic\Analise\AnaliseController;

class PrincipalController extends Controller
{

  private LeituraController $leitura;
  

  public function __construct(FatorRequest $request)
  {
    $validated = $request->validated();
    dd($validated);
    //fazer o try/cath aqui:
    $this->leitura = new LeituraController((string)$request['texto']);//que instaura texto
    $this->analise = new AnaliseController();//que instaura cifra
    $this->conversao = new ConversorController($request['fator']); //classe ainda não criada
    $this->concatenacao = new ConcatenacaoController();
  }
  
  public function master()
  {
    $textoResposta = $this->passosBasicos();
    return response()->json($textoResposta);
  }

  private function passosBasicos()
  {
    $data = $this->leitura->faseLeitura();//[0]$texto [1]$marcadores{marc, carac}
    $linhasAcordes = $this->analise->faseAnalise($data);//arrayAcordes, arrayLinhas, arrayNegat.
    $linhasAcordes['arrayAcordes'] = $this->conversao->faseConversao($linhasAcordes["arrayAcordes"]);
    return $this->concatenacao->faseConcatenacao($linhasAcordes, $data[1]);
  }
}
