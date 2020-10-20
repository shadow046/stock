<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Loan;
use Auth;
use App\Item;
use App\Stock;
class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.loan');

    }

    public function tablerequest(Request $request)
    {
        $myloans = Loan::select('loans.id', 'branches.branch', 'branches.id as branchid', 'loans.updated_at', 'items.item', 'loans.status', 'loans.updated_at')
            ->where('loans.from_branch_id', Auth::user()->branch->id)
            ->where('loans.status', '!=', 'completed')
            ->join('branches', 'loans.to_branch_id', '=', 'branches.id')
            ->join('items', 'loans.items_id', '=', 'items.id')
            ->get();

        return Datatables::of($myloans)

        ->addColumn('date', function (Loan $request){

            return $request->updated_at->toFormattedDateString().' '.$request->updated_at->toTimeString();
        })

        ->make(true);
    }

    public function getItemCode(Request $request){
        

        $cat = Item::select('category_id')
            ->where('items.id', $request->id)
            ->first();
        
        $items = Item::select('item', 'id')
            ->where('category_id', $cat->category_id)
            ->get();
        
        return response()->json($items);
        
    }

    public function table(Request $request)
    {

        $loans = Loan::select('loans.id', 'branches.id as branchid', 'branches.branch', 'loans.updated_at', 'items.item', 'loans.status', 'loans.updated_at')
            ->where('loans.to_branch_id', Auth::user()->branch->id)
            ->where('loans.status', '!=', 'completed')
            ->join('branches', 'loans.from_branch_id', '=', 'branches.id')
            ->join('items', 'loans.items_id', '=', 'items.id')
            ->get();
        

        return Datatables::of($loans)

        ->addColumn('date', function (Loan $request){

            return $request->updated_at->toFormattedDateString().' '.$request->updated_at->toTimeString();
        })

        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stock(Request $request)
    {

        $item = Item::where('id', $request->item)->first();
        $stock = Stock::where('id', $request->item)->first();


        $update = Stock::where('id', $request->item)->where('branch_id', Auth::user()->branch->id)->first();
        $update->status = 'loan';
        $update->id_branch = $request->branch;
        $update->user_id = Auth::user()->id;
        $update->save();

        $add = new Stock;
        $add->category_id = $item->category_id;
        $add->branch_id = $request->branch;
        $add->items_id = $request->item;
        $add->user_id = Auth::user()->id;
        $add->serial = $stock->serial;
        $add->status = 'pending';
        $add->id_branch = Auth::user()->branch->id;
        $data = $add->save();

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $loan = Loan::where('id', $request->id)->first();
        $loan->status = 'approved';
        $loan->user_id = Auth::user()->id;
        $data = $loan->save();

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
