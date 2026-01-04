<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // General/Non-translatable Settings
                Section::make('General Settings')
                    ->schema([
                        FileUpload::make('logo_header_path')
                            ->label('Header Logo')
                            ->image()
                            ->directory('settings/logos')
                            ->visibility('public')
                            ->nullable(),
                        FileUpload::make('logo_footer_path')
                            ->label('Footer Logo')
                            ->image()
                            ->directory('settings/logos')
                            ->visibility('public')
                            ->nullable(),
                        FileUpload::make('favicon_path')
                            ->label('Favicon')
                            ->image()
                            ->directory('settings/favicons')
                            ->visibility('public')
                            ->nullable(),
                        FileUpload::make('default_meta_image')
                            ->label('Default Meta Image (OG Image)')
                            ->image()
                            ->directory('settings/meta')
                            ->visibility('public')
                            ->nullable(),
                        TextInput::make('google_verification_code')
                            ->label('Google Verification Code')
                            ->nullable(),
                        TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->tel()
                            ->nullable(),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->nullable(),
                        Textarea::make('address')
                            ->label('Address')
                            ->rows(2)
                            ->nullable()
                            ->columnSpanFull(),
                        Textarea::make('google_map_iframe')
                            ->label('Google Map iframe Code')
                            ->rows(3)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // Social Media Links
                Section::make('Social Media Links')
                    ->schema([
                        TextInput::make('facebook')
                            ->label('Facebook URL')
                            ->url()
                            ->nullable(),
                        TextInput::make('twitter')
                            ->label('Twitter/X URL')
                            ->url()
                            ->nullable(),
                        TextInput::make('instagram')
                            ->label('Instagram URL')
                            ->url()
                            ->nullable(),
                        TextInput::make('linkedin')
                            ->label('LinkedIn URL')
                            ->url()
                            ->nullable(),
                        TextInput::make('youtube')
                            ->label('YouTube URL')
                            ->url()
                            ->nullable(),
                        TextInput::make('tiktok')
                            ->label('TikTok URL')
                            ->url()
                            ->nullable(),
                    ])
                    ->columns(2),

                // Translation Tabs for Translatable Fields
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic (ar)')
                            ->schema([
                                TextInput::make('site_name:ar')
                                    ->label('Site Name (Arabic)')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slogan:ar')
                                    ->label('Slogan (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('footer_description:ar')
                                    ->label('Footer Description (Arabic)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('default_meta_title:ar')
                                    ->label('Default Meta Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('default_meta_description:ar')
                                    ->label('Default Meta Description (Arabic)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('default_meta_keywords:ar')
                                    ->label('Default Meta Keywords (Arabic)')
                                    ->maxLength(255),
                                TextInput::make('contact_page_info_title:ar')
                                    ->label('Contact Page Info Title (Arabic)')
                                    ->maxLength(255),
                                TextInput::make('contact_page_form_title:ar')
                                    ->label('Contact Page Form Title (Arabic)')
                                    ->maxLength(255),
                                TextInput::make('google_map_title:ar')
                                    ->label('Google Map Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('footer_copyright:ar')
                                    ->label('Footer Copyright Text (Arabic)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English (en)')
                            ->schema([
                                TextInput::make('site_name:en')
                                    ->label('Site Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slogan:en')
                                    ->label('Slogan (English)')
                                    ->maxLength(255),
                                Textarea::make('footer_description:en')
                                    ->label('Footer Description (English)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('default_meta_title:en')
                                    ->label('Default Meta Title (English)')
                                    ->maxLength(255),
                                Textarea::make('default_meta_description:en')
                                    ->label('Default Meta Description (English)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('default_meta_keywords:en')
                                    ->label('Default Meta Keywords (English)')
                                    ->maxLength(255),
                                TextInput::make('contact_page_info_title:en')
                                    ->label('Contact Page Info Title (English)')
                                    ->maxLength(255),
                                TextInput::make('contact_page_form_title:en')
                                    ->label('Contact Page Form Title (English)')
                                    ->maxLength(255),
                                TextInput::make('google_map_title:en')
                                    ->label('Google Map Title (English)')
                                    ->maxLength(255),
                                Textarea::make('footer_copyright:en')
                                    ->label('Footer Copyright Text (English)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
