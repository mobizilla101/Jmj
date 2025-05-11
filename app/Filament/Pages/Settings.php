<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class Settings extends Page
{
    use InteractsWithForms;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationIcon = 'eva-settings-outline';
    protected static string $view = 'filament.pages.settings';

    // Page title
    protected static ?string $title = 'Banners Settings';

    protected function getHeaderActions(): array
    {
        return array();
    }

}
