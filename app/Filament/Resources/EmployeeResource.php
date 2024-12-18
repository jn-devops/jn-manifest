<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Dropdowns';
    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Group::make()->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique('employees', 'name', ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique('employees', 'email', ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('mobile')
                            ->required()
                            ->prefix('+63')
                            ->regex("/^[0-9]+$/")
                            ->minLength(10)
                            ->maxLength(10)
                            ->unique('employees', 'mobile', ignoreRecord: true)
                            ->columnSpan(1),
                        Forms\Components\Select::make('company_id')
                            ->required()
                            ->preload()
                            ->native(false)
                            ->relationship('company', 'name')
                            ->columnSpan(1),
                        Forms\Components\Select::make('department_id')
                            ->required()
                            ->preload()
                            ->native(false)
                            ->relationship('department', 'name')
                            ->columnSpan(1),
                        Forms\Components\Select::make('market_segment_id')
                            ->required()
                            ->preload()
                            ->native(false)
                            ->relationship('market_segment', 'name')
                            ->columnSpan(1),
                    ])->columns(3)->columnSpan(3),
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([

                                    Placeholder::make('created_at')
                                        ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;')),

                                    Placeholder::make('updated_at')
                                        ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;'))
                                ]),
                        ])
                        ->columnSpan(1),
                ])->columnSpanFull()->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth(MaxWidth::FiveExtraLarge),
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
            'index' => Pages\ManageEmployees::route('/'),
        ];
    }
}
