<?php
//$teste1 = 'tudo ok no require';
$espaçoOuInversao = (($this->ac == ' ')||($this->cifra->inversao['se'] == true ));

$ouMiOuLaMaiorOuMenor = ((($this->chor[0] == "E")||($this->chor[0] == "A"))
                        &&(($this->s == 1)||(($this->s == 2)&&($this->chor[1] == 'm')))
                        &&($this->cifra->inversao['se'] == false ));

$menor = ((($this->ac == 'm')&&($this->s == 1))
          //&&($this->cifra->composto == false)
          ||(($this->ac == 'm')
             &&($this->s == 2)
             &&($this->cifra->enarmonia['se'] == true )
             /*&&($this->cifra->composto == false )*/));

$enarmoniaDeAcordOuDissonan = (($this->ac == '#')||($this->ac == 'b')//F# Eb
                              &&(($this->s == 1)||($this->cifra->dissonancia == true))//5b 6#
                              &&($this->cifra->enarmonia['se'] == false));

$caracMaisOuMenos =  ((($this->ac == '+')||($this->ac == '-'))
                    &&((($this->s == 1)||(($this->s == 2)&&($this->cifra->enarmonia['se'] == true)))
                    ||($this->cifra->dissonancia == true)));
