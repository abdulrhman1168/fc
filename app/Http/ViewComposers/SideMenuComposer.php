<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class SideMenuComposer
{
    /**
     * The
     *
     * @var CoreApp
     */
    protected $apps;

    /**
     * Create a New profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct($apps = [])
    {
        // Dependencies automatically resolved by service container...
        $this->apps = $apps;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('apps', $this->apps);
    }
}
