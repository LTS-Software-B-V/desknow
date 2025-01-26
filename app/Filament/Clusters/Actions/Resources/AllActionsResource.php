<?php
namespace App\Filament\Clusters\Actions\Resources;

use App\Filament\Clusters\Actions;
use App\Filament\Clusters\Actions\Resources\AllActionsResource\Pages;
use App\Models\Company;
use App\Models\Customer;
use App\Models\systemAction;
use App\Models\User;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AllActionsResource extends Resource
{
    protected static ?string $model            = systemAction::class;
    protected static ?string $navigationLabel  = 'Bedrijfsacties acties';
    protected static ?string $pluralModelLabel = 'Bedrijfsacties acties';
    protected static ?string $title            = 'Bedrijfsacties acties';
    protected static ?int $navigationSort      = 2;
    protected static ?string $cluster          = Actions::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('private', 0)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Textarea::make('body')
                    ->rows(3)
                    ->label('Uitgebreide omschrijving')
                    ->helperText(str('Beschrijf de actie of taak ')->inlineMarkdown()->toHtmlString())
                    ->columnSpan('full')
                    ->autosize(),

                Select::make('type_id')
                    ->options([
                        '1' => 'Terugbelnotitie',
                        '3' => 'Te doen',

                    ])
                    ->searchable()
                    ->default(3)
                    ->label('Type'),

                ToggleButtons::make('private')
                    ->label('Prive actie')
                    ->default(1)
                    ->boolean()
                    ->grouped(),

                Section::make('Toewijzing')
                    ->schema([
                        Split::make([

                            Select::make('for_user_id')
                                ->options(User::pluck('name', 'id'))
                                ->searchable()
                                ->default(Auth::id())
                                ->label('Medewerker'),

                            Select::make('relation_id')
                                ->options(Customer::pluck('name', 'id'))
                                ->searchable()
                                ->label('Relatie'),

                            Select::make('company_id')
                                ->options(Company::pluck('name', 'id'))
                                ->searchable()
                                ->label('Bedrijf'),

                        ]),

                    ]),

                Section::make('Planning')
                    ->icon('heroicon-o-calendar-date-range')
                    ->schema([
                        Split::make([

                            DatePicker::make('plan_date')

                                ->label('Datum'),

                            TimePicker::make('plan_time')
                                ->label('Tijd')
                                ->displayFormat('H:m'),

                        ]),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->modifyQueryUsing(function (Builder $query) {

                return $query->where('private', 0);

            })
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->description(function ($record): ?string {
                        if ($record?->private) {
                            return "Priveactie";
                        } else {
                            return false;
                        }
                    })
                    ->label('#')
                    ->sortable()
                    ->getStateUsing(function ($record): ?string {
                        return sprintf('%06d', $record?->id);
                    }),

                Tables\Columns\TextColumn::make('plan_date')
                    ->label('Plandatum')
                    ->placeholder('-')
                    ->toggleable()
                    ->sortable()
                    ->dateTime("d-m-Y")
                    ->sortable()
                    ->description(function ($record): ?string {
                        return $record->plan_time
                        ? "Tijd: " . date("H:i", strtotime($record?->plan_time)) : "nodate";
                    }),

                Tables\Columns\TextColumn::make('body')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->label('Omschrijving'),

                Tables\Columns\TextColumn::make('type_id')
                    ->badge()
                    ->sortable()
                    ->toggleable()
                    ->label('Type'),

                Tables\Columns\TextColumn::make('customer.name')
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->placeholder("-")
                    ->label('Relatie'),

                Tables\Columns\TextColumn::make('company.name')
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->placeholder("-")
                    ->label('Bedrijf'),

                Tables\Columns\TextColumn::make('for_user.name')
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->placeholder("Geen")
                    ->label('Gebruiker'),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([

                SelectFilter::make('type_id')
                    ->label('Soort')
                    ->options([
                        '1' => 'Terugbel notitie',
                        '3' => 'Te doen',

                    ]),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([

                EditAction::make()
                    ->modalHeading('Snel bewerken')
                    ->modalIcon('heroicon-o-pencil')
                    ->hidden(fn($record) => $record->external_uuid)
                    ->label('')

                    ->slideOver(),
                DeleteAction::make()

                    ->modalDescription(
                        "Weet je zeker dat je deze actie wilt voltooien ?"
                    )

                    ->modalIcon('heroicon-o-check')
                    ->modalHeading('Actie voltooien')
                    ->color('danger')
                    ->label('Voltooien'),
                RestoreAction::make(),
            ])

            ->actions([
                DeleteAction::make()

                    ->modalDescription(
                        "Weet je zeker dat je deze actie wilt voltooien ?"
                    )

                    ->modalIcon('heroicon-o-check')
                    ->modalHeading('Actie voltooien')
                    ->color('danger')
                    ->label('Voltooien'),

                RestoreAction::make()
                    ->color("danger")
                    ->modalHeading('Actie terug plaatsen')
                    ->modalDescription(
                        "Weet je zeker dat je deze actie wilt activeren"
                    ),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),

            ])->emptyState(view("partials.empty-state"));
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
            'index' => Pages\ListAllActions::route('/'),
            // 'create' => Pages\CreateAllActions::route('/create'),
            // 'edit'   => Pages\EditAllActions::route('/{record}/edit'),
        ];
    }
}
