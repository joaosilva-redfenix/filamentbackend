<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

use App\Filament\Pages\Settings;
use App\Filament\Resources\DeviceResource;
use App\Filament\Resources\FacilityResource;
use App\Filament\Resources\GroupResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;

class FilamentServiceProvider extends ServiceProvider
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
        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            $items = [];
            $itemsPowerfull = [];
            $itemsOwner = [];

            $items []= NavigationItem::make('Dashboard')
                ->icon('heroicon-o-home')
                ->activeIcon('heroicon-s-home')
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
                ->url(route('filament.pages.dashboard'));
            
            foreach (DeviceResource::getNavigationItems() as $item){
                $items [] = $item;
            }

            if (auth()->user()->is_owner && isset(auth()->user()->group)){
                $itemsOwner [] = NavigationItem::make('Group Manager')
                    ->icon('heroicon-o-scale')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.groups.edit'))
                    ->url(route('filament.resources.groups.edit', ['record'=>auth()->user()->group->id]));
                
            }

            if(auth()->user()->is_admin){
                foreach (UserResource::getNavigationItems() as $item){
                    $itemsPowerfull [] = $item;
                }
                foreach (GroupResource::getNavigationItems() as $item){
                    $itemsPowerfull [] = $item;
                }
            }

            if(auth()->user()->is_owner && isset(auth()->user()->group)){
                foreach (FacilityResource::getNavigationItems() as $item){
                    $itemsOwner [] = $item;
                }
            }
            elseif(auth()->user()->is_admin){
                foreach (FacilityResource::getNavigationItems() as $item){
                    $itemsPowerfull [] = $item;
                }
            }
            else{
                foreach (FacilityResource::getNavigationItems() as $item){
                    $items [] = $item;
                }
            }
            
            
            
            $groups = [];

            if (isset(auth()->user()->group)) {
            $groups []= NavigationGroup::make('home')->items($items);
            }
            
            if(auth()->user()->is_owner && !empty($groups)){
                $groups []= NavigationGroup::make(auth()->user()->group->name)->items($itemsOwner);
            }

            if(auth()->user()->is_admin){
                $groups []= NavigationGroup::make('POWERFULL')->items($itemsPowerfull);
            }
            
            return $builder->groups($groups);
        });
    }
}