<template>
    <div v-if="showAlert">
        <div v-if="message">
            <h5 class="alert alert-danger  container "> {{ message}} </h5>
        </div>
    </div>
    
    <!-- DELETE ITEMS  MODAL -->
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
    
    <div class="modal fade" id="taskmodal" tabindex="-1" role="dialogx" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centred modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
    
                    <h5 class="modal-title" id="taskModalLabel">{{ !editMode ? 'Issue items .' : 'Update items' }}</h5>
    
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
                            <label class="form-label">Search Staff</label>
                            <v-select :options="staffs" label="name" v-model="item.selectedStaff" required="required" :disabled="editMode"></v-select>
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label">Number issued</label>
                            <input type="text" class="form-control" v-model="item.quantity" required>
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label">SELECT ITEM</label>
                            <v-select :options="myitems" label="name" v-model="item.selectedItem" required :disabled="editMode"></v-select>
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label text-warning">Remaining Stock</label>
                            <input type="text" class="form-control" :value="item.itemQuantity" readonly>
                        </div>
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                {{ !editMode ? 'Save ' : 'Update' }}</button>
                        </div>
                    </form>
                </div>
    
            </div>
        </div>
    </div>
    
    <div class="text-right bg-success container-fluid" style="margin-top:0%; margin-right:5%">
    
        <label for="1"> SELECT DEPARTMENT</label> <select name="stream" id="stream" v-model="mydepartment" @change="getDepartmentItems()" style="z-index: 1;position: relative;text-transform: uppercase;margin-right:67px">
            <option value selected>All DEPARTMENTS</option>
            <option v-for="item in mydepartments" :key="item.id" :value="item.name">
                {{item.name}}
            </option>
        </select> <button class="btn btn-primary" @click="newItem" style="font-size:12px;z-index: 1;position: relative"><i class="fa fa-plus">ISSUE ITEM</i> </button> </div>
    <div class="text-center text-success"><b>LIST OF ITEMS ISSUED</b></div>
    <div class="col-lg-12 offset-lg-2x " style="margin-top:-65px;">
    
        <div class="table caption-top table-responsive table-responsive-sm table-responsive-md table-responsive-xl  ">
    
            <DataTable style="text-transform:uppercase ;" ref="myDataTable" class="table  cell-border  table-sm  display tablex table-striped table-hover table table-bordered " :columns="columns" :data="DailyItems" :options="{dom:'Bfrtip',responsive:'true',select: true,
        autoWidth:false,language:{zeroRecords:'No records in the table'}, buttons:botones}">
    
                <thead>
    
                    <tr class="table-success">
                        <th>#</th>
                        <th>Staff Name</th>
                        <th>Item Issued</th>
    
                        <th>No.issued</th>
                        <th style="">Remaining</th>
    
                        <th>category</th>
                        <th>Department</th>
                        <th>Date issued</th>
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
    //import pdfFonts from 'pdfmake/build/vfs_fonts'
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
    
        components: {
            DataTable,
          
            
        },
        data() {
            return {
                item: {
    
                    quantity: '',
                    selectedStaff: null,
                    itemQuantity: '',
                    itemQuantity2: '',
                    selectedItem: null,
                    itemID: '',
                    itemTime: ''
    
                },
                mydepartment: '',
                showAlert: false,
                //  form: null,
                // edit: false,
                editMode: false,
                myitems: [],
                mycategories: [],
                mydepartments: [],
                issuedItems: [],
                staffs: [],
                departments: [],
                DailyItems: [],
                searchText: "",
    
                columns: [{
                        data: null,
                        render: function (data, type, row, meta) {
                            return `${meta.row + 1}`;
                        },
                    },
                    {
                        // title: 'Staff name',
                        data: 'staff.name'
                    },
                    {
                        // title: 'items',
                        data: 'items.name'
                    },
    
                    {
                        // title: 'Quantity',
                        data: function (row) {
                            return row.quantity + ' ' + row.items.item_unit.name;
                        }
                    },
    
                    {
                        // title: 'Quantity',
                        data: function (row) {
                            return row.items.quantity + ' ' + row.items.item_unit.name;
                        }
                    },
    
                    {
                        // title: 'Category',
                        data: 'items.categories.name'
                    },
                    {
                        // title: 'items',
                        data: 'items.department.name'
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
                  <button class="btn btn-primaryx fa fa-edit update-btn" data-row='${JSON.stringify(row).replace(/'/g, "\\'")}'></button>
                  <button class="btn btn-dangerx delete-btn fa fa-trash text-danger  ml" data-row='${JSON.stringify(row).replace(/'/g, "\\'")}'></button>
                </td>
              `,
                    },
    
                ],
    
                botones: [{
                        title: 'Items issued Excel',
                        extend: 'excelHtml5',
                        text: '<i class=" fa fa-solid fa-file-excel fs-1"></i>Excel',
                        className: 'btn btn-success',
    
                    },
                    
                    {
                        title: 'Items issued report',
                        extend: 'print',
                        text: '<i class="fa fa-solid fa-print"></i>Print',
                        className: 'btn btn-success',
    
                    },
                ],
    
            }
    
        },
        watch: {
            'item.selectedItem': function (newVal, oldVal) {
    
                // The 'newVal' parameter will contain the newly selected item
                if (newVal) {
                    this.onItemSelected(newVal);
                }
            },
    
            'item.selectedStaff': function (newVal, oldVal) {
                // The 'newVal' parameter will contain the newly selected item
                if (newVal) {
                    this.onStaffSelected(newVal);
                }
            },
        },
    
        mounted() {
            //this.item.itemQuantity=selectedItem.quantity;
           
    
            //this.getCategories();
            this.getIssuedItems();
            this.getDailyItems()
            this.getItems();
            this.getStaff();
            this.getDepartmentItems();
            this.getDepartments();
            // this.updateItem();
            //code to get specific row data when update or click button triggered 
            const dataTable = this.$refs.myDataTable.$el;
            dataTable.addEventListener('click', this.handleDataTableClick);
    
        },
        beforeDestroy() {
            const dataTable = this.$refs.myDataTable.$el;
            dataTable.removeEventListener('click', this.handleDataTableClick);
        },
    
        methods: {
    
            onItemSelected(selectedItem) {
                this.item.itemID = selectedItem.id
                this.item.itemQuantity = selectedItem.quantity;
                //  this.item.itemTime=selectedItem.created;
    
                //console.log('Item selected: ' + selectedItem.name);
            },
            onStaffSelected(selectedStaff) {
                this.item.staffID = selectedStaff.id
                //console.log('Item selected: ' + selectedItem.name);
            },
    
            handleDataTableClick(event) {
                const target = event.target;
    
                if (target.classList.contains('update-btn')) {
                    const rowData = JSON.parse(target.dataset.row.replace(/\\'/g, "'"));
                    this.updatemyItem(rowData);
                } else if (target.classList.contains('delete-btn')) {
                    const rowData = JSON.parse(target.dataset.row.replace(/\\'/g, "'"));
                    this.deleteItem(rowData);
                }
            },
    
            newItem() {
    
                this.editMode = false
                this.item = {
                    itemID: '',
                    staffID: '',
                    quantity: '',
    
                }
    
                $("#taskmodal").modal("show");
            },
    
            updatemyItem(rowData) {
    
                this.itemMyid = rowData.id;
    
                this.editMode = true;
                $("#taskmodal").modal("show");
    
                this.item = {
                    quantity: rowData.quantity,
                    selectedStaff: rowData.staff.name,
    
                    selectedItem: rowData.items.name,
                    itemQuantity: rowData.items.quantity,
                    itemTime: rowData.created_at,
                    //itemID: ''
    
                }
                //  this is the fuction to call onslected fucntion  when in update state;
                this.$nextTick(() => {
                    this.onStaffSelected(rowData.staff);
                    this.onItemSelected(rowData.items);
                });
            },
    
            deleteItem(rowData) {
                //this.editMode = false
                //this.itemMyid,
                this.item.id = rowData.id;
                $("#deleteModal").modal("show");
            },
    
            saveItem() {
    
                let formData = new FormData();
    
                formData.append('staffID', this.item.staffID);
                formData.append('quantity', this.item.quantity);
                formData.append('itemID', this.item.itemID);
    
                //IF FUNCTION TO CHECK IF QUANTITY IS OUT STOCK
             //   if (this.item.quantity > this.item.itemQuantity) {
                if (parseInt(this.item.quantity) > parseInt(this.item.itemQuantity)) {
    
                    this.$toast.error(`Please you have entered quantity  which is more than available  stock !`, {
                        position: "top"
    
                    })
    
                } else {
    
                   this.$emitter.emit('changeLoaderStatus', true)
    
                    // var data = new FormData(formOnes);
                    axios.post("https://centralstore.chukahighschool.sc.ke/api/issueItems", formData).then(response => {
    
                        this.$toast.success(`Item issued successfully`, {
                            position: "top",
                            dismissible: false
                        })
                        $("#taskmodal").modal("hide");
    
                       this.$emitter.emit('changeLoaderStatus', false);
                        //this.getItems(); 
                        this.getIssuedItems();
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
                }
            },
    
            getIssuedItems() {
               this.$emitter.emit('mychangeLoaderStatus', true)
                axios.get("https://centralstore.chukahighschool.sc.ke/api/issuedItem").then(response => {
                    this.issuedItems = response.data.data;
    
                    this.$emitter.emit('mychangeLoaderStatus', false)
                })
    
            },
            getDepartmentItems() {
    
              this.$emitter.emit('mychangeLoaderStatus', true)
                axios.get("https://centralstore.chukahighschool.sc.ke/api/getDailyItems", {
                    params: {
                        mydepartment: this.mydepartment
                    }
                }).then(response => {
                    this.DailyItems  = response.data.data;
    
                   this.$emitter.emit('mychangeLoaderStatus', false)
                })
    
            },
    
            getDepartments() {
              //  this.$emitter.emit('changeLoaderStatus', true)
                axios.get("https://centralstore.chukahighschool.sc.ke/api/getDepartments").then(response => {
                    this.mydepartments = response.data.mydata;
    
                   // this.$emitter.emit('changeLoaderStatus', false)
                })
    
            },
    
            getItems() {
                //  this.$emitter.emit('changeLoaderStatus', true)
                axios.get("https://centralstore.chukahighschool.sc.ke/api/getItems").then(response => {
                    this.myitems = response.data.data;
    
                    //  this.$emitter.emit('changeLoaderStatus', false)
                })
    
            },

            getDailyItems() {
            // this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getDailyItems").then(response => {
                this.DailyItems = response.data.data;
                //  this.totalAmountsDaily();
                // this.$emitter.emit('changeLoaderStatus', false)

            })

        },
    
            editItems() {
    
               // alert(this.item.quantity);
               // alert(this.item.itemQuantity);
              /*  if (parseInt(this.item.quantity) > parseInt(this.item.itemQuantity)) {
    
                    this.$toast.error(`Please you have entered number of items  which is more than available  stock!`, {
                        position: "top"
    
                    })
    
                } else { */
    
                    //alert(this.itemMyid);
                    this.$emitter.emit('changeLoaderStatus', true)
                    //  this.$nextTick(() => {
                    axios.patch("https://centralstore.chukahighschool.sc.ke/api/updateIssuedItems/" + this.itemMyid, this.item).then(() => {
    
                        this.$toast.success(`Updated successfully`,
    
                            {
                                position: "top",
                                dismissible: false
    
                            }
    
                        )
                        $("#taskmodal").modal("hide");
                        this.getIssuedItems();
                        this.item = {
                            itemID: '',
                            staffID: '',
                            quantity: '',
    
                        }
    
                        this.$emitter.emit('changeLoaderStatus', false)
    
                        //})
                    }).finally(() => {
                        $("#taskModal").modal("hide")
    
                    }).catch(error => {
    
                        if (error.response && error.response.status === 500) {
                            //alert(this.error.response )
                            // alert('hi')
                            const responseData = error.response.data.error;
    
                            this.importErrors = responseData;
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
               // }
            },
    
            removeItem() {
                this.$emitter.emit('changeLoaderStatus', true)
                // var data = new FormData(formOnes);
                axios.post("https://centralstore.chukahighschool.sc.ke/api/deleteIssueItem/" + this.item.id).then(response => {
    
                    $("#deleteModal").modal("hide");
    
                    this.$toast.success(`Deleted successfully`, {
                        position: "top",
                        dismissible: false
                    })
                    this.issuedItems = this.issuedItems.filter((item) => item.id !== this.item.id);
                    this.getIssuedItems();
                    this.getItems();
                    this.$emitter.emit('changeLoaderStatus', false)
                }).catch(error => {
    
                    //alert("Error in uploading,check your file type and try gain!");
    
                    if (error.response && error.response.status === 500) {
    
                        this.$toast.error(`SOMETHING WENT WRONG! CONTACT ADMIN FOR HELP!`, {
                                position: "top"
    
                            }
    
                        )
                    } else {
    
                        this.$toast.error(`serverError! try again!`, {
                                position: "top"
    
                            }
    
                        )
                    }
                    this.$emitter.emit('changeLoaderStatus', false)
    
                });
    
            },
    
            getStaff() {
                // this.$emitter.emit('changeLoaderStatus', true)
                axios.get("https://centralstore.chukahighschool.sc.ke/api/getStaff").then(response => {
                    this.staffs = response.data.data;
    
                    // this.$emitter.emit('changeLoaderStatus', false)
                })
    
            },
            
    
        },
    
    }
    </script>
    
    <style scoped>
    @import 'datatables.net-bs5';
    
    .front {
        z-index: 1;
        /* set higher z-index value */
        position: relative;
        /* position must be set for z-index to work */
    }
    </style>
    