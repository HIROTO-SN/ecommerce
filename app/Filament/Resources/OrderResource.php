<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource {
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form( Form $form ): Form {
        return $form
        ->schema( [
            Group::make()->schema( [
                Section::make( 'Order Information' )->schema( [
                    Forms\Components\Select::make( 'user_id' )
                    ->label( 'Customer' )
                    ->relationship( 'user', 'name' )
                    ->searchable()
                    ->preload()
                    ->required(),
                    Forms\Components\Select::make( 'payment_method' )
                    ->options( [
                        'stripe' => 'Stripe',
                        'cod' => 'Cash on Delivery',
                    ] )
                    ->required(),
                    Forms\Components\Select::make( 'payment_status' )
                    ->options( [
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ] )
                    ->required()
                    ->default( 'pending' ),
                    Forms\Components\Radio::make( 'status' )
                    ->default( 'new' )
                    ->inline()
                    ->required()
                    ->options( [
                        'new' => 'New',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled'
                    ] ),
                    Forms\Components\Select::make( 'currency' )
                    ->default( 'usd' )
                    ->required()
                    ->options( [
                        'yen' => 'YEN',
                        'usd' => 'USD',
                        'eur' => 'EUR',
                    ] ),

                ] )
            ] )->columnSpanFull()
        ] );
    }

    public static function table( Table $table ): Table {
        return $table
        ->columns( [
            //
        ] )
        ->filters( [
            //
        ] )
        ->actions( [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ] )
        ->bulkActions( [
            Tables\Actions\BulkActionGroup::make( [
                Tables\Actions\DeleteBulkAction::make(),
            ] ),
        ] )
        ->emptyStateActions( [
            Tables\Actions\CreateAction::make(),
        ] );
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListOrders::route( '/' ),
            'create' => Pages\CreateOrder::route( '/create' ),
            'view' => Pages\ViewOrder::route( '/{record}' ),
            'edit' => Pages\EditOrder::route( '/{record}/edit' ),
        ];
    }

}