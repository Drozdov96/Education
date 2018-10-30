<?php

$temperatureToday = 12;
$temperatureTomorrow = 7;
$temperatureYesterday = 13;
$isRaining = false;
$phraseFromAnya = "холодно b и ызамерзла заморозки";

echo momsThinkingProcess($temperatureToday, $temperatureTomorrow, $temperatureYesterday,
							 $isRaining, $phraseFromAnya);



function momsThinkingProcess(int $temperatureToday, int $temperatureTomorrow, int $temperatureYesterday,
							 bool $isRaining, string $phraseFromAnya)
{
	$momsIncomingSentence="";
	
	if((substr_count($phraseFromAnya, "заморозки")>0 && substr_count($phraseFromAnya, "холодно")>0 || 
		substr_count($phraseFromAnya, "заморозки")>0 && substr_count($phraseFromAnya, "замерзла")>0 ||
		substr_count($phraseFromAnya, "холодно")>0 && substr_count($phraseFromAnya, "замерзла")>0) &&
	   ($temperatureYesterday>$temperatureToday && $temperatureToday>$temperatureTomorrow) &&
	   ($temperatureToday-$temperatureTomorrow)>5) {
		$momsIncomingSentence="*Сказано голосом Гендальфа* Ты не пройдёшь!";
	}else{
		
		if($temperatureToday<13) {
			if($temperatureYesterday>=11 && $temperatureTomorrow>=11) {
				$momsIncomingSentence="Одень шапку. ";
			}elseif($temperatureYesterday<11 || $temperatureTomorrow<11) {
				$momsIncomingSentence="Одень зимнюю шапку. ";
			}
		}
		
		if(($temperatureYesterday>$temperatureToday && $temperatureToday>$temperatureTomorrow) || 
		   (substr_count($phraseFromAnya, "холодно")>0 || substr_count($phraseFromAnya, "заморозки")>0 ||
		   substr_count($phraseFromAnya, "замерзла")>0)) {
			$momsIncomingSentence.="ты хорошо оделся? ";
		}
		
		if($isRaining) {
			$momsIncomingSentence.="и возьми с собой зонтик. ";
			
			if(($temperatureToday-$temperatureTomorrow)>3) {
				$momsIncomingSentence.="и шарф.";
			}
		}
	
	}
	
	return $momsIncomingSentence;
}