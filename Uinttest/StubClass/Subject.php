<?php

namespace Uinttest\StubClass;


class Subject
{

    /**
     * @var Observer[]
     */
    private $observerList = [];

    private $name;

    public function attach(Observer $observer)
    {
        $this->observerList[spl_object_id($observer)] = $observer;
    }

    public function detach(Observer $observer)
    {
        $objectId = spl_object_id($observer);
        if (isset($objectId)) {
            unset($this->observerList[$objectId]);
        }
    }

    public function doSomething($name)
    {
        $this->name = $name;
        $this->notify();
    }

    public function doReport()
    {
        $this->report();
    }

    public function notify()
    {
        foreach ($this->observerList as $observer) {
            $observer->update($this->name);
        }
    }

    public function report()
    {
        foreach ($this->observerList as $observer) {
            $observer->report(1, "report err", "extra report err");
        }
    }
}