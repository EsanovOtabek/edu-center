<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Dividend;
use App\Models\Teacher;


class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::query();

        // Filter by payment method if selected
        if ($request->has('payment_method') && $request->payment_method != 'all') {
            $payments = $payments->where('payment_method', $request->payment_method);
        }

        $payments = $payments->with('student', 'group')->get();

        $paymentMethods = ['all', 'cash', 'bank', 'online']; // Possible payment methods

        return view('dashboard.payment.index', compact('payments', 'paymentMethods'));
    }

    public function create()
    {
        $students = Student::all();
        $groups = Group::with('teacher')->get();

        return view('dashboard.payment.create', compact('students', 'groups'));
    }

    public function getGroupsByStudent(Request $request)
    {
        $studentId = $request->student_id;

        $groups = Group::whereHas('students', function ($query) use ($studentId) {
            $query->where('students.id', $studentId); // 'id'ni 'students.id' bilan aniqlaymiz
        })->with('teacher')->get();

        return response()->json($groups);
    }


    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'group_id' => 'required|exists:groups,id',
            'teacher_id' => 'required|exists:teachers,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|in:UZS,USD',
            'payment_method' => 'required|in:cash,bank,online',
            'payment_period_start' => 'required|date|before_or_equal:payment_period_end',
            'payment_period_end' => 'required|date|after_or_equal:payment_period_start',
            'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        // Faylni yuklash
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }
        // To'lov summasi va o'qituvchi foizini hisoblash
        $amount = $request->amount;
        $teacherPercentage = Teacher::find($request->teacher_id)->salary_percentage;
        $teacherAmount = $amount * ($teacherPercentage / 100); // O'qituvchi ulushi
        $remainBalance = $amount - $teacherAmount; // Qolgan mablag'


        $student = Student::find($request->student_id);
        $payment = new Payment([
            'group_id' => $request->group_id,
            'teacher_id' => $request->teacher_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'payment_method' => $request->payment_method,
            'receipt' => $receiptPath,
            'payment_period_start' => $request->payment_period_start,
            'payment_period_end' => $request->payment_period_end,
            'remain_balance' => $remainBalance,
        ]);
        $student->payments()->save($payment);


        return redirect()->route('admin.payment.index')->with('success', "To'lov muvaffaqiyatli qo'shildi.");
    }

}
