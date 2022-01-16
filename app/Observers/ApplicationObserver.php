<?php

namespace App\Observers;

class ApplicationObserver
{
    public function created(Product $product)
    {
        $hashids = new Hashids('', 12);
        $application->app_id = $hashids->encode($application->id);
        $application->save();
    }
}
