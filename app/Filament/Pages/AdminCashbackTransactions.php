<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;

class AdminCashbackTransactions extends Page implements HasTable
{

    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = "Transactions";
    protected static ?string $navigationLabel = "Cashback Transactions";
    protected static ?string $title = "Cashback Transactions";

    protected static ?int $navigationSort = 8;

    protected static string $view = 'filament.pages.admin-cashback-transactions';

    public static function canAccess(): bool
    {
       return auth()->user()->can_view_transactions;
    }

    public function table(Table $table): Table
{
    return $table
    ->query(
        // ...
        Transaction::where('type','cashback')->orderBy('id', 'desc')->limit(8)
    )
    ->columns([
        //
        TextColumn::make('reference_number')
            ->label('Reference')
            ->searchable()
            ->toggleable()
            ->copyable()
            ->copyMessage('Copied')
            ,
        TextColumn::make('note')
            ->markdown()
            ->toggleable(),
        TextColumn::make('network')
            ->searchable()
            ->sortable()
        ,
        TextColumn::make('plan_name')
            ->searchable()
            ->sortable()
            ->label('Plan'),
        TextColumn::make('user.email')
            ->sortable()
            ->copyable()
            ->copyMessage('Copied')
            ->searchable()
            ->toggleable()
        ,
        TextColumn::make('amount')
            ->searchable()
            ,
        TextColumn::make('old_balance')->label('Old Balance'),
        TextColumn::make('new_balance')->label('New Balance'),
        TextColumn::make('cashback')->label('Cashback Balance'),
        TextColumn::make('created_at')
            ->dateTime()
            ->label('Dated')
            ->sortable(),
        
        TextColumn::make('status')
            ->sortable()
            ->toggleable()
            ->searchable()
            ->badge()
            ->color(fn (string $state): string => match ($state) {
                'successful' => 'success',
                'failed' => 'danger',
                'pending' => 'warning',
                'rejected' => 'danger',
            })
        ,


        
        ]) ->filters([
            SelectFilter::make('status')
            ->options([
                'successful' => 'Successful',
                'failed' => 'Failed',
                'processing' => 'Processing',
                'rejected' => 'Rejected',
            ]),
            Filter::make('created_at')
->form([
    DatePicker::make('created_from'),
    DatePicker::make('created_until'),
])
->query(function (Builder $query, array $data): Builder {
    return $query
        ->when(
            $data['created_from'],
            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
        )
        ->when(
            $data['created_until'],
            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
        );
})
        ]);
}
}
