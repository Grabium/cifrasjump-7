<?php
//$teste1 = 'tudo ok no require';
$espaçoOuInversao = (($this->ac == ' ')||($this->cifra->inversao['se'] == true ));

$ouMiOuLaMaiorOuMenor = ((($this->chor[0] == "E")||($this->chor[0] == "A"))
  &&(($this->s == 1)||(($this->s == 2)&&($this->chor[1] == 'm')))
  &&($this->possivelInversao == false ));

$menor = (((($this->ac == 'm')&&($this->s == 1))
  ||(($this->ac == 'm')&&($this->s == 2)&&($this->cifra->enarmonia['se'] == true )))
  &&($this->cifra->composto == false )&&($this->possivelInversao == false ));

$enarmoniaDeAcordOuDissonan = ((($this->ac == '#')||($this->ac == 'b'))
  &&((($this->s == 1)&&($this->cifra->tercaMenor == false)&&($this->cifra->dissonancia == false))//F# Eb
     ||($this->cifra->dissonancia == true))//5b 6#
  &&($this->cifra->enarmonia['se'] == false));

$caracMaisOuMenos = ((($this->ac == '+')||($this->ac == '-'))
  &&((($this->s == 1)||(($this->s == 2)&&($this->cifra->enarmonia['se'] == true)))
  ||($this->cifra->dissonancia == true)));

$barra = (($this->ac == '/')&&($this->cifra->composto == false)&&($this->possivelInversao == false));