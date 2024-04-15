<template>
<!-- DELETE ITEMS  MODAL -->

<div v-if="showAlert">
    <div v-if="message">
        <h5 class="alert alert-danger  container "> {{ message}} </h5>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETE ITEM?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="alert alert-warning">Are you sure you want to delete item?</h6>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" @click="removeItem">Delete</button>
            </div>
        </div>
    </div>
</div>
<!---end of delete modal-->
<div style="background-color:white;" class="mt-4 ml-4 mr-4">

    <div class="modal fade" id="taskmodal" tabindex="-1" role="dialogx" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centred modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="taskModalLabel">{{ !editMode ? 'Add Item.' : 'Update items' }}</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div v-if="showAlert">
                    <div v-if="importErrors">
                        <p class="alert alert-danger col-md-8"> {{ importErrors }} </p>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="row g-3 m-auto" ref="form" @submit.prevent="!editMode ? saveItem() : editItems()">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" v-model="item.name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Item code|Receipt Number</label>
                            <input type="text" class="form-control" v-model="item.item_no" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <v-select :options="mydepartments" label="name" v-model="item.departmentname" required></v-select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <v-select :options="mycategories" label="name" v-model="item.categoryname" required></v-select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Supplier</label>
                            <v-select :options="suppliers" label="name" v-model="item.suppliername" required></v-select>
                        </div>
  
                        <div class="col-md-6" v-if="editMode">
                            <label class="form-label">Original Stock</label>
                            <input type="text" class="form-control" v-model="item.orquantity" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Number Receceived</label>
                            <input type="text" class="form-control" v-model="item.quantity" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Units</label>
                            <v-select :options="myunits" label="name" v-model="item.unitname" required></v-select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Unit Price</label>
                            <input type="text" class="form-control" v-model="item.price" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Price</label>
                            <input type="text" class="form-control" v-model="item.totalAmount" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" v-model="item.description">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                {{ !editMode ? 'save Item' : 'Update Item' }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<!--
<div class="ml-4">
    <button class="btn btn-primary" @click="newItem">ADD NEW </button>

    <h4 class="text-center">LIST OF ITEMS</h4>
    <table class="table table-stripped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NAME</th>
                <th scope="col">ITEM NUMBER</th>
                <th scope="col">CATEGORY</th>
                <th scope="col">SUPPLIER NAME</th>
                <th scope="col">QUANTITY</th>
                <th scope="col">REM QUANTITY</th>
                <th scope="col">PRICE</th>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">Option</th>

            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in items" v-bind:key="index">
                <td scope="row">{{ index+1}}</td>
                <td scope="row">{{ item.name }}</td>
                <td>{{ item.item_no }}</td>
                <td>{{ item.categories.name}}</td>
                <td>{{ item.suppliers.name}}</td>
                <td>{{ item.quantity }}</td>
                <td>{{ item.remain_quantity }}</td>
                <td>{{ item.price }}</td>
                <td>{{ item.department.name }}</td>
                <td>  <input @onblur="update(task,$event.target.value)" >-
                  <a href="#" @click.prevent="updates(task)"><i class="fa fa-edit"></i></a>  </td>
                <td> <a href="#" @click.prevent="updateItem(item)"><i class="fa fa-edit"></i></a>
                    <a href="#" @click.prevent="deleteItem(item)"><i class="fa fa-trash text-danger  ml-4"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div> -->

<div class="text-right bg-success container-fluid" style="margin-top:-2%; margin-right:5%">
    <label for="1"> SELECT DEPARTMENT</label> <select name="stream" id="stream" v-model="mydepartment" @change="getDepartmentItems()" style="z-index: 1;position: relative;text-transform: uppercase;margin-right:78px">
        <option value selected>ALL DEPARTMENTS</option>
        <option v-for="item in mydepartments" :key="item.id" :value="item.id">
            {{item.name}}
        </option>
    </select> <button class="btn btn-primary" @click="newItem" style="font-size:12px;z-index: 1;position: relative"><i class="fa fa-plus">NEW ITEM</i> </button> </div>
