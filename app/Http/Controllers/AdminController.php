<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
 use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\FlightBooking;
use App\Models\HotelBooking;
use App\Models\VisaRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\VisaStatusMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisaExport;
use App\Models\Car;
use App\Models\CarBooking;
use Carbon\Carbon;
use App\Models\TourBooking;
use App\Models\Package;
use Illuminate\Support\Str;
use App\Models\ChatMessage;
use App\Models\Client; 
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use App\Models\VisaApplication;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;





class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // only logged-in users
    }

 public function dashboard(Request $request)
{
    $tables = [
        'flight_bookings' => FlightBooking::class,
        'hotel_bookings'  => HotelBooking::class,
        'car_bookings'    => CarBooking::class,
        'tour_bookings'   => TourBooking::class,
        'visa_requests'   => VisaRequest::class,
    ];

    // ✅ Default KPI variables
    $totalapplications = 0;
    $pending = 0;
    $approved = 0;
    $rejected = 0;

    $applications = collect();

    try {
        foreach ($tables as $type => $model) {

            $records = $model::latest()->get();

            $totalapplications += $records->count();
            $pending += $records->where('status', 'pending')->count();
            $approved += $records->where('status', 'approved')->count();
            $rejected += $records->where('status', 'rejected')->count();

            $mapped = $records->map(function ($item) use ($type) {
                return (object)[
                    'id' => $item->id,
                    'name' => $item->name
                        ?? trim(($item->first_name ?? '') . ' ' . ($item->last_name ?? ''))
                        ?: 'N/A',
                    'country' => $item->country
                        ?? $item->destination
                        ?? $item->destination_city
                        ?? $item->pickup_location
                        ?? $item->location
                        ?? 'N/A',
                    'status' => strtolower($item->status ?? 'pending'),
                    'created_at' => $item->created_at,
                    'type' => $type
                ];
            });

            $applications = $applications->merge($mapped);
        }

        // SORT by newest first
        $applications = $applications->sortByDesc('created_at');

        // FILTER by search
        if ($request->search) {
            $search = strtolower($request->search);
            $applications = $applications->filter(function ($app) use ($search) {
                return str_contains(strtolower($app->name), $search) ||
                       str_contains(strtolower($app->country), $search);
            });
        }

        // FILTER by status safely
        if ($request->status) {
            $status = strtolower($request->status);
            $applications = $applications->filter(fn($app) => $app->status === $status);
        }

        // RESET INDEX
        $applications = $applications->values();

    } catch (\Exception $e) {
        // If something goes wrong, keep variables at defaults
        $totalapplications = $totalapplications ?? 0;
        $pending = $pending ?? 0;
        $approved = $approved ?? 0;
        $rejected = $rejected ?? 0;
        $applications = $applications ?? collect();
    }

    // CHART last 6 months
    $months = [];
    $counts = [];

    try {
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');

            $count = 0;
            foreach ($tables as $model) {
                $count += $model::whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->count();
            }

            $counts[] = $count;
        }
    } catch (\Exception $e) {
        $months = $months ?? [];
        $counts = $counts ?? [];
    }

    // ✅ Return view with guaranteed variables
    return view('admin.dashboard', compact(
        'totalapplications',
        'pending',
        'approved',
        'rejected',
        'applications',
        'months',
        'counts'
    ));
}
public function updateStatus(Request $request)
{
    $tables = [
        'flight_bookings' => FlightBooking::class,
        'hotel_bookings'  => HotelBooking::class,
        'car_bookings'    => CarBooking::class,
        'tour_bookings'   => TourBooking::class,
        'visa_requests'   => VisaRequest::class,
    ];

    if (!isset($tables[$request->type])) {
        return response()->json(['error' => 'Invalid type'], 400);
    }

    $model = $tables[$request->type];

    $record = $model::find($request->id);

    if (!$record) {
        return response()->json(['error' => 'Not found'], 404);
    }

    $record->status = $request->status;
    $record->save();

    return response()->json(['success' => true]);
}  




    // New method to show flight bookings
    public function flightBookings()
    {
        $bookings = FlightBooking::latest()->get(); // fetch all bookings
        return view('admin.flight_bookings', compact('bookings'));
    }



