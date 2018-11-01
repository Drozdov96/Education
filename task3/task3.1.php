<?php

$temperatureToday = 12;
$temperatureTomorrow = 6;
$temperatureYesterday = 13;
$isRaining = false;
$phraseFromAnya = "холодно b и ызамерзла заморозки";

echo momsThinkingProcess($temperatureToday, $temperatureTomorrow, $temperatureYesterday,
							 $isRaining, $phraseFromAnya);



function momsThinkingProcess(int $temperatureToday, int $temperatureTomorrow, int $temperatureYesterday,
							 bool $isRaining, string $phraseFromAnya)
{
	$momsIncomingSentence="";

    $isTemperatureFall=checkTemperatureFall($temperatureYesterday, $temperatureToday, $temperatureTomorrow);
    $coldPhrasesNumber=analyzeAnyaPhrase($phraseFromAnya);

    if(isDanger($isTemperatureFall, $coldPhrasesNumber,
        rateTemperatureDrop($temperatureToday, $temperatureTomorrow, 5)))
    {
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

function isDanger(bool $isTemperatureFall, int $coldPhrasesNum, bool $isTempDropOnFiveUnits){
    return  ($coldPhrasesNum > 2)&& $isTemperatureFall && $isTempDropOnFiveUnits;
}

function analyzeAnyaPhrase(string $phraseFromAnya)
{
    $analysisResult=0;
    if(substr_count($phraseFromAnya, "заморозки")>0)
        $analysisResult++;
    if(substr_count($phraseFromAnya, "замерзла")>0)
        $analysisResult++;
    if(substr_count($phraseFromAnya, "холодно")>0)
        $analysisResult++;
    return $analysisResult;
}

function checkTemperatureFall(int $temperatureYesterday, int $temperatureToday, int $temperatureTomorrow)
{
    return $temperatureYesterday>$temperatureToday && $temperatureToday>$temperatureTomorrow;
}

function rateTemperatureDrop(int $temperatureToday, int $temperatureTomorrow, int $temperatureDropNumber)
{
    return ($temperatureToday-$temperatureTomorrow)>$temperatureDropNumber;
}