<?php

    class bubblesort
    {
        private $min;
        private $max;
        private $defaultColor;
        private $selectedColor;

        function __construct($min, $max, $defaultColor, $selectedColor)
        {
            $this->min = $min;
            $this->max = $max;
            $this->defaultColor = $defaultColor;
            $this->selectedColor = $selectedColor;
        }

        /**
         * Reset all the colors to default
         * @param $rows
         * @return mixed
         */
        private function resetColors(&$rows)
        {
            foreach ($rows as $key => $row)
            {
                $rows[$key][1] = $this->defaultColor;
            }

            return $rows;
        }

        /**
         * Set the selected colors
         * @param $rows
         * @param $pointer
         * @return mixed
         */
        private function setColors(&$rows, $pointer)
        {
            $rows[$pointer][1] = $this->selectedColor;
            $rows[$pointer + 1][1] = $this->selectedColor;

            return $rows;
        }

        // ================================ ROUTINES ================================

        /**
         * Shuffle data and return the result
         * @return null
         */
        public function getShuffled()
        {
            $data = null;

            $data['iteration'] = 0;
            $data['step'] = 0;
            $data['total_swaps'] = 0;
            $data['swaps_for_iteration'] = 0;
            $data['pointer'] = 0;
            $data['done'] = false;
            $data['rows'] = [[rand($this->min, $this->max), 'yellow'], [rand($this->min, $this->max), 'yellow'], [rand($this->min, $this->max), 'red'],
                [rand($this->min, $this->max), 'red'], [rand($this->min, $this->max), 'red'], [rand($this->min, $this->max), 'red'],
                [rand($this->min, $this->max), 'red'], [rand($this->min, $this->max), 'red'], [rand($this->min, $this->max), 'red'], [rand($this->min, $this->max), 'red']];

            return $data;
        }

        /**
         * Execute one step and return the result
         * @param $data
         * @return mixed
         */
        public function getStep($data)
        {
            if (!$data['done']) // Only add a step if it isn't already sorted
            {
                $this->resetColors($data['rows']);

                if ($data['rows'][$data['pointer']] > $data['rows'][$data['pointer'] + 1]) // If a row needs to be swapped
                {
                    // Swapping is done here
                    $swapRow = $data['rows'][$data['pointer']];
                    $data['rows'][$data['pointer']] = $data['rows'][$data['pointer'] + 1];
                    $data['rows'][$data['pointer'] + 1] = $swapRow;

                    $data['swaps_for_iteration']++;
                    $data['total_swaps']++;
                }
                else
                {
                    $data['pointer']++;
                }

                // If the pointer reached the last step, it needs to be reset
                if ($data['pointer'] >= 9)
                {
                    if ($data['swaps_for_iteration'] === 0)
                    {
                        $data['done'] = true;
                        $data['pointer'] = 0;
                    }
                    else
                    {
                        $data['swaps_for_iteration'] = 0;
                        $data['pointer'] = 0;
                        $data['iteration']++;
                    }
                }

                $this->setColors($data['rows'], $data['pointer']);

                $data['step']++;
            }

            return $data;
        }
    }