<div class="text-center text-success"><b>LIST OF ITEMS IN THE STORE</b></div>
<div class="col-lg-12 offset-lg-2x " style="margin-top:-64px;">

    <div class="table caption-top table-responsive table-responsive-sm table-responsive-md table-responsive-xl  ">

        <DataTable style="text-transform:uppercase ;font-size:; " ref="myDataTable" class="cell-border  table-sm  display table table-striped table-hover  table-bordered " :columns="columns" :data="items" :options="{dom:'Bfrtip',responsive:'true',select: true,
    autoWidth:false,language:{zeroRecords:'No items in the table!'}, buttons:botones}">

            <thead style="">

                <tr class="table-success">
                    <th></th>
                    <th>Name</th>
                    <th>Receipt No.</th>
                    <th>Category</th>
                    <th>Orig Stock</th>
                    <th>Rem Stock</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                    <th>Description</th>
                    <th>Department</th>

                    <th>SUpplier</th>
                    <th>Created_at</th>
                    <th>Action</th>

                </tr>
            </thead>

        </DataTable>
    </div>
</div>
</template>

<script>
import DataTable from 'datatables.net-vue3'
import DataTablesCore from 'datatables.net';
import DataTableLip from 'datatables.net-bs5'
import Buttons from 'datatables.net-buttons-bs5'
import ButtonsHtml from 'datatables.net-buttons/js/buttons.html5'
//import 'datatables.net-buttons/js/buttons.html5.mjs';
import print from 'datatables.net-buttons/js/buttons.print'
import pdfmake from 'pdfmake'

//import pdfFonts from "pdfmake/build/vfs_fonts";

import 'datatables.net-responsive-bs5'

import jsZip from 'jszip'
window.JSZip = jsZip
window.pdfMake = pdfmake;

//pdfmake.vfs = pdfFonts.pdfMake.vfs;

