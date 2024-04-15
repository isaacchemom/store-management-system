<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\suppliers;
use App\Models\items;
use App\Models\categories;
use App\Models\department;
use App\Models\staff;
use Carbon\Carbon;
use App\Models\issue_item;
use App\Models\itemUnit;

class applicationController extends Controller
{
   
    public function addsupplier(Request $request)
    {
         
        try {

            $request->validate([
                'name' => 'required|string|max:30',
                'contact' => 'required|numeric|digits:10',
               // 'email' => 'required|string|max:255',
                'address' => 'required|string|max:50',
            ]); 
    
            $supplier = new suppliers();
            $supplier->name = $request->input('name');
            $supplier->contact = $request->input('contact');
            $supplier->company = $request->input('company');
            $supplier->item = $request->input('item');
            $supplier->address = $request->input('address');
            $supplier->save();
    
            return response()->json(['message'=>'SUPPLIER SAVED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Try again!It seems supplier with same phone number already registered !!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    
    
    }

    public function editSupplier(Request $request ,$id)
    {
         
        try {

            $request->validate([
                'name' => 'required|string|max:30',
                'contact' => 'required|numeric|digits:10',
               // 'email' => 'required|string|max:255',
                'address' => 'required|string|max:50',
            ]); 
    
            $supplier =suppliers::find($id);
            $supplier->name = $request->input('name');
            $supplier->contact = $request->input('contact');
            $supplier->company = $request->input('company');
            $supplier->item = $request->input('item');
            $supplier->address = $request->input('address');
          
            $supplier->save();
    
            return response()->json(['message'=>'SUPPLIER udated SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Try again!It seems supplier with same phone number already registered !!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    
    
    }
public function deleteSupplier($id){
 $supplier=suppliers::find($id);

 //to delete categories with its related items
 $relatedItemsCount = $supplier->items->count();

 // if ($category->items()->exists() ) {
      if ($relatedItemsCount>0 ) {
      // The category has related items
      return response()->json(['message' => 'Warning! Supplier has related items and cannot be deleted.'], 422);

  }else{
    $supplier->delete();
  
  return response()->json(['message'=>' DELETED SUCCESSFULLY'],200);}


  }

    

public function addStaff (Request  $request){

    try {
        $request->validate([
          'name'=>'required',
          'contact'=>'required|numeric|digits:10',
          'category'=>'required',
          
        ]);

        $staff = new staff();

        $staff->name=$request->input('name');
        $staff->contact= $request->input('contact');
        $staff->category=$request->input('category');
        $staff->designation=$request->input('designation');
         
        $staff->save();
         return response()->json(['message'=>'STAFF ADDED SUCCESSFULLY']);

    } catch(QueryException $e){
        return response()->json(['error' => 'Database Error:user with same phone number already entered check and try again!!'], 500);
    } catch(\Exception $e) {
      return response()->json(['error'=>'An error occured:'.$e->getMessage()],500);

    }
}


public function editStaff (Request  $request, $id){

    try {
        $request->validate([
          'name'=>'required',
          'contact'=>'required|numeric',
          'category'=>'required',
          
        ]);

        $staff =staff::find($id);

        $staff->name=$request->input('name');
        $staff->contact= $request->input('contact');
        $staff->category=$request->input('category');
        $staff->designation=$request->input('designation');
         
        $staff->save();
         return response()->json(['message'=>'STAFF ADDED SUCCESSFULLY']);

    } catch(QueryException $e){
        return response()->json(['error' => 'Database Error:user with same phone number already entered check and try again!!'], 500);
    } catch(\Exception $e) {
      return response()->json(['error'=>'An error occured:'.$e->getMessage()],500);

    }
}


public function getStaff(){
    $staff=staff::all();
    return response()->json(['data'=>$staff]);
}

public function deleteStaff($id){
 $staff=staff::find($id);



//to delete categories with its related items
 $relatedItemsCount = $staff->issue_item->count();

 // if ($category->items()->exists() ) {
      if ($relatedItemsCount>0 ) {
      // The category has related items
      return response()->json(['message' => 'Warning! This record cannot be deleted here, it has related items.'], 422);

  }else{
    $staff->delete();
  
  return response()->json(['message'=>' DELETED SUCCESSFULLY'],200);}

}



    public function getSuppliers(){
      

     
        $mysuppliers = suppliers::paginate(2);
        $suppliers=suppliers::all();

        
        $data = [
           
            'mydata' => $mysuppliers,
             'data' => $suppliers,
        ];
        


        return response()->json($data, 200);
      

    }

    public function addItem(Request $request)
    {
        
        //return redirect()->route('suppliers.create')->with('success', 'Supplier added successfully.');
    
        try {

            $request->validate([
                'name' => 'required|string|max:50',
                'item_no' => 'required|max:255',
                'quantity' => 'required|max:255',
               // 'price' => 'required',
               // 'description' => 'required|numeric|digits:10',
               // 'email' => 'required|string|max:255', 
            ]); 
    
            $supplier = new items();
            $supplier->name = $request->input('name');
            $supplier->item_no = $request->input('item_no');
            $supplier->quantity = $request->input('quantity');
            $supplier->remain_quantity = $request->input('quantity');
            $supplier->price = $request->input('price');
            $supplier->description = $request->input('description');
            $supplier->category_id = $request->input('categoryId');
            $supplier->supplier_id = $request->input('supplierId');
            $supplier->unit_id = $request->input('unitId');
            $supplier->department_id = $request->input('departmentId');
            $supplier->save();
    
            return response()->json(['message'=>'ITEM SAVED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error: Item code already entered check and try again!!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    

    }


    public function getItems(Request $request){
        //to item table with categories and suppliersb based on foreign key and primary key
        if($request->mydepartment){
        $items = items::with('categories','suppliers','department','itemUnit')
                      -> where('department_id',$request->mydepartment)
                      ->latest()
                      ->get();
        
        return response()->json(['data'=>$items]);}
        else
        {

            $items=items::with('categories','suppliers','department','itemUnit')
            ->latest()
            ->get();
            return response()->json(['data'=>$items]);

        }

    }

    public function updateItems(Request $request, $id)
    {
        
        try {

            $request->validate([
                'name' => 'required|string|max:30',
                'item_no' => 'required|max:30',
               
                'quantity' => 'required|max:20',
                'categoryId' => 'required|max:20',
                'supplierId' => 'required|max:20',
                'departmentId' => 'required|max:20',
                'unitId' => 'required|max:20',
               // 'price' => 'required',
               // 'description' => 'required|numeric|digits:10',
               // 'email' => 'required|string|max:255',
              
            ]); 
            $item=items::find($id);
            // $item = new items();
             $item->name = $request->input('name');
             $item->item_no = $request->input('item_no');
             $item->quantity = $request->input('quantity');
             $item->remain_quantity = $request->input('orquantity');
             $item->price = $request->input('price');
             $item->description = $request->input('description');
             $item->category_id = $request->input('categoryId');
             $item->supplier_id = $request->input('supplierId');
             $item->unit_id = $request->input('unitId');
            $item->department_id = $request->input('departmentId');

             $item->save();
            
            return response()->json(['message'=>'ITEM UPDATED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {

           // \Log::info($e);
            return response()->json(['error' => 'Database Error:Try again!It seems item same item type is already enterd in the system !!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        

    }


     public function addCategory(Request $request)
    {
        
        try {

            $request->validate([
                'name' => 'required|string|max:30',
               // 'item_no' => 'required|max:30',
              
            ]); 
            //$item=items::find($id);
             $category = new categories();
             $category->name = $request->input('name');
             $category->description = $request->input('description');
             $category->save();
            
            return response()->json(['message'=>'CATEGORY UPDATED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Try again!It seems item same item type is already enterd in the system !!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        
    }
 public function addUnits(Request $request){

   $request->validate([
   'name'=>'required|string',

   ]);

$unit=new itemUnit();
$unit->name=$request->input('name');
$unit->save();
return response()->json(['message'=>'unit added successfully'],200);

 }

 public function updateUnits(Request $request, $id){

    $request->validate([
    'name'=>'required|string',
 
    ]);
 
 //$unit=new itemUnit();
 $unit=itemUnit::find($id);
 $unit->name=$request->input('name');
 $unit->save();
 return response()->json(['message'=>'unit updated successfully'],200);
 
  }


public function getUnits(){

    $units=itemUnit::all();
    return response()->json(['data'=>$units]);
}

public function deleteUnits($id){

    $unit=itemUnit::find($id);

    $relatedItemsCount = $unit->items->count();

    // if ($category->items()->exists() ) {
         if ($relatedItemsCount>0 ) {
         // The category has related items
         return response()->json(['message' => 'Warning! This unit item has related items and cannot be deleted.'], 422);

     }else{
     
      $unit->delete();
     
     return response()->json(['message'=>'DELETED SUCCESSFULLY'],200);}
     

 
   

}


    public function getCategories(){
        $categories=categories::all();
        return response()->json(['data'=>$categories]);
    }



    public function updateCategory(Request $request, $id)
    {
        
        try {

            $request->validate([
                'name' => 'required|string|max:30',
               // 'item_no' => 'required|max:30',
               
              
            ]); 
            //$item=items::find($id);
             $category = categories::find($id);
             $category->name = $request->input('name');
             $category->description = $request->input('description');
             $category->save();
            
            return response()->json(['message'=>'CATEGORY UPDATED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Try again!It seems item same item type is already enterd in the system !!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        
    }


    public function deleteCategory($id)
    {
        
       // try {

           
            //$item=items::find($id);
            //$category = categories::findOrFail($id);
             $category = categories::find($id);
             //to delete categories with its related items
             
             $relatedItemsCount = $category->items->count();

           // if ($category->items()->exists() ) {
                if ($relatedItemsCount>0 ) {
                // The category has related items
                return response()->json(['message' => 'Warning! This Category has related items and cannot be deleted.'], 422);

            }else{
             $category->delete();
            
            return response()->json(['message'=>'CATEGORY DELETED SUCCESSFULLY'],200);}
            
      //  } catch (QueryException $e) {
          //  return response()->json(['error' => 'Database Error:Contact sytem admin !!'], 500);
      //  } catch (\Exception $e) {
          //  return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
      //  }
        
    }


    public function deleteItems($id)
    {
        
        try {

           
             $item = items::find($id);
             //to delete categories with its related items

           //  $itemIssued=issue_item::with('items.categories','staff')
            // $relatedItemsCount = $item->issue_item>count();

  if ($item->issue_item()->exists() ) {
   // if ($item->relatedItems()->exists()) {

     // if ($relatedItemsCount>0 ) {
      // The category has related items
      return response()->json(['message' => 'Warning! You are not allowed  to delete this item it is related to other items!.'], 422);

  }else{
    $item->delete();
  
  return response()->json(['message'=>' DELETED SUCCESSFULLY'],200);}
            
              
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Contact sytem admin!!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        
    }


    public function addDepartment(Request $request)
    {
        
        try {

            $request->validate([
                'name' => 'required|string|max:30',
              
         
            ]); 
            //$item=items::find($id);
             $department = new department();
             $department->name = $request->input('name');
             $department->description = $request->input('description');
             $department->save();
            
            return response()->json(['message'=>'DEPARTMENT ADDED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Contact adminstrator!!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
     

    }


    public function getDepartments(){

       $alldepartments=department::all();
        $departments=department::Paginate(10);

        
        $data = [
            'data' => $departments,
            'mydata' => $alldepartments,
        ];
        
        // Return the combined array as the JSON response
        return response()->json($data, 200);
    }


    public function updateDepartment(Request $request,$id)
    {
        
        try {

            $request->validate([
                'name' => 'required|string|max:30',
              
         
            ]); 
            $department=department::find($id);
             //$department = new department();
             $department->name = $request->input('name');
             $department->description = $request->input('description');
             $department->save();
            
            return response()->json(['message'=>'DEPARTMENT UPDATED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Contact adminstrator for help!!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
     

    }

    public function deleteDepartment($id)
    {
        
        try {

           
             $dept = department::find($id);
             //to delete categories with its related items
             $relatedItemsCount = $dept->items->count();

             // if ($category->items()->exists() ) {
                  if ($relatedItemsCount>0 ) {
                  // The category has related items
                  return response()->json(['message' => 'Warning! This record cannot be deleted here, it has related items.'], 422);
  
              }else{
             
               $dept->delete();
              
              return response()->json(['message'=>'dept DELETED SUCCESSFULLY'],200);
            }

              
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Contact sytem admin!!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        
    }


    
public function issuedItem(Request $request){
   // $itemIssued=issue_item::all();

   if($request->input('mydepartment')){
   $itemIssued = issue_item::with('items.categories', 'staff', 'items.itemUnit', 'items.department')
   ->whereHas('items.department', function ($query) use ($request) {
       $query->where('name', $request->input('mydepartment'));
   })
   ->latest()
   ->get();

return response()->json(['data' => $itemIssued]);
   } 
   else
   
   {


   $itemIssued=issue_item::with('items.categories','staff','items.itemUnit','items.department')->latest()->get();
   return response()->json(['data'=>$itemIssued]);
   }
}
  

public function issueItems(Request $request)
{
    

    try {

        $request->validate([
           'quantity' => 'required|numeric|gt:0',
           'staffID' => 'required|numeric',
           'itemID' => 'required|numeric',
          
          
        ]); 
     //  dd( $request->input('staffID'));

        //$item=items::find($id);
         $issues = new issue_item();
         $issues->item_id = $request->input('itemID');
         $issues->staff_id = $request->input('staffID');
         $issues->quantity=$request->input('quantity');

         $quantityId=items::where('id',$request->input('itemID'))->first();
       
          //$myquantity=$quantityId->quantity;
          // dd($myquantity);
        $quantityId->quantity -= $request->input('quantity');
        // if($request->input('quantity')>$myquantity){
          //  return response()->json(['message'=>'Please you cant issue item more than remaining stock'],200);
       //  }
        
         $quantityId->save();

         $issues->save();
        

        return response()->json(['message'=>'issued item  SUCCESSFULLY'],200);
        
    } catch (QueryException $e) {

      //  \Log::info($e);
        return response()->json(['error' => 'Database Error try again:Contact adminstrator!!'], 500);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
 

}  

public function updateIssuedItems(Request $request, $id)
{
    

    try {

        $request->validate([
           
           'staffID' => 'required|numeric',
          
           'itemID' => 'required|numeric',
           'quantity' => 'required|numeric|gt:0',
          
          
        ]); 
      ///dd( $request->input('quantity'));

        //$item=items::find($id);
         $issues = issue_item::find($id);
         $issues->item_id = $request->input('itemID');
         $issues->staff_id = $request->input('staffID');
         $issues->quantity=$request->input('quantity');

     
        
         $quantityitem = issue_item::where('item_id', $request->input('itemID'))
                           ->where('staff_id', $request->input('staffID'))
                           ->where('created_at', $request->input('itemTime'))
                           ->first();

                           $myquantityitem=$quantityitem->quantity;
         
         $quantityId=items::where('id',$request->input('itemID'))->first(); 
       
        // $myquantity=$quantityId->quantity;
        /// dd($myquantity);
//dd($request->input('itemTime'));
      

         if($request->input('quantity')<$myquantityitem){
          //  $quantityId=items::where('id',$request->input('itemID'))->first();
             $result=$myquantityitem-$request->input('quantity');
            //dd($result);
             $quantityId->quantity+=$result ;
           //dd($quantityId->quantity);
             $quantityId->save();
            
         } 
         else
         
         {
            $myresult=$request->input('quantity')-$myquantityitem;
          // dd($myresult);
            $quantityId->quantity -=$myresult;
        
           $quantityId->save();
         
         }

         $issues->save();
        
        return response()->json(['message'=>'Updated SUCCESSFULLY'],200);
        
    } catch (QueryException $e) {

      //  \Log::info($e);
        return response()->json(['error' => 'Error:You have entered quantity  which is more than available stock check and try again!!!'], 500);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }

    
 

}  



public function deleteIssueItem($id){

    $issue=issue_item::find($id);

   $issueQuantity= $issue->quantity;
    $issueItemId= $issue->item_id;

   $quantityId=items::where('id',$issueItemId)->first();
   $quantityId->quantity=$issueQuantity+$quantityId->quantity;

    $quantityId->save();
    $issue->delete();

    return response()->json(['message'=>'deleted succefully'],200)  ;


}


public function getDailyItems(Request $request){
    //  $sales=sales::all();

    $today=Carbon::today();
    

      if($request->input('mydepartment')){
         $DailyItems = issue_item::with('items.categories', 'staff', 'items.itemUnit', 'items.department')
         ->whereDate('created_at', $today)
        ->whereHas('items.department', function ($query) use ($request) {
            $query->where('name', $request->input('mydepartment'));
        })
        ->latest()
        ->get();
     
     return response()->json(['data' =>$DailyItems]);
        } 
        else
        
        {
     
            $DailyItems=issue_item::with('items.categories','staff','items.itemUnit','items.department')
            ->whereDate('created_at', $today)
            ->get();


return response()->json(['data'=>$DailyItems]);
        }



  }


}
