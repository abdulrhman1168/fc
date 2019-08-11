<?php

namespace Modules\DepartmentServices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserBaseController;
use Modules\MyServices\Entities\AirportTransfer\AirportTransferOrders;
use Modules\MyServices\Entities\AirportTransfer\AirportTransferWorkflow;
use Modules\BookingExams\Entities\City;
use Modules\BookingExams\Entities\SchoolYears;
use Validator;

class AirportTransferController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $airportTransferOrders = AirportTransferOrders::ordersForDepartmentService();

        return view('departmentservices::airport-transfer.index', compact('airportTransferOrders'));
    }

    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return response()->json('Success', 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request, $orderID)
    {
        $airportTransferOrder = AirportTransferOrders::findByOrderID($orderID);

        if($airportTransferOrder == NULL) {
            return redirect()->route('department-services.airport-transfer.index');
        }

        $goingTripPersons = $airportTransferOrder->persons->filter(function($person) {
            return $person->order_type == 1;
        });

        $comingTripPersons = $airportTransferOrder->persons->filter(function($person) {
            return $person->order_type == 2;
        });

        $orderActions = AirportTransferOrders::getOrderActions($airportTransferOrder->order_status);

        return view('departmentservices::airport-transfer.show', compact('airportTransferOrder', 'goingTripPersons', 'comingTripPersons', 'orderActions'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('departmentservices::airport-transfer.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $orderID)
    {
        $airportTransferOrder = AirportTransferOrders::findByOrderID($orderID);

        if($airportTransferOrder == NULL) {
            return redirect()->route('department-services.airport-transfer.index');
        }

        $validatedData = Validator::make($request->all(), [
            'actions'  => 'required|integer|in:'. AirportTransferOrders::getOrderActionsKyes($airportTransferOrder->order_status),
            'note'     => 'required_if:actions,3|required_if:actions,5|max:255',
        ]);

        if ($this->isApiCall) {
            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }
        } else {
            $validatedData->validate();
        }

        $airportTransferOrder->order_status = $request->actions;
        $airportTransferOrder->save();

        $airportTransferOrder->workflows()->create([
            'employee_id' => auth()->user()->employeeObject->employee_id,
            'action_reason' => $request->note,
            'status' => $request->actions
        ]);

        return redirect()->route('department-services.airport-transfer.index')->with('success', 'تم الحفظ');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    /**
     * Show the passport for the user
     * @return Response
     */
    public function showPassport(Request $request, $orderID)
    {
        $airportTransferOrder = AirportTransferOrders::findByOrderID($orderID);

        if($airportTransferOrder == NULL) {
            return redirect()->route('department-services.airport-transfer.index');
        }

        if(!\Storage::exists('uploads/airport-transfer/' . $request->passportSlug)) {
            return redirect()->route('department-services.airport-transfer.index');
        }

        $storagePath = storage_path('app/uploads/airport-transfer/' . $request->passportSlug);
        return \Image::make($storagePath)->response();
    }
    
}
