<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment)
    {
        // Guruh orqali o'qituvchini topish
        $teacher = $payment->teacher;

        if ($teacher) {
            // O'qituvchining foiziga mos summani hisoblash
            $percentageAmount = $payment->amount * ($teacher->salary_percentage / 100);

            // O'qituvchining balansiga qo'shish
            $teacher->addToBalance($percentageAmount);
        }
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
