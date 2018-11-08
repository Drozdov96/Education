<?php

echo incomingPhraseProcessing("Я иду гулять. \nМы гуляли, гуляли, но не нагулялись.");

function incomingPhraseProcessing(string $incomingPhrase)
{
	$incomingPhraseArray=explode(".", $incomingPhrase);

	countWordsAndCharacters($incomingPhraseArray);

	//функция переноса и подсчёта предложений
	countSentences($incomingPhraseArray);

	return implode($incomingPhraseArray);
}

function countSentences(array &$PhraseArray)
{
	$sentenceCounter=1;
	foreach ($PhraseArray as &$value) {
		if(mb_substr_count($value, "\n")>0)
		{
		    $startPoint=strpos($value,"\n");
            $value=substr_replace($value, "${sentenceCounter}.", $startPoint+2, 0);

		}else{
            $value="\n${sentenceCounter}.".$value;
		}
		$sentenceCounter++;
	}
}

function countWordsAndCharacters(array &$PhraseArray)
{
	foreach ($PhraseArray as $key => &$value) {

		if(empty($value))
		{
			unset($PhraseArray[$key]);
			continue;
		}
		$value=trim($value);
		$value.=countWordsInSentence($value);
	}
}

function countWordsInSentence(string $sentence)
{
	$wordsArray=explode(" ", $sentence);
	$wordsCounterArray=[];

	foreach ($wordsArray as $value)
	{
		if(substr($value, -1) === ",")
		{
			$arrKey=mb_strlen(substr($value, 0, -1));
			empty($wordsCounterArray[$arrKey])? $wordsCounterArray[$arrKey]=1:
					$wordsCounterArray[$arrKey]+=1;
		}else{
			$arrKey=mb_strlen($value);
			empty($wordsCounterArray[$arrKey])? $wordsCounterArray[$arrKey]=1:
					$wordsCounterArray[$arrKey]+=1;
		}
	}

	$resultString=". ";
	foreach ($wordsCounterArray as $key => $value) {
		$resultString.="(".(string)$key."-".(string)$value.") ";
	}

	return $resultString;
}