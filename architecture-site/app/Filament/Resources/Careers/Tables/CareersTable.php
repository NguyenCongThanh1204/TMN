<?php

namespace App\Filament\Resources\Careers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CareersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->columns([
                TextColumn::make('job_title')
                    ->label('Vị trí tuyển dụng')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department')
                    ->label('Phòng ban')
                    ->searchable(),

                TextColumn::make('location')
                    ->label('Địa điểm')
                    ->searchable(),

                TextColumn::make('salary_range')
                    ->label('Mức lương')
                    ->searchable(),

                TextColumn::make('deadline')
                    ->label('Hạn nộp')
                    ->date('d/m/Y')
                    ->sortable(),

                // Nút gạt chuyển trạng thái nhanh (Tương tự như ở Project)
                ToggleColumn::make('status')
                    ->label('Đang tuyển')
                    ->getStateUsing(fn ($record) => $record->status === 'open')
                    ->beforeStateUpdated(function ($record, $state) {
                        // Nếu gạt bật (true) -> 'open', gạt tắt (false) -> 'closed'
                        $record->status = $state ? 'open' : 'closed';
                        $record->save();
                    }),

                // Cột nhãn trạng thái (Badge màu) tương tự cột "Đã xuất bản" ở Project
                TextColumn::make('status_badge')
                    ->label('Trạng thái')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->status === 'open' ? 'Đang tuyển' : 'Đã đóng')
                    ->color(fn (string $state): string => match ($state) {
                        'Đang tuyển' => 'success',
                        'Đã đóng' => 'gray',
                        default => 'danger',
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Ngày tạo')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Ngày cập nhật')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}