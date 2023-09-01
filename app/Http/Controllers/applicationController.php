<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\suppliers;
use App\Models\items;
use App\Models\categories;
use App\Models\department;

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
            $supplier->email = $request->input('email');
            $supplier->address = $request->input('address');
            $supplier->save();
    
            return response()->json(['message'=>'SUPPLIER SAVED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Try again!It seems supplier with same phone number already registered !!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    
    
    }
    public function getSuppliers(){
        $suppliers=suppliers::all();
        return response()->json(['data'=>$suppliers]);

    }

    public function addItem(Request $request)
    {
        
        //return redirect()->route('suppliers.create')->with('success', 'Supplier added successfully.');
    
        try {

            $request->validate([
                'name' => 'required|string|max:30',
                'item_no' => 'required|max:30',
                'quantity' => 'required|max:20',
               // 'price' => 'required',
               // 'description' => 'required|numeric|digits:10',
               // 'email' => 'required|string|max:255', 
            ]); 
    
            $supplier = new items();
            $supplier->name = $request->input('name');
            $supplier->item_no = $request->input('item_no');
            $supplier->quantity = $request->input('quantity');
            $supplier->price = $request->input('price');
            $supplier->description = $request->input('description');
            $supplier->category_id = $request->input('categoryId');
            $supplier->supplier_id = $request->input('supplierId');
            $supplier->save();
    
            return response()->json(['message'=>'ITEM SAVED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Try again!It seems item same item type is already enterd in the system !!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    

    }


    public function getItems(){
        //to item table with categories and suppliersb based on foreign key and primary key
        $items=items::with('categories','suppliers')->get();
        //$items=items::all();
        //$user = categories::find(1); 
        
        return response()->json(['data'=>$items]);

    }

    public function updateItems(Request $request, $id)
    {
        
        try {

            $request->validate([
                'name' => 'required|string|max:30',
                'item_no' => 'required|max:30',
               
                'quantity' => 'required|max:20',
               // 'price' => 'required',
               // 'description' => 'required|numeric|digits:10',
               // 'email' => 'required|string|max:255',
              
            ]); 
            $item=items::find($id);
            // $item = new items();
             $item->name = $request->input('name');
             $item->item_no = $request->input('item_no');
             $item->quantity = $request->input('quantity');
             $item->price = $request->input('price');
             $item->description = $request->input('description');
             $item->category_id = $request->input('categoryId');
             $item->save();
            
            return response()->json(['message'=>'ITEM UPDATED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
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
        
        try {

           
            //$item=items::find($id);
            //$category = categories::findOrFail($id);
             $category = categories::find($id);
             //to delete categories with its related items
           

            if ($category->items()->exists() ) {
                // The category has related items
                return response()->json(['message' => 'Warning! This Category has related items and cannot be deleted.'], 422);

            }else{
             $category->delete();
            
            return response()->json(['message'=>'CATEGORY DELETED SUCCESSFULLY'],200);}
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Contact sytem admin !!'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        
    }


    public function deleteItems($id)
    {
        
        try {

           
             $item = items::find($id);
             //to delete categories with its related items
            
             $item->delete();
            
            return response()->json(['message'=>'ITEM DELETED SUCCESSFULLY'],200);
            
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

        $departments=department::all();

        return response()->json(['data'=>$departments],200);
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
            
             $dept->delete();
            
            return response()->json(['message'=>'DEPT DELETED SUCCESSFULLY'],200);
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database Error:Contact sytem admin!!'], 500);
        } 
        
    }


    


}
