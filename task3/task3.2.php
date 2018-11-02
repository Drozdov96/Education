<?php

$result=whoIsWinner(array('6:f'=>'черный:слон', '5:f'=>'черный:слон', '2:g'=>'черный:король', '7:f'=>'белый:конь',
    '8:g'=>'белый:слон', '8:h'=>'белый:король'));

echo $result===null? "null": $result;

function whoIsWinner(array $chessFigures)
{
	//обрабатываем входной массив
	foreach($chessFigures as $arrayKey => $arrayValue)
	{
		$chessFigures[substr($arrayKey,0,2).(string)getCoordNumberFromCharacter
            (substr($arrayKey,2,1))]=
            array_combine(array('color', 'figure'), explode(":",$arrayValue));
		
		unset($chessFigures[$arrayKey]);
	}
	
	$coordinatesOfKingUnderAttack=null;

	//ищем координаты фигуры, на которую поставили шах
	foreach($chessFigures as $arrayKey => $arrayValue)
	{
	    if($arrayValue['figure']==='король')
	    {
            if (areFigureAttackedFromElephant($arrayKey, $chessFigures, $arrayValue['color']))
            {
                $coordinatesOfKingUnderAttack = array_combine(array('coordY', 'coordX')
                    ,explode(":",$arrayKey));
                break;
            }
        }
	}

	//если нет короля, на которого поставили шах, возвращаем null
	if(empty($coordinatesOfKingUnderAttack))
		return null;
	
	
	//выношу цвет фигуры, на которую поставили шах
	$kingColor=$chessFigures[getCoordinateString
        ($coordinatesOfKingUnderAttack['coordY']
        ,$coordinatesOfKingUnderAttack['coordX'])]['color'];

	//проверка, что при любом ходе короля, он умирает
	if(areFigureAttackedFromElephant(getCoordinateString
        ((string)((int)$coordinatesOfKingUnderAttack['coordY']-1)
            ,$coordinatesOfKingUnderAttack['coordX']),$chessFigures,$kingColor))
	{
		if(areFigureAttackedFromElephant(getCoordinateString
            ((string)((int)$coordinatesOfKingUnderAttack['coordY']-1)
            ,(string)((int)$coordinatesOfKingUnderAttack['coordX']-1))
            ,$chessFigures,$kingColor))
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
		if($arrayValue['color']!== $figureColor && $arrayValue['figure']==='слон')
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

function getCoordinateString(string $coordY, string $coordX)
{
    return $coordY.':'.$coordX;
}