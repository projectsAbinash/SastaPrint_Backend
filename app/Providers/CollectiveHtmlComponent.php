<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;
class CollectiveHtmlComponent extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Form::component('wtextbox', 'components.textbox', ['name', 'value' => null, 'attributes' => []]);
        Form::component('wpassword', 'components.password', ['name', 'value' => null, 'attributes' => []]);
        Form::component('wsubmit', 'components.button', ['name','attributes' => []]);
        Form::component('wcheckbox', 'components.checkbox', ['name','label','status','attributes' => []]);
    }
}
