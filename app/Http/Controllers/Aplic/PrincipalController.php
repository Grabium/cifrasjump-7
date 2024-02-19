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
    $texto = $this->leitura->faseLeitura();
    $linhasEAcordes = $this->analise->faseAnalise($texto);
    $achordesConvertidos = $this->conversao->faseConversao($linhasEAcordes);//converter
    $textoResposta = $this->concatenacao->faseConcatenacao($achordesConvertidos);//concatenar
    return $textoResposta;
  }
}
