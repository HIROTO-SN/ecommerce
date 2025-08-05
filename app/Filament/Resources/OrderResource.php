<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource {
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form( Form $form ): Form {
        return $form
        ->schema( [
            Group::make()->schema( [
                Section::make( 'Order Information' )->schema( [
                    Select::make( 'user_id' )
                    ->label( 'Customer' )
                    ->relationship( 'user', 'name' )
                    ->searchable()
                    ->preload()
                    ->required(),
                    Select::make( 'payment_method' )
                    ->options( [
                        'stripe' => 'Stripe',
                        'cod' => 'Cash on Delivery',
                    ] )
                    ->required(),
                    Select::make( 'payment_status' )
                    ->options( [
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ] )
                    ->required()
                    ->default( 'pending' ),
                    Radio::make( 'status' )
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
                    Select::make( 'currency' )
                    ->default( 'usd' )
                    ->required()
                    ->options( [
                        'yen' => 'YEN',
                        'usd' => 'USD',
                        'eur' => 'EUR',
                    ] ),
                    Select::make( 'shipping_method' )
                    ->options( [
                        'fedex' => 'FedEx',
                        'ups' => 'UPS',
                        'dhl' => 'DHL',
                        'usps' => 'USPS',
                    ] ),
                    Textarea::make( 'notes' )
                    ->columnSpanFull()
                ] )->columns( 2 ),

                Section::make( 'Order Items' )->schema( [
                    Repeater::make( 'items' )
                    ->relationship()
                    ->schema( [
                        Select::make( 'product_id' )
                        ->relationship( 'product', 'name' )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->distinct()
                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                        ->columnSpan( 4 ),
                        TextInput::make( 'quantity' )
                        ->numeric()
                        ->required()
                        ->default( 1 )
                        ->minValue( 1 )
                        ->columnSpan( 2 ),
                        TextInput::make( 'unit_amount' )
                        ->numeric()
                        ->required()
                        ->disabled()
                        ->columnSpan( 3 ),
                        TextInput::make( 'total_amount' )
                        ->numeric()
                        ->required()
                        ->columnSpan( 3 )
                    ] )->columns( 12 )
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