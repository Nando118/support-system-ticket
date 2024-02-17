<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TicketNumberHelper
{
    public static function generateTicketNumber() {
        // Mendapatkan tahun dan bulan saat ini
        $yearMonth = Carbon::now()->format('Ym');

        // Memulai transaksi database
        DB::beginTransaction();

        try {
            // Mendapatkan nomor ticket terakhir untuk bulan dan tahun saat ini dengan lock untuk mencegah pembacaan ganda
            $lastTicketNumber = DB::table('tickets')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->where('created_at', '<=', Carbon::now()->endOfMonth())
                ->lockForUpdate()
                ->max('ticket_number');

            // Jika tidak ada nomor ticket untuk bulan dan tahun saat ini, set nomor ticket pertama menjadi 1
            if (!$lastTicketNumber) {
                $newTicketNumber = 1;
            } else {
                // Increment nomor ticket
                $newTicketNumber = (int) substr($lastTicketNumber, -6) + 1; // Increment nomor ticket
            }

            // Commit transaksi jika berhasil
            DB::commit();
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();
            throw $e;
        }

        // Format nomor ticket dengan padding 6 digit
        $formattedTicketNumber = str_pad($newTicketNumber, 6, '0', STR_PAD_LEFT);

        // Generate nomor ticket dengan format yang diinginkan
        $ticketNumber = 'SST-' . $yearMonth . '-' . $formattedTicketNumber;

        return $ticketNumber;
    }
}
