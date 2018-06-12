<?php

/**
 * Class Calculator
 */
class Calculator
{
    private $costRange = [
        [
            "max" => 2500,
            "cost" => 1
        ],
        [
            "max" => 3500,
            "cost" => 3
        ],
        [
            "max" => 5500,
            "cost" => 5
        ],
        [
            "max" => 7500,
            "cost" => 10
        ]
    ];

    private $start;
    private $end;
    private $cost = 0;

    /**
     * Calculator constructor.
     * @param integer $start
     * @param integer $end
     * @throws Exception
     */
    public function __construct(int $start, int $end)
    {
        if ($start >= $end)
            throw new Exception('Invalid values. Initial MMR more or equal to the final MMR');
        if ($start < 0)
            throw new Exception('Initial MMR can`t be negative');
        if ($end > end($this->costRange)['max'])
            throw new Exception("Too high MMR. Maximum MMR is " . end($this->costRange)['max'] . " got - $end");

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Calculate Cost
     */
    public function calculate()
    {
        $rangeNo = 0;

        $currentPoints = $this->start;

        while ($this->costRange[$rangeNo]['max'] <= $currentPoints) {
            $rangeNo++;
        }

        while ($currentPoints < $this->end) {
            $max = ($this->costRange[$rangeNo]['max'] > $this->end) ?
                $this->end :
                $this->costRange[$rangeNo]['max'];

            $this->cost += ($max - $currentPoints) * $this->costRange[$rangeNo]['cost'];
            $currentPoints = $max;
            $rangeNo++;
        }
    }

    /**
     * Get formatted cost
     *
     * @return string
     */
    public function getPrice()
    {
        return number_format($this->cost, 0, ".", " ");
    }
}

try {
    $calculator = new Calculator($_GET['start'], $_GET['end']);
    $calculator->calculate();

    echo $calculator->getPrice();
} catch (Exception $exception) {
    echo $exception;
}
