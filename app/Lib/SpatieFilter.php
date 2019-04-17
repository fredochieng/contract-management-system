<?php
namespace App\Lib;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Description of SpatieFilter
 *
 * @author amuleke
 */
class SpatieFilter implements FilterInterface
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function transform($item, Builder $builder)
    {
        #$user = 
        if(isset($item['hasRole']) && ! $this->user->hasRole($item['hasRole'])){
            return false;
        }
        /*
        if (! $this->isVisible($item)) {
            return false;
        }
        * */
        
        return $item;
    }

    protected function isVisible($item)
    {
        if (! isset($item['hasRole'])) {
            return true;
        }
    }
}
