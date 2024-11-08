<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripTicketResource\Pages;
use App\Filament\Resources\TripTicketResource\RelationManagers;
use App\Models\TripTicket;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class TripTicketResource extends Resource
{
    protected static ?string $model = TripTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Group::make()->schema([
                        Forms\Components\Section::make()->schema([
                            Forms\Components\Select::make('employee_id')
                                ->label('Employee')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->relationship('employee', 'name')
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} \n {$record->company->name} \n {$record->department->name}"),
                            Forms\Components\Select::make('car_type_id')
                                ->relationship('carType', 'name')
                                ->preload()
                                ->native(false)
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} : {$record->capacity}")
                                ->required(),
                            Forms\Components\Select::make('project_id')
                                ->relationship('project', 'name')
                                ->preload()
                                ->native(false)
                                ->required(),
                            Forms\Components\Select::make('account_id')
                                ->relationship('account', 'name')
                                ->preload()
                                ->native(false)
                                ->required(),
                            Forms\Components\DateTimePicker::make('fromDateTime')
                                ->native(false)
                                ->required(),
                            Forms\Components\DateTimePicker::make('toDateTime')
                                ->native(false)
                                ->required(),
                            Forms\Components\Textarea::make('location')
                                ->rows(5)
                                ->columns(5)
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('remarks')
                                ->columnSpanFull()
                                ->rows(10)
                                ->columns(10)
                                ->maxLength(255),
                            Forms\Components\Repeater::make('manifests')
                                ->label('Passengers')
                                ->schema([
                                    Forms\Components\TextInput::make('name')->required(),
                                    Forms\Components\Select::make('passenger_type')
                                        ->label('Type')
                                        ->options([
                                            'driver' => 'Driver',
                                            'guest' => 'Guest',
                                            'employee' => 'Employee',
                                        ])
                                        ->required()
                                        ->default('guest')
                                        ->native(false),
                                ])
                                ->columns(2)
                                ->maxItems(5)
                                ->minItems(1)
                                ->columnSpanFull()
                                ->hiddenOn('edit'),
                            Forms\Components\Repeater::make('manifests')
                                ->relationship()
                                ->label('Passengers')
                                ->schema([
                                    Forms\Components\TextInput::make('name')->required(),
                                    Forms\Components\Select::make('passenger_type')
                                        ->label('Type')
                                        ->options([
                                            'driver' => 'Driver',
                                            'guest' => 'Guest',
                                            'employee' => 'Employee',
                                        ])
                                        ->required()
                                        ->default('guest')
                                        ->native(false),
                                ])
                                ->columns(2)
                                ->maxItems(5)
                                ->minItems(1)
                                ->columnSpanFull()
                                ->hiddenOn('create'),
                        ])->columns(3)->columnSpanFull(),
                    ])->columns(3)->columnSpan(3),
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([

                                    Placeholder::make('status')
                                        ->content(fn ($record) => $record?->status)
                                        ->hiddenOn('create'),
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Requestor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('carType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fromDateTime')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('toDateTime')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state, Model $record): string => match ($record->status) {
                        'For Approval' => 'gray',
                        'For Revision' => 'warning',
                        'Approved' => 'success',
                        'Rejected' => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTripTickets::route('/'),
            'create' => Pages\CreateTripTicket::route('/create'),
            'edit' => Pages\EditTripTicket::route('/{record}/edit'),
        ];
    }
}