public function exportPDF()
{
    $bookings = FlightBooking::query();

if(request('status')) {
    $bookings->where('status', request('status'));
}

if(request('destination')) {
    $bookings->where('destination_city', request('destination'));
}

$bookings = $bookings->get();
    
    $pdf = Pdf::loadView('admin.flight_bookings_pdf', compact('bookings'))
              ->setPaper('a4', 'landscape'); // <-- landscape fixes cutting

    return $pdf->download('flight_bookings_' . date('Y-m-d_H:i') . '.pdf');
}
public function updateflightStatus(Request $request, FlightBooking $booking)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,cancelled'
    ]);

    $booking->update(['status' => $request->status]);

    Alert::success('Success', 'Booking status updated successfully!');

    // Redirect back to the bookings page
    return redirect()->route('admin.flight.bookings');
}
public function deleteBooking(FlightBooking $booking)
{
    $booking->delete();
    Alert::success('Success', 'Booking deleted successfully!');
    return redirect()->back();
    
}
public function hotelBookings(Request $request)
{
    $search = $request->search;
    $fromDate = $request->from_date;
    $toDate = $request->to_date;

    $query = HotelBooking::query();

    // Search filter
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('phone', 'like', "%$search%");
        });
    }

    // Date filters
    if ($fromDate) {
        $query->whereDate('created_at', '>=', $fromDate);
    }

    if ($toDate) {
        $query->whereDate('created_at', '<=', $toDate);
    }

    $bookings = $query->latest()->paginate(10);

    // Statistics
    $totalBookings = HotelBooking::count();
    $todayBookings = HotelBooking::whereDate('created_at', today())->count();
    $monthlyBookings = HotelBooking::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

    return view('admin.hotel_bookings', compact(
        'bookings',
        'search',
        'fromDate',
        'toDate',
        'totalBookings',
        'todayBookings',
        'monthlyBookings'
    ));
}
public function viewhotelBooking($id)
{
    $booking = HotelBooking::findOrFail($id);

    return view('admin.view_hotel_booking', compact('booking'));
}
public function deletehotelBooking($id)
{
    $booking = HotelBooking::findOrFail($id);
    $booking->delete();
    Alert::success('Success', 'Reservation deleted successfully!');
    return redirect()->back();
}
public function updateHotelStatus(Request $request, HotelBooking $booking)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,cancelled'
    ]);

    $booking->update(['status' => $request->status]);

    Alert::success('Success', 'Booking status updated successfully!');

    return redirect()->back();
}