DataTable.use(DataTablesCore);
DataTable.use(DataTableLip)
DataTable.use(print)
DataTable.use(Buttons)
DataTable.use(ButtonsHtml)
export default {
    // components: {
    components: {
        DataTable
    },

    data() {
        return {
            item: {
                name: '',
                item_no: '',
                orquantity:'',
                quantity: 0,
                price: 0,
                description: '',
                categoryname: '',
                suppliername: '',
                unitname: '',
                totalAmount: 0,
                departmentname: '',

            },

            showAlert: false,
            //  form: null,
            // edit: false,
            editMode: false,
            mydepartment: '',
            items: [],
            mycategories: [],
            suppliers: [],
            mydepartments: [],
            // mydepartments: [],
            myunits: [],

            columns: [{
                    data: null,
                    render: function (data, type, row, meta) {
                        return `${meta.row + 1}`;
                    },
                },
                {
                    // title: 'Staff name',
                    data: 'name'
                },
                {
                    // title: 'items',
                    data: 'item_no'
                },
                {
                    // title: 'Quantity',
                    data: 'categories.name'
                },
                {
                    // title: 'Quantity',
                    data: 'remain_quantity'
                },

                {
                    // title: 'Quantity',
                    data: function (row) {
                        return row.quantity + ' ' + row.item_unit.name;
                    }
                },
                {
                    // title: 'Item NO',
                    data: 'price'
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        // Calculate total amount by multiplying price and quantity
                        const totalAmount = row.price * row.quantity;
                        return totalAmount.toFixed(0); // Adjust as needed
                    }
                },

                {
                    data: 'description',

                },
                {
                    data: 'department.name',

                },

                {
                    // title: 'Category',
                    data: 'suppliers.name'
                },
                {
                    // title: 'Date',
                    data: 'created_at',
                    render: function (data) {
                        const dateObject = new Date(data);
                        const day = dateObject.getDate().toString().padStart(2, '0');
                        const month = (dateObject.getMonth() + 1).toString().padStart(2, '0'); // Note: Month is zero-based
                        const year = dateObject.getFullYear();
                        const hours = dateObject.getHours().toString().padStart(2, '0');
                        const minutes = dateObject.getMinutes().toString().padStart(2, '0');
                        //  const seconds = dateObject.getSeconds().toString().padStart(2, '0');
                        //const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
                        const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}`;
                        return formattedDate;
                    },
                },

                {
                    data: null,
                    render: (data, type, row) => `
            <td>
              <button class="btn btn-primaryx fa fa-edit update-btn ml-n2" data-row='${JSON.stringify(row).replace(/'/g, "\\'")}'></button>
              <button class="btn btn-dangerx delete-btn fa fa-trash text-danger ml-n3" data-row='${JSON.stringify(row).replace(/'/g, "\\'")}'></button>
            </td>
          `,
                },

            ],

            botones: [{
                    title: 'CHS Central Store Stock',
                    extend: 'excelHtml5',
                    text: '<i class=" fa fa-solid fa-file-excel fs-1"></i>Excel',
                    className: 'btn btn-success',

                },
               
                {
                    title: 'CHS Central Store items report',
                    extend: 'print',
                    text: '<i class="fa fa-solid fa-print"></i>Print',
                    className: 'btn btn-success',

                },
            ],

        }

    },

    computed: {
        calculateTotalAmount() {
            return this.item.price * this.item.quantity;
        }
    },
    watch: {
        calculateTotalAmount(newTotal) {
            this.item.totalAmount = newTotal;
        },

        'item.categoryname': function (newVal, oldVal) {

            // The 'newVal' parameter will contain the newly selected item
            if (newVal) {
                this.onCategorySelected(newVal);
            }
        },

        'item.suppliername': function (newVal, oldVal) {

            // The 'newVal' parameter will contain the newly selected item
            if (newVal) {
                this.onSupplierSelected(newVal);
            }
        },

        'item.departmentname': function (newVal, oldVal) {

            // The 'newVal' parameter will contain the newly selected item
            if (newVal) {
                this.onDepartmentSelected(newVal);
            }
        },

        'item.unitname': function (newVal, oldVal) {

            // The 'newVal' parameter will contain the newly selected item
            if (newVal) {
                this.onUnitSelected(newVal);
            }
        },

    },

    mounted() {

        this.getItems();
        this.getsuppliers();
        this.getUnits();

        this.getCategories();
        this.getDepartments();
        this.getDepartmentItems();

        const dataTable = this.$refs.myDataTable.$el;
        dataTable.addEventListener('click', this.handleDataTableClick);
    },
    beforeDestroy() {
        const dataTable = this.$refs.myDataTable.$el;
        dataTable.removeEventListener('click', this.handleDataTableClick);
    },

    methods: {
        onCategorySelected(selected1) {
            this.item.categoryId = selected1.id
            //console.log('Item selected: ' + selectedItem.name);
        },
        onSupplierSelected(selected2) {
            this.item.supplierId = selected2.id
            //console.log('Item selected: ' + selectedItem.name);
        },
        onUnitSelected(selected3) {
            this.item.unitId = selected3.id
            //console.log('Item selected: ' + selectedItem.name);
        },
        onDepartmentSelected(selected4) {
            this.item.departmentId = selected4.id
            //console.log('Item selected: ' + selectedItem.name);
        },

        handleDataTableClick(event) {
            const target = event.target;

            if (target.classList.contains('update-btn')) {
                const rowData = JSON.parse(target.dataset.row.replace(/\\'/g, "'"));
                this.updateItem(rowData);
            } else if (target.classList.contains('delete-btn')) {
                const rowData = JSON.parse(target.dataset.row.replace(/\\'/g, "'"));
                this.deleteItem(rowData);
            }
        },

        newItem() {

            this.editMode = false
            this.item = {
                name: '',
                item_no: '',
                quantity: '',
                orquantity: '',
                price: '',
                description: '',
                categoryname: '',
                suppliername: '',
                unitname: '',
                totalAmount: '',
                departmentname: ''
            }

            $("#taskmodal").modal("show");
        },

        updateItem(rowData) {
            //console.log(supplier);
            //this.item = ''
            // console.log(this.item)
            this.editMode = true;
            $("#taskmodal").modal("show");
            //  this.item = rowData;

            // alert('hi boy')

            this.item = {
                    id: rowData.id,
                    name: rowData.name,
                    item_no: rowData.item_no,
                    orquantity:rowData.remain_quantity,
                    quantity: rowData.quantity,
                    price: rowData.price,
                    description: rowData.description,
                    categoryname: rowData.categories.name,
                    departmentname: rowData.department.name,
                    suppliername: rowData.suppliers.name,
                    unitname: rowData.item_unit.name,
                    // totalAmount: rowData.created_at,
                    //itemID: ''

                },
                //  this is the fuction to call onslected fucntion  when in update state;
                this.$nextTick(() => {
                    this.onCategorySelected(rowData.categories);
                    this.onSupplierSelected(rowData.suppliers);
                    this.onDepartmentSelected(rowData.department);
                    this.onUnitSelected(rowData.item_unit);
                });

        },

        deleteItem(rowData) {
            //this.editMode = false

            this.item.id = rowData.id;
            $("#deleteModal").modal("show");
        },

        saveItem() {

            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("https://centralstore.chukahighschool.sc.ke/api/addItem", this.item).then(response => {

                this.$toast.success(`Item saved successfully`, {
                    position: "top",
                    dismissible: false
                })
                $("#taskmodal").modal("hide");

                this.$emitter.emit('changeLoaderStatus', false);
                this.getItems();
                //this.items.push(this.item);

            }).catch(error => {

                if (error.response && error.response.status === 500) {
                    this.importErrors = error.response.data.error;
                    this.showAlert = true;

                    setTimeout(() => {
                        this.showAlert = false;
                    }, 5000);
                    //console.log('Errors:', this.errors);
                } else {

                    this.$toast.error(`serverError! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            });
        },

        getDepartments() {
            this.$emitter.emit('mychangeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getDepartments").then(response => {
                this.mydepartments = response.data.mydata;

                this.$emitter.emit('mychangeLoaderStatus', false)
            })

        },

        getItems() {
         //   this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getItems").then(response => {
                this.items = response.data.data;

                //this.$emitter.emit('changeLoaderStatus', false)
            })

        },

        getDepartmentItems() {
           this.$emitter.emit('mychangeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getItems", {
                    params: {
                        mydepartment: this.mydepartment
                    }
                })
                .then(response => {
                        //window.emitter.emit('loaderStatus', false)
                        this.items = response.data.data;
                      this.$emitter.emit('mychangeLoaderStatus',false)
                    },

                );

        },

        editItems() {

            //alert( this.item.unitId );
            this.$emitter.emit('changeLoaderStatus', true)
            axios.patch("https://centralstore.chukahighschool.sc.ke/api/updateItems/" + this.item.id, this.item).then(() => {

                this.$toast.success(`Item updated successfully`,

                    {
                        position: "top",
                        dismissible: false

                    }

                )
                $("#taskmodal").modal("hide");

                this.$emitter.emit('changeLoaderStatus', false)
                this.getItems();

            }).finally(() => {
                $("#taskModal").modal("hide")
            }).catch(error => {

                if (error.response && error.response.status === 500) {
                    this.importErrors = error.response.data.error;
                    this.showAlert = true;

                    setTimeout(() => {
                        this.showAlert = false;
                    }, 5000);
                    //console.log('Errors:', this.errors);
                } else {
                    //console.error('Unknown errors:', error);
                    // alert('check file again')
                    this.$toast.error(`Error! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            }).finally(() => {
                $("#taskModal").modal("hide");
            });
        },

        // function to fetch categories for selection on item selcetion form
        getCategories() {
            //this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getCategories").then(response => {
                this.mycategories = response.data.data;

                //this.$emitter.emit('changeLoaderStatus', false)
            })

        },

        removeItem() {
            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("https://centralstore.chukahighschool.sc.ke/api/deleteItem/" + this.item.id).then(response => {

                $("#deleteModal").modal("hide");
                this.items = this.items.filter((item) => item.id !== this.item.id);

                this.$toast.success(`Deleted successfully`, {
                    position: "top",
                    dismissible: false
                })

                this.$emitter.emit('changeLoaderStatus', false)
            }).catch(error => {

                if (error.response && error.response.status === 500) {

                    this.importErrors = error.response.data.error;
                    this.showAlert = true;

                    setTimeout(() => {
                        this.showAlert = false;
                    }, 5000);

                    //console.log('Errors:', this.errors);
                } else if (error.response.status === 422) {

                    this.message = error.response.data.message;
                    this.showAlert = true;
                    $("#deleteModal").modal("hide");
                    setTimeout(() => {
                        this.showAlert = false;
                    }, 7000);
                } else {
                    //console.error('Unknown errors:', error);
                    // alert('check file again')
                    this.$toast.error(`serverError! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            });

        },
        getsuppliers() {
            //this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getsuppliers").then(response => {
                this.suppliers = response.data.data;

               // this.$emitter.emit('changeLoaderStatus', false)
            })

        },
        getUnits() {
           // this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getUnits").then(response => {
                this.myunits = response.data.data;

                //this.$emitter.emit('changeLoaderStatus', false)
            })

        },

    },

}
</script>

<style></style>
