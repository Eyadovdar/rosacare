<?php

namespace App\Filament\Resources\Abouts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class AboutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Images Section
                Section::make('Images')
                    ->schema([
                        FileUpload::make('hero_image_path')
                            ->label('Hero/Banner Image')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/hero')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['16:9', '21:9'])
                            ->helperText('Hero image for the about page. Recommended size: 1920x1080px (16:9).')
                            ->columnSpanFull(),
                        FileUpload::make('story_image_path')
                            ->label('Story Section Image')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/story')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1', '4:3', '16:9'])
                            ->helperText('Image for the story section. Recommended size: 1200x800px.')
                            ->columnSpanFull(),
                        FileUpload::make('vision_image_path')
                            ->label('Vision Section Image')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/vision')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1', '4:3', '16:9'])
                            ->helperText('Image for the vision section. Recommended size: 1200x800px.')
                            ->columnSpanFull(),
                        FileUpload::make('mission_image_path')
                            ->label('Mission Section Image')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/mission')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1', '4:3', '16:9'])
                            ->helperText('Image for the mission section. Recommended size: 1200x800px.')
                            ->columnSpanFull(),
                        FileUpload::make('heritage_image_path')
                            ->label('Heritage Section Image')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/heritage')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1', '4:3', '16:9'])
                            ->helperText('Image for the heritage section. Recommended size: 1200x800px.')
                            ->columnSpanFull(),
                        FileUpload::make('benefits_image_path')
                            ->label('Benefits Section Image')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/benefits')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1', '4:3', '16:9'])
                            ->helperText('Image for the benefits section. Recommended size: 1200x800px.')
                            ->columnSpanFull(),
                        FileUpload::make('why_rosacare_image_path')
                            ->label('Why RosaCare Section Image')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/why-rosacare')
                            ->visibility('public')
                            ->maxSize(10240)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1', '4:3', '16:9'])
                            ->helperText('Image for the why rosacare section. Recommended size: 1200x800px.')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                // Icons Section
                Section::make('Icons')
                    ->schema([
                        FileUpload::make('story_icon_path')
                            ->label('Story Section Icon')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/icons')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->helperText('Icon for the story section. Recommended size: 64x64px or 128x128px (square).')
                            ->columnSpan(1),
                        FileUpload::make('vision_icon_path')
                            ->label('Vision Section Icon')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/icons')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->helperText('Icon for the vision section. Recommended size: 64x64px or 128x128px (square).')
                            ->columnSpan(1),
                        FileUpload::make('mission_icon_path')
                            ->label('Mission Section Icon')
                            ->image()
                            ->disk('public')
                            ->directory('abouts/icons')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->helperText('Icon for the mission section. Recommended size: 64x64px or 128x128px (square).')
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                // JSON Data Sections
                Section::make('Benefits Data')
                    ->schema([
                        Repeater::make('benefits')
                            ->label('Benefits')
                            ->schema([
                                FileUpload::make('icon_path')
                                    ->label('Icon')
                                    ->image()
                                    ->disk('public')
                                    ->directory('abouts/benefits/icons')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->imageEditorAspectRatios(['1:1'])
                                    ->helperText('Icon for this benefit. Recommended size: 64x64px (square).'),
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(0)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Why RosaCare Reasons')
                    ->schema([
                        Repeater::make('reasons')
                            ->label('Reasons')
                            ->schema([
                                FileUpload::make('icon_path')
                                    ->label('Icon')
                                    ->image()
                                    ->disk('public')
                                    ->directory('abouts/reasons/icons')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->imageEditorAspectRatios(['1:1'])
                                    ->helperText('Icon for this reason. Recommended size: 64x64px (square).'),
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(0)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Heritage Features')
                    ->schema([
                        Repeater::make('heritage_features')
                            ->label('Features')
                            ->schema([
                                FileUpload::make('icon_path')
                                    ->label('Icon')
                                    ->image()
                                    ->disk('public')
                                    ->directory('abouts/heritage/icons')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->imageEditorAspectRatios(['1:1'])
                                    ->helperText('Icon for this feature. Recommended size: 64x64px (square).'),
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(0)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // Status
                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->default(true)
                            ->required()
                            ->helperText('Enable or disable this about page content.'),
                    ]),

                // Translations
                Tabs::make('Translations')
                    ->tabs([
                        Tab::make('Arabic (ar)')
                            ->schema([
                                TextInput::make('story_title:ar')
                                    ->label('Story Title (Arabic)')
                                    ->maxLength(255),
                                Repeater::make('story_paragraphs:ar')
                                    ->label('Story Paragraphs (Arabic)')
                                    ->schema([
                                        Textarea::make('paragraph')
                                            ->label('Paragraph')
                                            ->rows(3)
                                            ->required(),
                                    ])
                                    ->defaultItems(1)
                                    ->helperText('Add multiple paragraphs for the story section. Each paragraph will be displayed separately.')
                                    ->columnSpanFull(),
                                Textarea::make('story_content:ar')
                                    ->label('Story Content (Arabic) - Legacy')
                                    ->rows(4)
                                    ->helperText('Legacy field. Use Story Paragraphs above for better control.')
                                    ->columnSpanFull(),
                                TextInput::make('vision_title:ar')
                                    ->label('Vision Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('vision_content:ar')
                                    ->label('Vision Content (Arabic)')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                TextInput::make('mission_title:ar')
                                    ->label('Mission Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('mission_content:ar')
                                    ->label('Mission Content (Arabic)')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                TextInput::make('heritage_title:ar')
                                    ->label('Heritage Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('heritage_content:ar')
                                    ->label('Heritage Content (Arabic)')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Textarea::make('heritage_subcontent:ar')
                                    ->label('Heritage Subcontent (Arabic)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('why_rosacare_title:ar')
                                    ->label('Why RosaCare Title (Arabic)')
                                    ->maxLength(255),
                                TextInput::make('benefits_title:ar')
                                    ->label('Benefits Title (Arabic)')
                                    ->maxLength(255),
                                TextInput::make('meta_title:ar')
                                    ->label('Meta Title (Arabic)')
                                    ->maxLength(255),
                                Textarea::make('meta_description:ar')
                                    ->label('Meta Description (Arabic)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('meta_keywords:ar')
                                    ->label('Meta Keywords (Arabic)')
                                    ->maxLength(255),
                            ]),
                        Tab::make('English (en)')
                            ->schema([
                                TextInput::make('story_title:en')
                                    ->label('Story Title (English)')
                                    ->maxLength(255),
                                Repeater::make('story_paragraphs:en')
                                    ->label('Story Paragraphs (English)')
                                    ->schema([
                                        Textarea::make('paragraph')
                                            ->label('Paragraph')
                                            ->rows(3)
                                            ->required(),
                                    ])
                                    ->defaultItems(1)
                                    ->helperText('Add multiple paragraphs for the story section. Each paragraph will be displayed separately.')
                                    ->columnSpanFull(),
                                Textarea::make('story_content:en')
                                    ->label('Story Content (English) - Legacy')
                                    ->rows(4)
                                    ->helperText('Legacy field. Use Story Paragraphs above for better control.')
                                    ->columnSpanFull(),
                                TextInput::make('vision_title:en')
                                    ->label('Vision Title (English)')
                                    ->maxLength(255),
                                Textarea::make('vision_content:en')
                                    ->label('Vision Content (English)')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                TextInput::make('mission_title:en')
                                    ->label('Mission Title (English)')
                                    ->maxLength(255),
                                Textarea::make('mission_content:en')
                                    ->label('Mission Content (English)')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                TextInput::make('heritage_title:en')
                                    ->label('Heritage Title (English)')
                                    ->maxLength(255),
                                Textarea::make('heritage_content:en')
                                    ->label('Heritage Content (English)')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Textarea::make('heritage_subcontent:en')
                                    ->label('Heritage Subcontent (English)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('why_rosacare_title:en')
                                    ->label('Why RosaCare Title (English)')
                                    ->maxLength(255),
                                TextInput::make('benefits_title:en')
                                    ->label('Benefits Title (English)')
                                    ->maxLength(255),
                                TextInput::make('meta_title:en')
                                    ->label('Meta Title (English)')
                                    ->maxLength(255),
                                Textarea::make('meta_description:en')
                                    ->label('Meta Description (English)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('meta_keywords:en')
                                    ->label('Meta Keywords (English)')
                                    ->maxLength(255),
                            ]),
                    ]),
            ]);
    }
}
