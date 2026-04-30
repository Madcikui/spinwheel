<x-filament-panels::page>
    <div class="flex flex-col items-center gap-6 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 flex flex-col items-center gap-4 max-w-md w-full">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">QR Code Cabutan Bertuah</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">Scan QR ini untuk semua cawangan. Sistem akan auto-detect cawangan berdasarkan IC pelajar.</p>

            <div class="p-4 bg-white rounded-lg">{!! $this->getQrCode() !!}</div>

            <p class="text-sm text-gray-500 dark:text-gray-400 break-all text-center font-mono">{{ $this->getSpinUrl() }}</p>

            <button
                onclick="window.print()"
                class="mt-2 px-6 py-2.5 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition"
            >
                Print QR Code
            </button>
        </div>
    </div>
</x-filament-panels::page>