public function exportHotelPDF()
{
    $bookings = HotelBooking::latest()->get();

    $pdf = Pdf::loadView('admin.hotel_bookings_pdf', compact('bookings'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('hotel_reservations_' . date('Y-m-d_H-i') . '.pdf');
}

public function viewVisa($id)
{
    $visa = VisaRequest::findOrFail($id);

    return response()->json($visa);
}
public function deleteVisa($id)
{
    $visa = VisaRequest::findOrFail($id);
    $visa->delete();

    Alert::success('Success', 'Visa request deleted successfully!');

    return redirect()->back();
}
public function visaApplications(Request $request)
{

$query = VisaRequest::query();

if($request->visa_type){
    $query->where('visa_type', $request->visa_type);
}

if($request->country){
    $query->where('country', $request->country);
}

if($request->date){
    $query->whereDate('created_at', $request->date);
}

$visas = $query->latest()->paginate(10);

/* CLONE QUERY FOR STATS */

$statsQuery = clone $query;

/* STATUS STATS */

$statusStats = [

    'total' => $statsQuery->count(),

    'pending' => (clone $statsQuery)->where('status','Pending')->count(),

    'processing' => (clone $statsQuery)->where('status','Processing')->count(),

    'approved' => (clone $statsQuery)->where('status','Approved')->count(),

    'rejected' => (clone $statsQuery)->where('status','Rejected')->count()

];

/* VISA TYPE STATS */

$typeStats = [

    'tourist' => VisaRequest::where('visa_type','tourist')->count(),

    'study' => VisaRequest::where('visa_type','study')->count(),

    'work' => VisaRequest::where('visa_type','work')->count(),

    'business' => VisaRequest::where('visa_type','business')->count()

];
$monthly = VisaRequest::selectRaw('MONTH(created_at) month, count(*) total')
->groupBy('month')
->pluck('total','month');
return view('admin.visa_applications', compact('visas','statusStats','typeStats','monthly'));

}



public function exportVisaPDF()
{

$visas = VisaRequest::all();

$pdf = Pdf::loadView('pdf.visa_requests',compact('visas'));

return $pdf->download('visa_requests.pdf');

}

public function exportVisaExcel()
{
    $visas = \App\Models\VisaRequest::all();

    $filename = "visa_requests.xls";

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = [
        'ID',
        'First Name',
        'Last Name',
        'Email',
        'Phone',
        'Visa Type',
        'Country',
        'Status',
        'Date'
    ];

    $callback = function() use($visas, $columns) {

        $file = fopen('php://output', 'w');

        fputcsv($file, $columns);

        foreach ($visas as $visa) {

            fputcsv($file, [
                $visa->id,
                $visa->first_name,
                $visa->last_name,
                $visa->email,
                $visa->phone,
                $visa->visa_type,
                $visa->country,
                $visa->status,
                $visa->created_at
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
public function updateVisaStatus(Request $request, $id)
{
    // Validate status
    $request->validate([
        'status' => 'required|in:Pending,Processing,Approved,Rejected'
    ]);

    // Find the visa request
    $visa = VisaRequest::findOrFail($id);

    // Update the status
    $visa->status = $request->status;
    $visa->save();

    // SweetAlert success message
    Alert::success('Success', "Visa status updated to {$visa->status}!");

    // Redirect back to the visa dashboard page
    return redirect()->back();
}
public function carsIndex()
{
    $cars = Car::latest()->get();

    return view('admin.cars.index', compact('cars'));
}
public function carsCreate()
{
    return view('admin.cars.create');
}
public function carsStore(Request $request)
{

$image = $request->file('image')->store('cars','public');

Car::create([

'name'=>$request->name,
'type'=>$request->type,
'transmission'=>$request->transmission,
'seats'=>$request->seats,
'price_per_day'=>$request->price_per_day,
'image'=>$image,
'location' => $request->location, 

]);


Alert::success('Success', "car added successfully!");
     return redirect()->route('admin.cars.index');

}
// In AdminController.php
public function CarsEdit(Car $car)
{
    return view('admin.cars.edit', compact('car'));
}
public function updateCar(Request $request, Car $car)
{
    if ($request->hasFile('image')) {
        $image = $request->file('image')->store('cars', 'public');
        $car->image = $image;
    }

    $car->update([
        'name' => $request->name,
        'type' => $request->type,
        'transmission' => $request->transmission,
        'seats' => $request->seats,
        'price_per_day' => $request->price_per_day,
    ]);

    Alert::success('Success', "Car updated successfully!");
    return redirect()->route('admin.cars.index');
}
public function carsDestroy(Car $car)
{

$car->delete();
Alert::success('Success', "Car deleted successfully!");
    return redirect()->back();

}

public function cardashboard()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        // Stats Cards
        $totalCars = Car::count();
        $totalBookings = CarBooking::count();
        $pendingBookings = CarBooking::where('status', 'pending')->count();
        $confirmedBookings = CarBooking::where('status', 'confirmed')->count();
        $completedBookings = CarBooking::where('status', 'completed')->count();
        $cancelledBookings = CarBooking::where('status', 'cancelled')->count();
        
        // Revenue Stats
        $totalRevenue = CarBooking::where('status', 'completed')->sum('total_price');
        $todayRevenue = CarBooking::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('total_price');
        $monthRevenue = CarBooking::where('status', 'completed')
            ->where('created_at', '>=', $thisMonth)
            ->sum('total_price');
        
        // Recent Bookings
        $recentBookings = CarBooking::with('car')
            ->latest()
            ->take(10)
            ->get();
        
        // Popular Cars
        $popularCars = Car::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();
        
        // Monthly Revenue Chart Data
        $monthlyRevenue = CarBooking::where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('month')
            ->pluck('total', 'month');
        
        // Booking Status Distribution
        $statusDistribution = [
            'pending' => $pendingBookings,
            'confirmed' => $confirmedBookings,
            'completed' => $completedBookings,
            'cancelled' => $cancelledBookings
        ];
        
        // Upcoming Pickups (next 7 days)
        $upcomingPickups = CarBooking::with('car')
            ->where('status', 'confirmed')
            ->whereDate('pickup_date', '>=', $today)
            ->whereDate('pickup_date', '<=', Carbon::now()->addDays(7))
            ->orderBy('pickup_date')
            ->take(5)
            ->get();
        
        return view('admin.cardashboard', compact(
            'totalCars',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'completedBookings',
            'cancelledBookings',
            'totalRevenue',
            'todayRevenue',
            'monthRevenue',
            'recentBookings',
            'popularCars',
            'monthlyRevenue',
            'statusDistribution',
            'upcomingPickups'
        ));
    }

    // Enhanced Car Bookings with Filters
    public function carBookings(Request $request)
{
    $query = CarBooking::with('car');

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter by from date
    if ($request->filled('from_date')) {
        $query->whereDate('pickup_date', '>=', $request->from_date);
    }

    // Filter by to date
    if ($request->filled('to_date')) {
        $query->whereDate('return_date', '<=', $request->to_date);
    }

    // Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%")
              ->orWhereHas('car', function ($carQuery) use ($search) {
                  $carQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    $bookings = $query->latest()->paginate(15);

    $totalBookings = CarBooking::count();
    $pendingCount = CarBooking::where('status', 'pending')->count();
    $confirmedCount = CarBooking::where('status', 'confirmed')->count();
    $completedCount = CarBooking::where('status', 'completed')->count();
    $cancelledCount = CarBooking::where('status', 'cancelled')->count();

    return view('admin.car_bookings.index', compact(
        'bookings',
        'totalBookings',
        'pendingCount',
        'confirmedCount',
        'completedCount',
        'cancelledCount'
    ));
}
    // Enhanced Booking Details
    public function carBookingDetails($id)
    {
        $booking = CarBooking::with('car')->findOrFail($id);
        
        // Generate booking reference if not exists
        if (!$booking->booking_reference) {
            $booking->booking_reference = 'CRB' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
            $booking->save();
        }
        
        // Calculate days
        $pickup = Carbon::parse($booking->pickup_date);
        $return = Carbon::parse($booking->return_date);
        $days = $pickup->diffInDays($return) ?: 1;
        
        // Get booking history/timeline
        $timeline = [
            ['status' => 'created', 'date' => $booking->created_at, 'note' => 'Booking created'],
            ['status' => $booking->status, 'date' => $booking->updated_at, 'note' => 'Status updated to ' . $booking->status]
        ];
        
        return view('admin.car_bookings.details', compact('booking', 'days', 'timeline'));
    }

    // Update Status with Email Notification
    public function updateCarBookingStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $booking = CarBooking::findOrFail($id);
        $oldStatus = $booking->status;
        $booking->status = $request->status;
        $booking->save();

        // Send email notification for status change
        if ($oldStatus != $request->status) {
            $this->sendStatusNotification($booking, $oldStatus);
        }

        // Generate and send invoice if confirmed
        if ($request->status == 'confirmed' && $oldStatus != 'confirmed') {
            $this->generateAndSendInvoice($booking);
        }

        Alert::success('Success!', 'Booking status updated successfully.');
        return back();
    }

    // Delete Booking
    public function deleteCarBooking($id)
    {
        $booking = CarBooking::findOrFail($id);
        $booking->delete();

        Alert::success('Deleted!', 'Booking deleted successfully.');
        return redirect()->route('admin.car.bookings');
    }

    // Generate PDF Invoice
    public function generateInvoice($id)
    {
        $booking = CarBooking::with('car')->findOrFail($id);
        
        if (!$booking->booking_reference) {
            $booking->booking_reference = 'CRB' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
            $booking->save();
        }
        
        $pdf = PDF::loadView('admin.car_bookings.invoice', compact('booking'));
        
        return $pdf->download('invoice-' . $booking->booking_reference . '.pdf');
    }

    // View Invoice
    public function viewInvoice($id)
    {
        $booking = CarBooking::with('car')->findOrFail($id);
        
        if (!$booking->booking_reference) {
            $booking->booking_reference = 'CRB' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
            $booking->save();
        }
        
        return view('admin.car_bookings.invoice', compact('booking'));
    }

    // Send Invoice Email
    public function sendInvoiceEmail($id)
    {
        $booking = CarBooking::with('car')->findOrFail($id);
        
        try {
            $this->generateAndSendInvoice($booking);
            
            return response()->json([
                'success' => true,
                'message' => 'Invoice sent successfully to ' . $booking->email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    // Bulk Actions
    public function bulkAction(Request $request)
{
    $request->validate([
        'action' => 'required|in:delete,confirm,cancel,complete,export',
        'booking_ids' => 'required|array'
    ]);

    $bookings = CarBooking::with('car')->whereIn('id', $request->booking_ids)->get();

    switch ($request->action) {
        case 'delete':
            $count = $bookings->count();
            CarBooking::whereIn('id', $request->booking_ids)->delete();
            Alert::success('Success!', $count . ' bookings deleted.');
            break;

        case 'confirm':
            foreach ($bookings as $booking) {
                $booking->update(['status' => 'confirmed']);
                $this->generateAndSendInvoice($booking);
            }
            Alert::success('Success!', $bookings->count() . ' bookings confirmed and invoices sent.');
            break;

        case 'cancel':
            foreach ($bookings as $booking) {
                $booking->update(['status' => 'cancelled']);
            }
            Alert::success('Success!', $bookings->count() . ' bookings cancelled.');
            break;

        case 'complete':
            foreach ($bookings as $booking) {
                $booking->update(['status' => 'completed']);
            }
            Alert::success('Success!', $bookings->count() . ' bookings marked as completed.');
            break;

        case 'export':
            return $this->exportSelectedBookings($request->booking_ids);
    }

    return redirect()->back();
}

    // Export Selected Bookings
    private function exportSelectedBookings($ids)
    {
        $bookings = CarBooking::with('car')->whereIn('id', $ids)->get();
        
        $filename = "bookings-export-" . Carbon::now()->format('Y-m-d-His') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Add headers
        fputcsv($handle, [
            'Booking Reference',
            'Customer Name',
            'Email',
            'Phone',
            'Car',
            'Pickup Date',
            'Pickup Time',
            'Return Date',
            'Pickup Location',
            'With Driver',
            'Total Price',
            'Status',
            'Booking Date'
        ]);
        
        foreach ($bookings as $booking) {
            fputcsv($handle, [
                $booking->booking_reference ?? 'CRB'.str_pad($booking->id,6,'0',STR_PAD_LEFT),
                $booking->name,
                $booking->email,
                $booking->phone,
                $booking->car->name ?? 'N/A',
                $booking->pickup_date,
                $booking->pickup_time,
                $booking->return_date,
                $booking->pickup_location,
                $booking->with_driver ? 'Yes' : 'No',
                $booking->total_price,
                $booking->status,
                $booking->created_at->format('Y-m-d H:i:s')
            ]);
        }
        
        fclose($handle);
        exit;
    }

    // Export All Bookings
   public function exportBookings(Request $request)
{
    $query = CarBooking::with('car');

    if ($request->filled('ids')) {
        $ids = explode(',', $request->ids);
        $query->whereIn('id', $ids);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('from_date')) {
        $query->whereDate('pickup_date', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('return_date', '<=', $request->to_date);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    $bookings = $query->get();

    $filename = "all-bookings-" . Carbon::now()->format('Y-m-d-His') . ".csv";

    return response()->streamDownload(function () use ($bookings) {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'Booking Reference',
            'Customer Name',
            'Email',
            'Phone',
            'Car',
            'Pickup Date',
            'Pickup Time',
            'Return Date',
            'Pickup Location',
            'With Driver',
            'Total Price',
            'Status',
            'Booking Date'
        ]);

        foreach ($bookings as $booking) {
            fputcsv($handle, [
                $booking->booking_reference ?? 'CRB' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                $booking->name,
                $booking->email,
                $booking->phone,
                optional($booking->car)->name ?? 'N/A',
                $booking->pickup_date,
                $booking->pickup_time,
                $booking->return_date,
                $booking->pickup_location,
                $booking->with_driver ? 'Yes' : 'No',
                $booking->total_price,
                $booking->status,
                optional($booking->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
    }, $filename, [
        'Content-Type' => 'text/csv',
    ]);
}
    // Private Methods
    private function generateAndSendInvoice($booking)
    {
        if (!$booking->booking_reference) {
            $booking->booking_reference = 'CRB' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
            $booking->save();
        }
        
        $pdf = PDF::loadView('admin.car_bookings.invoice', compact('booking'));
        
        $pdfPath = storage_path('app/public/invoices/invoice-' . $booking->booking_reference . '.pdf');
        
        if (!file_exists(storage_path('app/public/invoices'))) {
            mkdir(storage_path('app/public/invoices'), 0755, true);
        }
        
        $pdf->save($pdfPath);
        
        Mail::send('emails.car_booking-confirmation', ['booking' => $booking], function($message) use ($booking, $pdfPath) {
            $message->to($booking->email, $booking->name)
                    ->subject('Booking Confirmed - ' . ($booking->booking_reference ?? 'CRB'.str_pad($booking->id,6,'0',STR_PAD_LEFT)))
                    ->attach($pdfPath, [
                        'as' => 'invoice-' . ($booking->booking_reference ?? 'CRB'.str_pad($booking->id,6,'0',STR_PAD_LEFT)) . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
        });
    }

    private function sendStatusNotification($booking, $oldStatus)
    {
        Mail::send('emails.status-update', ['booking' => $booking, 'oldStatus' => $oldStatus], function($message) use ($booking) {
            $message->to($booking->email, $booking->name)
                    ->subject('Booking Status Updated - ' . ($booking->booking_reference ?? 'CRB'.str_pad($booking->id,6,'0',STR_PAD_LEFT)));
        });
    }


// Show all tour bookings
public function tourBookings()
{
    $bookings = TourBooking::latest()->get();
    return view('admin.tours.index', compact('bookings'));
}

// View single booking
public function viewTour($id)
{
    $booking = TourBooking::findOrFail($id);
    return view('admin.tours.view', compact('booking'));
}

// Update status
public function updateTourStatus(Request $request, $id)
{
    $booking = TourBooking::findOrFail($id);
    $booking->status = $request->status;
    $booking->save();
   Alert::success('Success', "status updated successfully!");

    // Redirect back to the visa dashboard page
    return redirect()->back();
    
}

// Delete booking
public function deleteTour($id)
{
    TourBooking::findOrFail($id)->delete();
    Alert::success('Success', "Booking deleted successfully!");
    return redirect()->back();
}


public function tourPdf($id)
{
    $booking = TourBooking::findOrFail($id);
    $pdf = Pdf::loadView('admin.tours.individual_pdf', compact('booking'));
    return $pdf->download('booking_'.$booking->id.'.pdf');
}
public function packages()
{
    $packages = Package::latest()->get();
    return view('admin.packages.index', compact('packages'));
}
public function createPackage()
{
    return view('admin.packages.create');
}
public function storePackage(Request $request)
{
    $request->validate([
        'title' => 'required',
        'country' => 'required',
        'duration' => 'required',
        'price' => 'required|numeric',
        'image' => 'required|image',
    ]);

    $imagePath = $request->file('image')->store('packages', 'public');

    Package::create([
        'title' => $request->title,
        'slug' => Str::slug($request->title),
        'country' => $request->country,
        'duration' => $request->duration,
        'price' => $request->price,
        'includes' => json_encode($request->includes),
        'is_popular' => $request->has('is_popular'),
        'image' => $imagePath,
    ]);

    
    Alert::success('Success', "Package created successfully!");
    return redirect()->route('admin.packages');
}
public function editPackage($id)
{
    $package = Package::findOrFail($id);
    return view('admin.packages.edit', compact('package'));
}
public function updatePackage(Request $request, $id)
{
    $package = Package::findOrFail($id);

    $request->validate([
        'title' => 'required',
        'country' => 'required',
        'duration' => 'required',
        'price' => 'required|numeric',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('packages', 'public');
        $package->image = $imagePath;
    }

    $package->update([
        'title' => $request->title,
        'country' => $request->country,
        'duration' => $request->duration,
        'price' => $request->price,
        'includes' => json_encode($request->includes),
        'is_popular' => $request->has('is_popular'),
    ]);

    Alert::success('Success', "Package updated successfully!");
    return redirect()->route('admin.packages');
}
public function deletePackage($id)
{
    $package = Package::findOrFail($id);
    $package->delete();

    Alert::success('Success', "Package deleted successfully!");
    return redirect()->route('admin.packages');    
}
public function adminChat()
{
    // Fetch all messages
    $messages = ChatMessage::orderBy('created_at', 'desc')->get();

    return view('admin.chat', compact('messages'));
}

// Inside AdminController.php

// Make sure this is imported

// 1. Show all clie

public function clients()
{
    $clients = [];

    // 1️⃣ FLIGHT BOOKINGS
    $flights = DB::table('flight_bookings')
        ->select('first_name', 'last_name', 'email', 'phone')
        ->get();

    foreach ($flights as $row) {
        $phone = preg_replace('/\D/', '', $row->phone);

        if (!isset($clients[$phone])) {
            $clients[$phone] = [
                'id' => $phone,
                'name' => $row->first_name . ' ' . $row->last_name,
                'email' => $row->email,
                'phone' => $row->phone,
                'bookings_count' => 1,
                'is_active' => 1
            ];
        } else {
            $clients[$phone]['bookings_count']++;
        }
    }

    // 2️⃣ HOTEL BOOKINGS
    $hotels = DB::table('hotel_bookings')
        ->select('first_name', 'last_name', 'email', 'phone')
        ->get();

    foreach ($hotels as $row) {
        $phone = preg_replace('/\D/', '', $row->phone);

        if (!isset($clients[$phone])) {
            $clients[$phone] = [
                'id' => $phone,
                'name' => $row->first_name . ' ' . $row->last_name,
                'email' => $row->email,
                'phone' => $row->phone,
                'bookings_count' => 1,
                'is_active' => 1
            ];
        } else {
            $clients[$phone]['bookings_count']++;
        }
    }

    // 3️⃣ CAR BOOKINGS
    $cars = DB::table('car_bookings')
        ->select('name', 'email', 'phone')
        ->get();

    foreach ($cars as $row) {
        $phone = preg_replace('/\D/', '', $row->phone);

        if (!isset($clients[$phone])) {
            $clients[$phone] = [
                'id' => $phone,
                'name' => $row->name,
                'email' => $row->email,
                'phone' => $row->phone,
                'bookings_count' => 1,
                'is_active' => 1
            ];
        } else {
            $clients[$phone]['bookings_count']++;
        }
    }

    // 4️⃣ TOUR BOOKINGS
    $tours = DB::table('tour_bookings')
        ->select('first_name', 'last_name', 'email', 'phone')
        ->get();

    foreach ($tours as $row) {
        $phone = preg_replace('/\D/', '', $row->phone);

        if (!isset($clients[$phone])) {
            $clients[$phone] = [
                'id' => $phone,
                'name' => $row->first_name . ' ' . $row->last_name,
                'email' => $row->email,
                'phone' => $row->phone,
                'bookings_count' => 1,
                'is_active' => 1
            ];
        } else {
            $clients[$phone]['bookings_count']++;
        }
    }

    // 5️⃣ VISA REQUESTS
    $visas = DB::table('visa_requests')
        ->select('first_name', 'last_name', 'email', 'phone')
        ->get();

    foreach ($visas as $row) {
        $phone = preg_replace('/\D/', '', $row->phone);

        if (!isset($clients[$phone])) {
            $clients[$phone] = [
                'id' => $phone,
                'name' => $row->first_name . ' ' . $row->last_name,
                'email' => $row->email,
                'phone' => $row->phone,
                'bookings_count' => 1,
                'is_active' => 1
            ];
        } else {
            $clients[$phone]['bookings_count']++;
        }
    }

    

// ✅ ADD MANUAL CLIENTS BEFORE RETURN
$manualClients = Client::all();

foreach ($manualClients as $client) {
    $phone = preg_replace('/\D/', '', $client->phone);

    // Only add if not already in bookings
    if (!isset($clients[$phone])) {
        $clients[$phone] = [
            'id' => $phone,
            'name' => $client->name,
            'email' => $client->email,
            'phone' => $client->phone,
            'bookings_count' => 0,
            'is_active' => 0
        ];
    }
}

// ✅ SINGLE RETURN ONLY
return view('admin.clients.index', [
    'clients' => collect($clients)->map(function($client) {
        return (object) $client;
    })->values()
]);
    
}
// 2. Show single client profile


public function showClient($phone)
{
    // 1️⃣ Normalize phone number
    $phone = preg_replace('/\D/', '', $phone);

    $clients = [];

    // ✅ DEFINE TABLES (you forgot this)
    $tables = ['flight_bookings','hotel_bookings','car_bookings','tour_bookings','visa_requests'];

    // =========================
    // 2️⃣ FETCH BOOKINGS (UNCHANGED)
    // =========================
    foreach ($tables as $table) {
        $data = DB::table($table)
            ->whereRaw("REPLACE(phone, '-', '') = ?", [$phone])
            ->get();

        if ($data->isNotEmpty()) {
            $clients[$table] = $data;
        }
    }

    // =========================
    // 3️⃣ GET MANUAL CLIENT (NEW)
    // =========================
    $manualClient = Client::where('phone', $phone)->first();

    // =========================
    // 4️⃣ EXTRACT NAME & EMAIL
    // =========================
    $name = null;
    $email = null;

    foreach ($tables as $type) {
        if (isset($clients[$type]) && count($clients[$type]) > 0) {
            $first = (array) $clients[$type][0];

            if (!empty($first['name'])) {
                $name = $first['name'];
            } else {
                $firstName = $first['first_name'] ?? '';
                $lastName  = $first['last_name'] ?? '';
                $name = trim($firstName . ' ' . $lastName);
            }

            $email = $first['email'] ?? null;

            if ($name || $email) break;
        }
    }

    // =========================
    // ✅ OVERRIDE WITH MANUAL CLIENT (IMPORTANT)
    // =========================
    if ($manualClient) {
        $name = $manualClient->name ?? $name;
        $email = $manualClient->email ?? $email;
    }

    // =========================
    // 5️⃣ ALLOW CLIENT WITH NO BOOKINGS
    // =========================
    if (empty($clients) && !$manualClient) {
        abort(404, "Client with phone {$phone} not found");
    }

    // =========================
    // 6️⃣ SUMMARY (FIXED)
    // =========================
    $clients['summary'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    ];

    // =========================
    // 7️⃣ COLLECT ALL BOOKINGS
    // =========================
    $allBookings = [];

    foreach ($tables as $table) {
        foreach ($clients[$table] ?? [] as $booking) {
            $b = (array) $booking;

            $date = $b['created_at'] ?? $b['booking_date'] ?? null;

            if ($date) {
                $allBookings[] = [
                    'type' => ucfirst(str_replace('_', ' ', $table)),
                    'date' => $date,
                    'data' => $b
                ];
            }
        }
    }

    // =========================
    // 8️⃣ SORT BOOKINGS
    // =========================
    usort($allBookings, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // =========================
    // 9️⃣ ACTIVITY
    // =========================
    $clients['recent_activity'] = array_slice($allBookings, 0, 5);
    $clients['last_booking_date'] = $allBookings[0]['date'] ?? null;

    // =========================
    // 🔟 FINAL RETURN
    // =========================
    return view('admin.clients.show', [
        'phone' => $phone,
        'clients' => $clients
    ]);
}
// 3. Create client form
public function createClient()
{
    return view('admin.clients.create');
}

// 4. Store new client
public function storeClient(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:clients,email',
        'phone' => 'required',
    ]);

    Client::create($request->all());
    Alert::success('Success', "Client added  successfully!");
    return redirect()->route('admin.clients');    
}

// 5. Edit client form
public function editClient($phone)
{
    $clients = [];

    $tables = ['flight_bookings','hotel_bookings','car_bookings','tour_bookings','visa_requests'];

    foreach ($tables as $table) {
        $clients[$table] = \DB::table($table)
            ->whereRaw("REPLACE(phone, '-', '') = ?", [$phone])
            ->get();
    }

    // Extract name & email (same logic as show page)
    $name = null;
    $email = null;

    foreach ($tables as $type) {
        if (count($clients[$type]) > 0) {
            $first = (array) $clients[$type][0];

            if (!empty($first['name'])) {
                $name = $first['name'];
            } else {
                $name = trim(($first['first_name'] ?? '') . ' ' . ($first['last_name'] ?? ''));
            }

            $email = $first['email'] ?? null;

            if ($name || $email) break;
        }
    }

    $clients['summary'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    ];

    return view('admin.clients.edit', compact('clients'));
}

// 6. Update client
public function updateClient(Request $request, $phone)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required'
    ]);

    // Split full name
    $nameParts = explode(' ', $request->name, 2);

    $firstName = $nameParts[0];
    $lastName = $nameParts[1] ?? '';

    $tables = ['flight_bookings','hotel_bookings','car_bookings','tour_bookings','visa_requests'];

    foreach ($tables as $table) {

        $data = [
            'email' => $request->email,
            'phone' => $request->phone
        ];

        // Only update name fields if they exist
        if (\Schema::hasColumn($table, 'first_name')) {
            $data['first_name'] = $firstName;
        }

        if (\Schema::hasColumn($table, 'last_name')) {
            $data['last_name'] = $lastName;
        }

        if (\Schema::hasColumn($table, 'name')) {
            $data['name'] = $request->name;
        }

        \DB::table($table)
            ->where('phone', $phone)
            ->update($data);
    }

    Alert::success('Success', "Client updated successfully!");
    return redirect()->route('admin.clients');    
}

// 7. Delete client
public function deleteClient($phone)
{
    // Normalize phone
    $phone = preg_replace('/\D/', '', $phone);

    // Tables where client info exists
    $tables = ['flight_bookings','hotel_bookings','car_bookings','tour_bookings','visa_requests'];

    // Delete bookings from all tables
    foreach ($tables as $table) {
        DB::table($table)->whereRaw("REPLACE(phone, '-', '') = ?", [$phone])->delete();
    }

    Alert::success('Success', "Client and all associated bookings deleted successfully!");
    return redirect()->route('admin.clients');
}



public function settings()
{
    $admin = auth()->user();

    $settings = Setting::pluck('value','key')->toArray(); // fetch site_name, support_email

    return view('admin.settings', compact('admin','settings'));
}



public function updateSettings(Request $request)
{
    // Get the logged-in admin
    $admin = auth()->user();

    // Validate form input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
        'password' => 'nullable|string|min:6|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'support_email' => 'required|email|max:255',
        'site_name' => 'required|string|max:255',
    ]);

    // Update name and email
    $admin->name = $request->name;
    $admin->email = $request->email;

    // Update password only if provided
    if ($request->filled('password')) {
        $admin->password = bcrypt($request->password);
    }

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/admins'), $filename);
        $admin->profile_picture = $filename;
    }

    // Save the admin
    $admin->save();

    // Update site settings (if you store them separately in a settings table)
    if ($request->filled('support_email') || $request->filled('site_name')) {
        \App\Models\Setting::updateOrCreate(
            ['key' => 'support_email'],
            ['value' => $request->support_email]
        );
        \App\Models\Setting::updateOrCreate(
            ['key' => 'site_name'],
            ['value' => $request->site_name]
        );
    }

    // SweetAlert success notification
    Alert::success('Success', 'Settings updated successfully!');

    return redirect()->back();
}


}