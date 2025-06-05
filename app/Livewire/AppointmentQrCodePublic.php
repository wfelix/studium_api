<?php

namespace App\Livewire;

use App\Models\Appointment;
use Livewire\Component;

class AppointmentQrCodePublic extends Component
{
    public $phone = "11989701516";
    public $appointmentData = null;

    public function submit()
    {
        $this->resetErrorBag();

        $appointment = Appointment::with('doctor', 'customer')
            ->whereHas('customer', fn($q) => $q->where('phone', $this->phone))
            ->latest()
            ->first();

        if (! $appointment) {
            $this->addError('phone', 'Nenhum agendamento encontrado para este número.');
            return;
        }

        $this->appointmentData = [
            'token' => $appointment->id,
            'customer_name' => optional($appointment->customer)->name ?? 'Não informado',
            'phone' => optional($appointment->customer)->phone ?? 'Não informado',
            'doctor' => [
                'name' => optional($appointment->doctor)->name ?? null,
                'specialty' => optional($appointment->doctor)->specialty ?? null,
            ],
            'scheduled_at' => $appointment->scheduled_at,
            'status' => $appointment->status,
            'notes' => $appointment->notes,
            'checkin_url' => "https://example.com/checkin/{$appointment->id}",
        ];
    }

    public function resetAppointment()
    {
        $this->appointmentData = null;
        // $this->phone = '';
        $this->resetErrorBag();
    }


    public function render()
    {
        return view('livewire.appointment-qr-code-public');
    }
}
