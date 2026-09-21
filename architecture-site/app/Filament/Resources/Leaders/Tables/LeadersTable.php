<?php

namespace App\Filament\Resources\Leaders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class LeadersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Ảnh')
                    ->disk('cloudinary')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Họ và tên')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Chức vụ')
                    ->searchable(),

                TextColumn::make('level_id')
                    ->label('Cấp bậc')
                    ->formatStateUsing(fn ($state) => match ((int)$state) {
                        1 => '1. Hội Đồng Quản Trị',
                        2 => '2. Ban Tổng Giám Đốc',
                        3 => '3. Trợ Lý & GĐ Khối',
                        4 => '4. Khối Dự Án',
                        default => 'Khác',
                    })
                    ->sortable(),

                TextColumn::make('position_order')
                    ->label('Thứ tự')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                SelectFilter::make('level_id')
                    ->label('Lọc theo Cấp bậc')
                    ->options([
                        1 => 'Hội Đồng Quản Trị',
                        2 => 'Ban Tổng Giám Đốc',
                        3 => 'Trợ Lý & GĐ Khối',
                        4 => 'Khối Điều Hành Dự Án',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('position_order', 'asc');
    }
}