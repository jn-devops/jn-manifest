<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripTicketResource\Pages;
use App\Filament\Resources\TripTicketResource\RelationManagers;
use App\Filament\Resources\UpdateLogsResource\RelationManagers\UpdateLogRelationManager;
use App\Models\EmployeeGroup;
use App\Models\LocationReason;
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
use STS\FilamentImpersonate\Tables\Actions\Impersonate;


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
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} \n {$record->company->name} \n {$record->department->name} ")
                                ->columnSpan(4),
                            Forms\Components\Select::make('group_code')
                                ->label('Group')
                                ->native(false)
                                ->relationship('group','description')
                                ->required()
                                ->columnSpan(4),
                            Forms\Components\Select::make('projects')
                                ->preload()
                                ->relationship('projects','name')
                                ->multiple()
                                ->native(false)
                                ->columnSpan(4),
                            Forms\Components\DateTimePicker::make('fromDateTime')
                                ->label('From Date Time')
                                ->native(false)
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\DateTimePicker::make('toDateTime')
                                ->label('To Date Time')
                                ->native(false)
                                ->columnSpan(4)
                                ->required(),
                        ])->columns(12)->columnSpanFull(),
                        Forms\Components\Section::make()->schema([
                            Forms\Components\Repeater::make('locations')
                                ->relationship('locations')
                                ->label('Stops')
                                ->schema([
                                    Forms\Components\TextInput::make('location')->required()
                                        ->columnSpan(8),
                                    Forms\Components\Select::make('reason_code')
                                        ->label('Reason')
                                        ->options(LocationReason::pluck('description', 'code'))
                                        ->required()
                                        ->native(false)
                                        ->columnSpan(4),
                                ])
                                ->columns(12)
                                ->maxItems(5)
                                ->minItems(1)
                                ->columnSpanFull(),
                        ]),
                        Forms\Components\Section::make()->schema([
                            Forms\Components\Repeater::make('manifests')
                                ->label('Passengers')
                                ->relationship('manifests')
                                ->schema([

                                    Forms\Components\TextInput::make('name')->required()
                                        ->columnSpan(4),
                                    Forms\Components\TextInput::make('mobile')->columnSpan(4),
                                    Forms\Components\TextInput::make('email')->columnSpan(4),
                                    Forms\Components\Select::make('passenger_type')
                                        ->label('Type')
                                        ->options([
                                            'driver' => 'Driver',
                                            'guest' => 'Guest',
                                            'employee' => 'Employee',
                                        ])
                                        ->required()
                                        ->default('guest')
                                        ->native(false)
                                        ->columnSpan(4),
                                    Forms\Components\Checkbox::make('attended')
                                        ->label('Attended')
                                        ->inline(false)
                                        ->columnSpan(1),
                                    Forms\Components\Checkbox::make('confirmed')
                                        ->label('Confirmed')
                                        ->inline(false)
                                        ->columnSpan(1)
                                        ->hidden(
                                            fn() => auth()->user()->hasRole(['Sales'])
                                        ),
                                ])
                                ->columns(12)
                                ->maxItems(5)
                                ->minItems(1)
                                ->columnSpanFull(),
                        ]),
                        Forms\Components\Section::make()->schema([
                            Forms\Components\Textarea::make('remarks')
                                ->columnSpanFull()
                                ->rows(10)
                                ->columns(10)
                                ->maxLength(255),
                        ]),

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
                            Forms\Components\Section::make()->schema([
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
                Tables\Columns\TextColumn::make('projects.name')
                    ->badge()
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
