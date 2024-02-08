<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marcador;
use Illuminate\Support\Facades\DB;

class MarcadorController extends Controller
{
  protected array $naturais = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
  protected array $indicados = []; //resreva índices dos caracteres do texto recebido que fazem parte dos naturais 
  protected array $array_chor = []; //reserva os chor
  //protected $cifers = []; //reserva os positivos
  //protected $textLines = []; //reserva as linhas de texto
  
  //   < entrada_do_cliente > => < novo_valor >
  protected $agenteCli = [ "\r\n" => ' % ', "\n"=>' % '];

  protected function setTextoRecebido(string $textoRecebido)
  {
    $caracteres = $this->getLista('caractere');
    $marcadores = $this->getLista('marcador');
    $textoMarcado = str_replace($caracteres, $marcadores, $textoRecebido);
    return $textoMarcado;
  }

  private function getLista($coluna)
  {
    $compac = $this->busca($coluna);
    $lista = $this->descompacta($compac, $coluna);
    $lista_concatenada = $this->concatena($lista, $coluna);
    
    return $lista_concatenada;
  }

  private function busca($coluna)
  {
    $compac = Array(DB::table('marcadores')->select($coluna)->get());
    return $compac;
  }

  private function descompacta($compac, $coluna)
  {
    $lista = [];
    foreach($compac as $unid_compac){
      if(($unid_compac != null)||($unid_compac != false)||($unid_compac != "")){
        foreach($unid_compac as $obj_descompac){
          if(($obj_descompac != null)||($obj_descompac != false)||($obj_descompac != "")){
            array_push($lista, $obj_descompac->$coluna);
          }
        }
      }
    }
    
    return $lista;
  }

  private function concatena($lista, $coluna)
  {
    if($coluna == 'caractere'){
      
      $lista_concatenada = array_merge(array_keys($this->agenteCli), $lista);
      
    }elseif($coluna == 'marcador'){
      
      $lista_concatenada = array_merge($this->agenteCli, $lista);
      
    }
    return $lista_concatenada;
  }
  
  
}
