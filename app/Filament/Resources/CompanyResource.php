<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

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
                            ->maxLength(255)
                            ->unique('companies', 'name', ignoreRecord: true)
                            ->columnSpan(2),
                    ])->columns(3)->columnSpan(2),
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
                ])->columnSpanFull()->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
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
            'index' => Pages\ManageCompanies::route('/'),
        ];
    }
}
