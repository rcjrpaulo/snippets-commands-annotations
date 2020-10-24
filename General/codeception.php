<?php

public function waitCarregando()
{
    $I = $this;
    $I->waitForElementVisible('img[src="/img/ajax/circle_ball.gif"]');
    $I->waitForElementNotVisible('img[src="/img/ajax/circle_ball.gif"]');
}


/*
*verificando input onde dentro do tr tenha um td com tal texto, mas ele vai pro td que tem o input,
*ou seja verifica um td mas age em outro td
*o text()="" é o texto dentro do elemento html tipo dentro de um span ou um a
*/
$I->waitForElement('//tr[td[text()="'.$funcionario['nome'].'"]]/td/input');


/*
* No primeiro campo vai o elemento que vai pressionar Enter
* No segundo campo vai o comando pra apertar Enter
*/

$I->pressKey('//input[@value="Digite o nome da área"]', \Facebook\WebDriver\WebDriverKeys::ENTER);

/*
*Seleciona a imagem dentro de td/a/img 
*onde o td tenha td/span/span:contains('$empresascompetencias['competencia']')
*/
$I->click('//td[contains(span/span, "'.$empresascompetencias['competencia'].'")]/a/img');