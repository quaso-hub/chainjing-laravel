<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlockchainAuditController extends Controller
{
    /**
     * Mengambil data vote untuk RUU tertentu dari blockchain
     * melalui API server Node.js.
     *
     * @param  int  $ruuId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVotes($ruuId)
    {
        // URL ke API Node.js
        $apiUrl = 'http://localhost:3000/api/ruu/' . $ruuId . '/votes';

        // Log untuk debugging: memastikan method ini terpanggil
        // Log::info('Mencoba mengambil data vote dari blockchain untuk RUU ID: ' . $ruuId);

        try {
            // =======================================================
            // INI ADALAH PERBAIKANNYA -> withoutVerifying()
            // =======================================================
            $response = Http::withoutVerifying()->timeout(15)->get($apiUrl);

            // Log untuk debugging: melihat response dari Node.js
            // Log::info('Response dari server Node.js:', [
            //     'status' => $response->status(),
            //     'body' => $response->body()
            // ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Gagal mengambil data dari ledger. Server blockchain merespon dengan error.',
                    'details' => $response->json() ?? $response->body()
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Log error jika terjadi exception
            // Log::error('Koneksi ke Node.js Gagal Total:', ['message' => $e->getMessage()]);

            return response()->json([
                'error' => true,
                'message' => 'Tidak dapat terhubung ke server blockchain.',
                'details' => $e->getMessage()
            ], 504); // 504 Gateway Timeout
        }
    }

    public function getAlokasiDana($alokasiId)
    {
        $apiUrl = 'http://localhost:3000/api/alokasi-dana/' . $alokasiId;
        try {
            $response = Http::withoutVerifying()->timeout(10)->get($apiUrl);
            if ($response->successful()) {
                return response()->json($response->json());
            }
            return response()->json(['error' => true, 'message' => 'Data tidak ditemukan di ledger.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Tidak dapat terhubung ke server blockchain.'], 504);
        }
    }
}
