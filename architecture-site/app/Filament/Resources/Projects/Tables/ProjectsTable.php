<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                // 1. Ảnh bìa xem trước
                ImageColumn::make('cover_image')
                    ->label('Ảnh bìa')
                    ->disk('cloudinary')
                    ->height(50)
                    ->width(80)
                    ->extraImgAttributes([
                        'style' => 'object-fit: cover; border-radius: 4px;',
                    ]),

                // 2. Tên dự án
                TextColumn::make('title')
                    ->label('Tên dự án')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->category?->name ?? 'Chưa phân loại'),

                // 3. Địa điểm
                TextColumn::make('location')
                    ->label('Địa điểm')
                    ->searchable()
                    ->toggleable(),

                // 4. Năm thực hiện
                TextColumn::make('year')
                    ->label('Năm')
                    ->sortable()
                    ->toggleable(),

                // 5. Nút bật/tắt hiển thị Trang chủ ngay lập tức
                ToggleColumn::make('is_featured')
                    ->label('Hiện trang chủ')
                    ->sortable(),

                // 6. Trạng thái xuất bản
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => 'Đã xuất bản',
                        'draft' => 'Bản nháp',
                        default => $state,
                    }),

                // --- CÁC CỘT PHỤ (Ẩn mặc định, có thể bật lại khi cần) ---
                TextColumn::make('client_name')
                    ->label('Chủ đầu tư')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('area_sqm')
                    ->label('Diện tích (m²)')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('structural_type')
                    ->label('Loại kết cấu')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('timeline')
                    ->label('Thời gian thi công')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}