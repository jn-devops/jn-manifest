<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripTicketResource\Pages;
use App\Filament\Resources\TripTicketResource\RelationManagers;
use App\Filament\Resources\UpdateLogsResource\RelationManagers\UpdateLogRelationManager;
use App\Models\TripTicket;
use App\Models\UpdateLog;
use App\Models\User;
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
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;


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
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} \n {$record->company->name} \n {$record->department->name} "),
                            Forms\Components\Select::make('charge_to')
                                ->label('Charging')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->relationship('charging', 'budget_line_charging_2')
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->budget_line_charging_2} \n {$record->unit} \n {$record->type} \n {$record->department} \n {$record->cost_center}"),
                            Forms\Components\Select::make('car_type_id')
                                ->relationship('carType', 'name')
                                ->preload()
                                ->native(false)
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} : {$record->capacity}")
                                ->required(),
                            Forms\Components\Select::make('provider_code')
                                ->relationship('provider', 'name')
                                ->preload()
                                ->native(false)
                                ->searchable()
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
                            Forms\Components\Textarea::make('pick_up_point')
                                ->label('Pick Up Point')
                                ->rows(5)
                                ->columns(5)
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('drop_off_point')
                                ->label('Drop Off Point')
                                ->rows(5)
                                ->columns(5)
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
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
                            Forms\Components\FileUpload::make('attachments')
                                ->maxSize(10240)
                                ->downloadable()
                                ->openable()
                                ->panelLayout('grid')
                                ->multiple()
                                ->previewable()
                                ->visibility('public')
                                ->directory('ticket-attachments')
                                ->preserveFilenames()
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file,Model $record): string => (string) str($file->getClientOriginalName())
                                        ->prepend(now()->format('Ymd_His').'-'),
                                )
                                ->columnSpanFull(),
                            Forms\Components\Repeater::make('manifests')
                                ->label('Passengers')
                                ->schema([
                                    Forms\Components\TextInput::make('name')->required(),
                                    Forms\Components\TextInput::make('mobile'),
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
                                ->columns(3)
                                ->maxItems(5)
                                ->minItems(1)
                                ->columnSpanFull()
                                ->hiddenOn('edit'),
                            Forms\Components\Repeater::make('manifests')
                                ->relationship()
                                ->label('Passengers')
                                ->schema([
                                    Forms\Components\TextInput::make('name')->required(),
                                    Forms\Components\TextInput::make('mobile'),
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
                                ->columns(3)
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
                                    Forms\Components\TextInput::make('invoice_number')
                                        ->label('Invoice Number'),
                                    Forms\Components\TextInput::make('request_for_payment_number')
                                        ->label('RFP Number'),
                                    Placeholder::make('created_at')
                                        ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;')),
                                    Placeholder::make('updated_at')
                                        ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;'))
                                ]),
                            Forms\Components\Section::make()
                                ->schema([
                                    Placeholder::make('status')
                                        ->label('Status History')
                                        ->content(function ($record) {
                                            $timeline = '<div style="position: relative; max-width: 600px; margin: 0 auto; padding-left: 25px; border-left: 2px solid #ddd;">';

                                            foreach ($record->statuses->sortByDesc('created_at') as $status) {
                                                $date = \Carbon\Carbon::parse($status->created_at);
                                                $timeline .= '
                <div style="margin: 15px 0; padding: 15px 20px; background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); position: relative;">
                    <h4 style="margin: 0; color: #333; font-weight: 600;">' . htmlspecialchars($status->name) . '</h4>
                    <p style="color: #666; margin: 5px 0;">' . htmlspecialchars($status->reason) . '</p>
                    <small style="color: #999; display: block; font-size: 0.9em; margin-top: 5px;">' . $date->format('F j, Y') . '<br>' . $date->format('g:i A') . '</small>
                    <small style="color: #999; font-size: 0.9em;">' . htmlspecialchars(User::find($status->user_id)->name??'' ) . '</small>
                </div>';
                                            }

                                            $timeline .= '</div>';
                                            return new HtmlString($timeline);
                                        })
                                        ->hiddenOn('create'),
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
            UpdateLogRelationManager::class,
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
