<?php

$result=whoIsWinner(array('6:f'=>'белый:слон', '5:f'=>'белый:слон', '2:g'=>'белый:король', '7:f'=>'черный:конь',
    '8:g'=>'черный:слон', '8:h'=>'черный:король'));

echo $result===null? "null": $result;

function whoIsWinner(array $chessFigures)
{

	//обрабатываем входной массив
	foreach($chessFigures as $arrayKey => $arrayValue)
	{
		$chessFigures[substr($arrayKey,0,2).(string)getCoordNumberFromCharacter
					(substr($arrayKey,2,1))]=explode(":",$arrayValue);
		
		unset($chessFigures[$arrayKey]);
	}
	
	//var_dump($chessFigures);
	
	$coordinatesOfKingUnderAttack;

	//ищем координаты фигуры, на которую поставили шах
	foreach($chessFigures as $arrayKey => $arrayValue)
	{
			if(areFigureAttackedFromElephant($arrayKey, $chessFigures, $arrayValue[0]))
			{
				$coordinatesOfKingUnderAttack=explode(':',$arrayKey);
				break;
			}
		   
	}
	
	//var_dump($coordinatesOfKingUnderAttack);

	
	//проверка приведений типов
	//var_dump((string)((int)$coordinatesOfKingUnderAttack[0]-1));
	//var_dump((int)$coordinatesOfKingUnderAttack[0]-1);
	
	//если нет короля, на которого поставили шах, возвращаем null
	if(empty($coordinatesOfKingUnderAttack))
		return null;
	
	
	//выношу цвет фигуры, на которую поставили шах
	$kingColor=$chessFigures[($coordinatesOfKingUnderAttack[0].":".
						   $coordinatesOfKingUnderAttack[1])][0];

	//проверка, что при любом ходе короля, он умирает
	if(areFigureAttackedFromElephant((string)((int)$coordinatesOfKingUnderAttack[0]-1).':'. 
	  	$coordinatesOfKingUnderAttack[1],$chessFigures,$kingColor))
	{
		if(areFigureAttackedFromElephant((string)((int)$coordinatesOfKingUnderAttack[0]-1).':'. 
		(string)((int)$coordinatesOfKingUnderAttack[1]-1),$chessFigures,$kingColor))
		{
			return $kingColor==='белый'? 'черный': 'белый';
		}
	}
	  	
	
	
	return null;
	
}


function getCoordNumberFromCharacter(string $character)
{
	switch($character)
	{
		case 'a':
			return 1;
		case 'b':
			return 2;
		case 'c':
			return 3;
		case 'd':
			return 4;
		case 'e':
			return 5;
		case 'f':
			return 6;
		case 'g':
			return 7;
		case 'h':
			return 8;
	}
}


function areFigureAttackedFromElephant(string $figureUnderAttackCoordinates,array $chessFigures,
									  string $figureColor)
{
	foreach($chessFigures as $arrayKey => $arrayValue)
	{
		//так как в рассматриваемом случае атакуют только слоны, проверяем их радиус атаки
		//считается ли 'a'++ неявным преобразованием?
		if($arrayValue[0]!== $figureColor && $arrayValue[1]==='слон')
		{
			$coordY=((int)substr($arrayKey,0,1))+1;
			$coordX=((int)substr($arrayKey,2,1))+1;
			
			//проход слона вверх-вправо
			while($coordX<9)
			{	
				//проверяется наличие короля противополножной команды на траектории хода
				if(((string)$coordY.":".(string)$coordX)=== $figureUnderAttackCoordinates)
				{
					return true;
				}
				
				$coordY++;
				$coordX++;
			}
		}
	}
	return false;
}