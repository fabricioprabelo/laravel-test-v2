<?php

namespace App\Http\Controllers;

use App\Enums\PermissionEnum;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Models\Hotel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize(Hotel::class, PermissionEnum::HOTEL_READ->value);

        $user = $request->user();
        $team = $user?->currentTeam;
        $can = [
            'create' => $user->hasTeamPermission(
                $team,
                PermissionEnum::HOTEL_CREATE->value
            ),
            'update' => $user->hasTeamPermission(
                $team,
                PermissionEnum::HOTEL_UPDATE->value
            ),
            'delete' => $user->hasTeamPermission(
                $team,
                PermissionEnum::HOTEL_DELETE->value
            ),
        ];

        $hotels = Hotel::with(['rooms'])->paginate();

        return Inertia::render('Hotels/Show', compact('hotels', 'can'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeResource(Hotel::class, PermissionEnum::HOTEL_CREATE->value);
        return view('hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        $this->authorizeResource(Hotel::class, PermissionEnum::HOTEL_CREATE->value);

        try {
            DB::beginTransaction();

            $hotel = Hotel::create($request->only([
                'name',
                'address',
                'complement',
                'neighborhood',
                'city',
                'state',
                'zip_code',
                'website'
            ]));

            if ($request->only('rooms')) {
                $rooms = $request->only('rooms')['rooms'];
                foreach($rooms as $room) {
                    $hotel->rooms()->create([
                        'name' => $room['name'],
                        'description' => $room['description'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('hotels.edit', $hotel);

        } catch (Exception $e) {

            DB::rollBack();

            return back()
                ->withInput($request->all())
                ->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        $this->authorizeResource($hotel, PermissionEnum::HOTEL_READ->value);

        $hotel->with(['rooms']);

        return view('hotels.edit', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        $this->authorizeResource($hotel, PermissionEnum::HOTEL_UPDATE->value);

        $hotel->with(['rooms']);

        return view('hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        $this->authorizeResource($hotel, PermissionEnum::HOTEL_UPDATE->value);

        try {
            DB::beginTransaction();

            $hotel->update($request->only([
                    'name',
                    'address',
                    'complement',
                    'neighborhood',
                    'city',
                    'state',
                    'zip_code',
                    'website',
                ]));

            if ($request->only('rooms')) {
                $rooms = $request->only('rooms')['rooms'];
                foreach($rooms as $room) {
                    $hotel->rooms()->create([
                        'name' => $room['name'],
                        'description' => $room['description'],
                    ]);
                }
            }

            DB::commit();

            return back();

        } catch (Exception $e) {

            DB::rollBack();

            return back()
                ->withInput($request->all())
                ->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $this->authorize($hotel, PermissionEnum::HOTEL_DELETE->value);

        $hotel->delete();

        $hotels = Hotel::with(['rooms'])->paginate();

        return response()->json($hotels);
    }
}
