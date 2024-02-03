<?php

namespace App\Http\Controllers\Aplic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarcadorController extends Controller
{
  protected array $naturais = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
  protected array $indicados = []; //resreva índices dos caracteres do texto recebido que fazem parte dos naturais 
  protected array $array_chor = []; //reserva os chor
  //protected $cifers = []; //reserva os positivos
  //protected $textLines = []; //reserva as linhas de texto
  
  //   < entrada_do_cliente > => < novo_valor >
  protected $agenteCli = [ "\r\n" => ' % ', "\n"=>' % '];
  protected $originais = [];
  protected $marcadores = [];

  //diminuto
  protected $dimCli = [
    '°'    => '|_d000',
    'º'    => '|_d001',
    'dim'  => '|_d002'];                        

  //maj
  protected $majCli = [
    'Maj7' => '|_m000', 
    'maj7' => '|_m001',
    '7M'   => '|_m002'];

  //suspenso
  protected $susCli = [
    'sus2'  => '|_s000',
    'sus9'  => '|_s001',
    'sus4'  => '|_s002',
    'sus11' => '|_s003'];

  //adicionado
  protected $addCli = [
    'add4'   => '|_a000',
    'add11'  => '|_a001',
    'add2'   => '|_a002',
    'add9'   => '|_a003'];

  //aumentado (adicionado com outra grafia)
  protected $augCli = [
    'aug2'   => '|_g000',
    'aug9'   => '|_g001',
    'aug4'   => '|_g002',
    'sus11'  => '|_g003'];
  
  protected function setTextoRecebido(string $textoRecebido)
  {
    $this->marcadores = array_merge( //atenção à ordem.
        $this->dimCli, 
        $this->majCli, 
        $this->susCli,
        $this->addCli,
        $this->augCli
    );

    $this->originais = array_merge( //atenção à ordem.
      array_keys(   $this->dimCli),
      array_keys(   $this->majCli),
      array_keys(   $this->susCli),
      array_keys(   $this->addCli),
      array_keys(   $this->augCli)
    );

    $textoMarcado = str_replace( 
      array_merge(array_keys($this->agenteCli), $this->originais),
      array_merge($this->agenteCli, $this->marcadores),
      $textoRecebido
    ); 

    return $textoMarcado;
  }
}
