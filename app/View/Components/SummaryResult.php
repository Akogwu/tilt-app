<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SummaryResult extends Component
{
    public $payment_status;
    public $user;
    public $testResult;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($payment_status,$user,$testResult)
    {

        $this->payment_status = $payment_status;
        $this->user           = $user;
        $this->testResult     = $testResult;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.summary-result');
    }
}
