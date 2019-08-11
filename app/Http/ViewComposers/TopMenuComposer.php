<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class TopMenuComposer
{
    public function __construct($data = [])
    {
        // Dependencies automatically resolved by service container...
        $this->data = $data;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('currentUser', \Auth::user());
    }
}
