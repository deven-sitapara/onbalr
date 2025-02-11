<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder; // Add this import
use Illuminate\Database\Eloquent\Model;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'phosphor-graduation-cap-duotone';

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        // if not admin
        if (! auth()->user()->hasRole('admin')) {
            return parent::getEloquentQuery()
                ->where('author_id', auth()->id());
        }

        return parent::getEloquentQuery();

    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('author_id')
                ->default(auth()->id()),
                Forms\Components\Section::make('Basic Information')
                    ->schema([

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->required(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->required(),
                            ]),
                        Forms\Components\RichEditor::make('details')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Payment Configuration')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$'),
                                Forms\Components\TextInput::make('net_amount')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->prefix('$'),
                            ]),
                        Forms\Components\Select::make('currency')
                            ->options([
                                'USD' => 'US Dollar',
                                'CAD' => 'Canadian Dollar',
                            ])
                            ->default('USD')
                            ->required(),
                        Forms\Components\Toggle::make('payment_plan_active')
                            ->label('Enable Payment Plan')
                            ->reactive(),
                        Forms\Components\Repeater::make('installments')
                            ->schema([
                                Forms\Components\DatePicker::make('due_date')->required(),
                                Forms\Components\TextInput::make('amount')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->hidden(fn (callable $get) => !$get('payment_plan_active')),
                    ]),

                Forms\Components\Section::make('Discount Configuration')
                    ->schema([
                        Forms\Components\TextInput::make('discount_code'),
                        Forms\Components\DatePicker::make('discount_expiration'),
                        Forms\Components\TextInput::make('discount_amount')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('redemption_limit')
                            ->numeric()
                            ->minValue(0),
                    ]),

                Forms\Components\Section::make('Registration Form')
                    ->schema([
                        Forms\Components\Select::make('registration_type')
                            ->options([
                                'player' => 'Player Registration',
                                'basic' => 'Basic Registration',
                            ])
                            ->required(),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Toggle::make('required_fields.first_name')
                                    ->label('First Name Required')
                                    ->default(true),
                                Forms\Components\Toggle::make('required_fields.last_name')
                                    ->label('Last Name Required')
                                    ->default(true),
                                Forms\Components\Toggle::make('required_fields.email')
                                    ->label('Email Required')
                                    ->default(true),
                                Forms\Components\Toggle::make('required_fields.phone')
                                    ->label('Phone Required')
                                    ->default(true),
                                Forms\Components\Toggle::make('required_fields.dob')
                                    ->label('Date of Birth Required')
                                    ->default(true),
                                Forms\Components\Toggle::make('required_fields.gender')
                                    ->label('Gender Required')
                                    ->default(true),
                                Forms\Components\Toggle::make('required_fields.address')
                                    ->label('Address Required')
                                    ->default(true),
                            ]),
                    ]),

                Forms\Components\Section::make('Custom Questions')
                    ->schema([
                        Forms\Components\Repeater::make('custom_questions')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'short_answer' => 'Short Answer',
                                        'paragraph' => 'Paragraph',
                                        'dropdown' => 'Dropdown',
                                        'checkboxes' => 'Checkboxes',
                                        'file' => 'File Upload',
                                        'waiver' => 'Waiver',
                                    ])
                                    ->required()
                                    ->reactive(),
                                Forms\Components\TextInput::make('question')
                                    ->required(),
                                Forms\Components\Toggle::make('required')
                                    ->default(false),
                                Forms\Components\KeyValue::make('options')
                                    ->addButtonLabel('Add Option')
                                    ->keyLabel('Value')
                                    ->valueLabel('Label')
                                    ->visible(fn (callable $get) =>
                                        in_array($get('type'), ['dropdown', 'checkboxes']))
                                    ->required(fn (callable $get) =>
                                        in_array($get('type'), ['dropdown', 'checkboxes'])),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                            ->reorderable(),
                    ]),

                Forms\Components\Section::make('Donations')
                    ->schema([
                        Forms\Components\Toggle::make('donations_enabled')
                            ->label('Enable Donations')
                            ->reactive(),
                        Forms\Components\KeyValue::make('donation_presets')
                            ->label('Preset Amounts')
                            ->default([
                                '25' => '$25',
                                '50' => '$50',
                                '75' => '$75',
                                '100' => '$100',
                            ])
                            ->hidden(fn (callable $get) => !$get('donations_enabled')),
                        Forms\Components\Toggle::make('allow_custom_donation')
                            ->label('Allow Custom Amount')
                            ->hidden(fn (callable $get) => !$get('donations_enabled')),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('min_donation')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(1),
                                Forms\Components\TextInput::make('max_donation')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(10000),
                             ])
                            ->hidden(fn (callable $get) =>
                                !$get('donations_enabled') || !$get('allow_custom_donation')),


                    ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('payment_plan_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }


    public static function canView(Model $record): bool
    {
        return true;

    }


}
