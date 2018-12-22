<?php

use SM\Event\SMEvents;
use SM\Event\TransitionEvent;
use SM\SMException;

class CellStateMachine extends SM\StateMachine\StateMachine
{
    public const PLACE_TRANSITION='place';
    public const STRIKE_TRANSITION='strike';

    protected const STATE_MACHINE_CONFIG = array(
        'graph'         => 'cellGraph', // Name of the current graph - there can be many of them attached to the same object
        'property_path' => 'cellState',  // Property path of the object actually holding the state
        'states'        => array(
            Cell::EMPTY_CELL_STATE,
            Cell::SHIP_CELL_STATE,
            Cell::HIT_CELL_STATE,
            Cell::MISS_CELL_STATE
        ),
        'transitions' => array(
            self::PLACE_TRANSITION => array(
                'from' => array(Cell::EMPTY_CELL_STATE),
                'to'   => array(Cell::SHIP_CELL_STATE)
            ),
            self::STRIKE_TRANSITION => array(
                'from' => array(Cell::EMPTY_CELL_STATE, Cell::SHIP_CELL_STATE),
                'to'   => array(Cell::MISS_CELL_STATE, Cell::HIT_CELL_STATE)
            )
        )
    );

    public function __construct($object, \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher = null, \SM\Callback\CallbackFactoryInterface $callbackFactory = null)
    {
        parent::__construct($object, self::STATE_MACHINE_CONFIG, $dispatcher, $callbackFactory);
    }

    public function setObject($object)
    {
        if(get_class($object)===get_class($this->object)){
            $this->object=$object;
        }

    }

    public function apply($transition, $soft = false)
    {

        if (!$this->can($transition)) {
            if ($soft) {
                return false;
            }

            throw new SMException(sprintf(
                'Transition "%s" cannot be applied on state "%s" of object "%s" with graph "%s"',
                $transition,
                $this->getState(),
                get_class($this->object),
                $this->config['graph']
            ));
        }

        $event = new TransitionEvent($transition, $this->getState(), $this->config['transitions'][$transition], $this);

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(SMEvents::PRE_TRANSITION, $event);

            if ($event->isRejected()) {
                return false;
            }
        }

        $this->callCallbacks($event, 'before');

        $stateKey= array_search($this->getState(), $this->config['transitions'][$transition]['from']);


        $this->setState($this->config['transitions'][$transition]['to'][$stateKey]);

        $this->callCallbacks($event, 'after');

        if (null !== $this->dispatcher) {
            $this->dispatcher->dispatch(SMEvents::POST_TRANSITION, $event);
        }

        return true;
    }
}