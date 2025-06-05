@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<div class="max-w-md p-6 mx-auto mt-10 bg-white rounded shadow">
    <div class="flex justify-center mb-6">
        <img src="{{ asset('logo-neutrino.png') }}" alt="Logo Neutrino" class="w-24 h-24 rounded-full shadow" />
    </div>

    @if ($appointmentData)
        <div class="mt-6 text-center">
            <h2 class="mb-2 text-lg font-semibold">Agendamento Encontrado</h2>
            <p><strong>Paciente:</strong> {{ $appointmentData['customer_name'] }}</p>
            @if (isset($appointmentData['doctor']['name']))
                <p><strong>Médico:</strong> {{ $appointmentData['doctor']['name'] }}
                    ({{ $appointmentData['doctor']['specialty'] }})</p>
            @endif
            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($appointmentData['scheduled_at'])->format('d/m/Y H:i') }}
            </p>

            <div class="flex justify-center mt-4">
                {!! QrCode::size(256)->generate(json_encode($appointmentData)) !!}
            </div>

            <button wire:click="resetAppointment"
                class="px-6 py-3 mt-4 text-lg font-semibold text-white transition bg-gray-600 hover:bg-gray-700 rounded-xl">
                Buscar outro agendamento
            </button>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-10 text-center">
            <label class="block">
                <span class="block mb-4 text-2xl text-gray-700">Digite seu número de celular</span>
                <input type="tel" wire:model.defer="phone" placeholder="(11) 91234-5678"
                    class="w-full px-8 py-6 text-3xl border-2 border-gray-300 shadow-sm rounded-xl focus:ring-4 focus:ring-blue-500 focus:outline-none" />
                @error('phone')
                    <span class="block mt-2 text-lg text-red-500">{{ $message }}</span>
                @enderror
            </label>

            <button type="submit"
                class="w-full px-10 py-6 text-3xl font-bold text-white transition bg-blue-600 shadow hover:bg-blue-700 rounded-xl">
                Buscar Agendamento
            </button>
        </form>
    @endif
</div>
