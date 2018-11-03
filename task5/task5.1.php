<?php

$driver = new Driver();

simulationEngineWork();

class Driver
{
    function __call($name, $params)
    {
        echo "Received command '$name' with parametеr "
            .array_pop($params)."<br>";
    }
}

function simulationEngineWork()
{
	engageCylinderBlock();
}

function engageCylinderBlock()
{
    //неограниченная длина работы
	while(true)
	{
		doStepOne();

		doStepTwo();

		doStepThree();
			
		doStepFour();
	}
}

function doStepOne()
{
	engageCylinderOne(1);
	engageCylinderTwo(4);
	engageCylinderThree(3);
	engageCylinderFour(2);
}

function doStepTwo()
{
	engageCylinderOne(2);
	engageCylinderTwo(1);
	engageCylinderThree(4);
	engageCylinderFour(3);
}

function doStepThree()
{
	engageCylinderOne(3);
	engageCylinderTwo(2);
	engageCylinderThree(1);
	engageCylinderFour(4);
}

function doStepFour()
{
	engageCylinderOne(4);
	engageCylinderTwo(3);
	engageCylinderThree(2);
	engageCylinderFour(1);
}

function engageCylinderOne(int $tact)
{
	global $driver;

	switch ($tact) {
		case '1':
			//первый такт
			$driver->moveInletValveOne('down');
			$driver->movePistonOne('down');
			break;
		case '2':
			//второй такт
			$driver->moveInletValveOne('up');
			$driver->movePistonOne('up');
			break;
		case '3':
			//третий такт
			$driver->switchTheLampOne('on');
			$driver->movePistonOne('down');
			$driver->switchTheLampOne('off');
			break;
		case '4':
			//четвертый такт
			$driver->moveExhaustValveOne('down');
			$driver->movePistonOne('up');
			$driver->moveExhaustValveOne('up');
			break;
	}
}

function engageCylinderTwo(int $tact)
{
	global $driver;

	switch ($tact) {
		case '1':
			//первый такт
			$driver->moveInletValveTwo('down');
			$driver->movePistonTwo('down');
			break;
		case '2':
			//второй такт
			$driver->moveInletValveTwo('up');
			$driver->movePistonTwo('up');
			break;
		case '3':
			//третий такт
			$driver->switchTheLampTwo('on');
			$driver->movePistonTwo('down');
			$driver->switchTheLampTwo('off');
			break;
		case '4':
			//четвертый такт
			$driver->moveExhaustValveTwo('down');
			$driver->movePistonTwo('up');
			$driver->moveExhaustValveTwo('up');
			break;
	}
}

function engageCylinderThree(int $tact)
{
	global $driver;

	switch ($tact) {
		case '1':
			//первый такт
			$driver->moveInletValveThree('down');
			$driver->movePistonThree('down');
			break;
		case '2':
			//второй такт
			$driver->moveInletValveThree('up');
			$driver->movePistonThree('up');
			break;
		case '3':
			//третий такт
			$driver->switchTheLampThree('on');
			$driver->movePistonThree('down');
			$driver->switchTheLampThree('off');
			break;
		case '4':
			//четвертый такт
			$driver->moveExhaustValveThree('down');
			$driver->movePistonThree('up');
			$driver->moveExhaustValveThree('up');
			break;
	}
}

function engageCylinderFour(int $tact)
{
	global $driver;

	switch ($tact) {
		case '1':
			//первый такт
			$driver->moveInletValveFour('down');
			$driver->movePistonFour('down');
			break;
		case '2':
			//второй такт
			$driver->moveInletValveFour('up');
			$driver->movePistonFour('up');
			break;
		case '3':
			//третий такт
			$driver->switchTheLampFour('on');
			$driver->movePistonFour('down');
			$driver->switchTheLampFour('off');
			break;
		case '4':
			//четвертый такт
			$driver->moveExhaustValveFour('down');
			$driver->movePistonFour('up');
			$driver->moveExhaustValveFour('up');
			break;
	}
}