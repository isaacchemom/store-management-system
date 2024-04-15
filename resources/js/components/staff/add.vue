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
                <h5 class="modal-title">Remove Staff ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="alert alert-warning">Are you sure you want to delete item?</h6>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" @click="removeStaff">Delete</button>
            </div>
        </div>
    </div>
</div>
<!---end of delete modal-->
<!-- Radio buttons -->
<div style="background-color:white;" class="mt-4 ml-4 mr-4">

    <div class="modal fade" id="taskmodal" tabindex="-1" role="dialogx" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centred modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="taskModalLabel">{{ !editMode ? 'Add Staff.' : 'Update Staff' }}</h5>

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
                    <form class="row g-3 m-auto" @submit.prevent="!editMode ? saveStaff() : editStaff()">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" v-model="staff.name" required >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact</label>
                            <input type="text" class="form-control" v-model="staff.contact" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Staff Category</label>
                            <select v-model="staff.category" class="form-control" required>
                                <option value="" disabled>Select </option>
                                <option value="Teaching Staff">TEACHING STAFF</option>
                                <option value="Non Teaching Staff">NONE TEACHING STAFF</option>

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tittle|Designation</label>
                            <input type="text" class="form-control" v-model="staff.designation" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                {{ !editMode ? 'Add Staff' : 'Update' }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<!--
    <h4 class="text-center">STAFF</h4>
    <button @click="newStaff" class="btn btn-primary">ADD NEW </button>
    <table class="table table-stripped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NAME</th>
                <th scope="col">CONTACT</th>
                <th scope="col">CATEGORY</th>

                <th scope="col">DESIGNATION|TITLE</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(mystaff, index) in staffs" v-bind:key="index">
                <td>{{ index+1}}</td>
                <td>{{ mystaff.name }}</td>
                <td>{{ mystaff.contact }}</td>
                <td>{{ mystaff.category }}</td>
                <td>{{ mystaff.designation}}</td>

                <td> <input type="text" v-model="myform.name[task.id]"></td> 
                <td>

                   <input @onblur="update(task,$event.target.value)" >-
                  <a href="#" @click.prevent="updates(task)"><i class="fa fa-edit"></i></a>
                </td>
                <td> <a href="#" @click.prevent="updateStaff(mystaff)"><i class="fa fa-edit"></i>edit</a>
                 <a href="#" @click.prevent="deleteStaff(mystaff)"><i class="fa fa-trash text-danger  ml-4"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
-->

<div class="text-right" style="margin-top:-1%; margin-right:5%;"><button class="btn btn-primary" @click="newStaff" style="font-size:12px;z-index: 1;position: relative"><i class="fa fa-plus">NEW STAFF</i> </button> </div>
<div class="text-center text-success">
    <h3>STAFF</h3>
</div>
<div class="col-lg-12 offset-lg-2x " style="margin-top:-3%;">

    <div class="table caption-top table-responsive table-responsive-sm table-responsive-md table-responsive-xl  ">

        <DataTable ref="myDataTable" class="table  cell-border  table-sm  display tablex table-stripedx table-hover table table-bordered " :columns="columns" :data="staffs" :options="{responsive:'true',select: true,
    autoWidth:false,language:{zeroRecords:'No records in the table'}}">

            <thead>

                <tr class="table-primary">
                    <th>#</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Category</th>
                    <th style="">DESIGNATION|TITLE</th>
                    <th>Created_at</th>

                    <th>Action</th>

                </tr>
            </thead>

        </DataTable>
    </div>
</div>
</template>

<script>
//import axios from 'axios';
//import mynav from '../nav.vue'

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
        DataTable
    },
    data() {
        return {
            staff: {
                name: '',
                contact: '',
                category: '',
                designation: ''
            },
            showAlert: false,
            form: null,
            edit: false,
            editMode: false,
            staffs: [],

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
                    data: 'contact'
                },
                {
                    // title: 'Quantity',
                    data: 'category'
                },
                {
                    // title: 'Quantity',
                    data: 'designation'
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

        }

    },

    mounted() {
        this.getStaff();

        //code to get specific row data when update or click button triggered 
        const dataTable = this.$refs.myDataTable.$el;
        dataTable.addEventListener('click', this.handleDataTableClick);
    },
    methods: {
        handleDataTableClick(event) {
            const target = event.target;

            if (target.classList.contains('update-btn')) {
                const rowData = JSON.parse(target.dataset.row.replace(/\\'/g, "'"));
                this.updateStaff(rowData);
            } else if (target.classList.contains('delete-btn')) {
                const rowData = JSON.parse(target.dataset.row.replace(/\\'/g, "'"));
                this.deleteStaff(rowData);
            }
        },

        newStaff() {

            this.editMode = false
            this.staff = {
                name: '',
                contact: '',
                category: '',
                designation: ''

            }

            $("#taskmodal").modal("show");
        },

        updateStaff(rowData) {
            //console.log(supplier);

            this.editMode = true;
            $("#taskmodal").modal("show");
            this.staff = rowData;

        },
        deleteStaff(rowData) {
            //console.log(supplier);

            this.editMode = true;
            $("#deleteModal").modal("show");
            this.staff.id = rowData.id;

        },

        saveStaff() {

            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("https://centralstore.chukahighschool.sc.ke/api/addStaff", this.staff).then(response => {
                this.$toast.success(`Staff added successfully`, {
                    position: "top",
                    dismissible: false
                })
                $("#taskmodal").modal("hide");

                //alert("EXCEL FILE saved successfully");
                this.$emitter.emit('changeLoaderStatus', false)
                this.getStaff()
            }).catch(error => {

                //alert("Error in uploading,check your file type and try gain!");

                if (error.response && error.response.status === 500) {
                    this.importErrors = error.response.data.error;
                    this.showAlert = true;

                    setTimeout(() => {
                        this.showAlert = false;
                    }, 20000);
                    //console.log('Errors:', this.errors);
                } else {
                    //console.error('Unknown errors:', error);
                    // alert('check file again')
                    this.$toast.error(`Error! try again or conduct system admin!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            });
        },

        editStaff() {

            this.$emitter.emit('changeLoaderStatus', true)
            axios.patch("https://centralstore.chukahighschool.sc.ke/api/editStaff/" + this.staff.id, this.staff).then(() => {

                this.$toast.success(`Staff updated successfully`,

                    {
                        position: "top",
                        dismissible: false

                    }

                )
                $("#taskmodal").modal("hide");
                this.getStaff();
                this.$emitter.emit('changeLoaderStatus', false)


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
            this.$emitter.emit('mychangeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getCategories").then(response => {
                this.mycategories = response.data.data;

                this.$emitter.emit('mychangeLoaderStatus', false)
            })

        },

        getStaff() {
            this.$emitter.emit('mychangeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getStaff").then(response => {
                this.staffs = response.data.data;

                this.$emitter.emit('mychangeLoaderStatus', false)
            })

        },
        removeStaff() {
            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("https://centralstore.chukahighschool.sc.ke/api/deleteStaff/" + this.staff.id).then(response => {

                $("#deleteModal").modal("hide");
                this.staffs = this.staffs.filter((staff) => staff.id !== this.staff.id);

                this.$toast.success(`Staff Removed successfully`, {
                    position: "top",
                    dismissible: false
                })
                this.getStaff();
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

    },

}
</script>
