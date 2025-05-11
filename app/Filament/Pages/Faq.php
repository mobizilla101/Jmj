<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Faq extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.faq';

    protected static ?string $navigationGroup = 'Settings';

}
