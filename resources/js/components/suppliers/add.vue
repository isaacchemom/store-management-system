<template>
<div v-if="showAlert">
    <div v-if="message">
        <h5 class="alert alert-danger  container "> {{ message}} </h5>
    </div>
</div>
<div style="background-color:white;" class="mt-4 ml-4 mr-4">
    <!-- DELETE ITEMS  MODAL -->
    <div class="modal" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Supplier?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="alert alert-warning">Are you sure you want to delete item?</h6>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" @click="removeSupplier">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!---end of delete modal-->
    <!-- Radio buttons -->

    <div class="modal fade" id="taskmodal" tabindex="-1" role="dialogx" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centred modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="taskModalLabel">{{ !editMode ? 'Add Supplier.' : 'Update Supplier' }}</h5>

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
                    <form class="row g-3 m-auto" @submit.prevent="!editMode ? savesupplier() : editSupplier()">
                        <div class="col-md-6">
                            <label class="form-label">NAME</label>
                            <input type="text" class="form-control" v-model="supplier.name" required pattern="[A-Za-z\s]+">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PHONE</label>
                            <input type="text" class="form-control" v-model="supplier.contact" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SHOP|COMPANY</label>
                            <input type="text" class="form-control" v-model="supplier.company" required placeholder="The company or shop name of supplier">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Items</label>
                            <input type="text" class="form-control" v-model="supplier.item" required placeholder="Items supplied by the supplier">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ADRESS|Location</label>
                            <input type="text" class="form-control" v-model="supplier.address" required placeholder="Enter location name of shop or company">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                {{ !editMode ? 'Add supplier' : 'Update' }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="container">

    <div class="text-right" style="margin-top:-1%; margin-right:5%;"><button class="btn btn-primary" @click="newsupplier" style="font-size:12px;z-index: 1;
    position: relative"><i class="fa fa-plus">New Supplier</i> </button>
    </div>
    <h4 class="text-center">LIST OF SUPPLIERS</h4>
    <table class="table table-striped table-hover table-bordered ">
        <thead>
            <tr class="text-success">
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Contact</th>
                <th scope="col">Shop|Company Name</th>
                <th scope="col">Supplier Item(s)</th>

                <th scope="col">Address|Location</th>
                <th scope="col">CREATED ON</th>

                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(supplier, index) in suppliers.data" v-bind:key="index">
                <td>{{ index+1}}</td>
                <td>{{ supplier.name }}</td>
                <td>{{ supplier.contact }}</td>
                <td>{{ supplier.company}}</td>
                <td>{{ supplier.item }}</td>
                <td>{{ supplier.address }}</td>
                <td>{{ formatCategoryDate(supplier.created_at) }}</td>

                <td> <a href="#" @click.prevent="updateSupplier(supplier)"><i class="fa fa-edit"></i></a>
                    <a href="#" @click.prevent="deleteSuppliers(supplier)"><i class="fa fa-trash text-danger  ml-4"></i></a>

                </td>

            </tr>
        </tbody>

    </table>
    <Bootstrap4Pagination  :data="suppliers"  @pagination-change-page="getsuppliers"/>
</div>
</template>

<script>    


import { format } from 'date-fns';
import {Bootstrap4Pagination} from 'laravel-vue-pagination';
//import axios from 'axios';
//import mynav from '../nav.vue'
export default {
    components: {
        Bootstrap4Pagination

     },
    data() {
        return {
            supplier: {
                name: '',
                contact: '',
                company: '',
                item: '',
                address: ''
            },
            showAlert: false,
            form: null,
            edit: false,
            editMode: false,
            suppliers: []

        }

    },

    mounted() {
        this.getsuppliers()
    },
    methods: {

        formatCategoryDate(dateString) {
      // Parse the date string and format it using date-fns
      return format(new Date(dateString), 'd/M/y H:mm:ss');},

        newsupplier() {

            this.editMode = false
            this.supplier = {
                name: '',
                contact: '',
                company: '',
                item: '',
                address: ''

            }

            $("#taskmodal").modal("show");
        },

        updateSupplier(supp) {
            //console.log(supplier);

            this.editMode = true;
            $("#taskmodal").modal("show");
            this.supplier = supp;

        },
        deleteSuppliers(myitem) {
            //this.editMode = false
            this.supplier.id = myitem.id;

            $("#deleteModal").modal("show");

        },

        savesupplier() {

            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("https://centralstore.chukahighschool.sc.ke/api/addsupplier", this.supplier).then(response => {
                this.$toast.success(`Supplier added successfully`, {
                    position: "top",
                    dismissible: false
                })
                $("#taskmodal").modal("hide");

                //alert("EXCEL FILE saved successfully");
                this.$emitter.emit('changeLoaderStatus', false)
                this.getsuppliers()
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
                    this.$toast.error(`Error! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            });
        },

        getsuppliers(page = 1) {
            this.$emitter.emit('mychangeLoaderStatus', true)
            axios.get('https://centralstore.chukahighschool.sc.ke/api/getsuppliers?page='+ page).then(response => {
                this.suppliers = response.data.mydata;

                this.$emitter.emit('mychangeLoaderStatus', false)
            })

        },

        editSupplier() {

            this.$emitter.emit('changeLoaderStatus', true)
            axios.patch("https://centralstore.chukahighschool.sc.ke/api/editSupplier/" + this.supplier.id, this.supplier).then(() => {

                this.$toast.success(`Supplier info. updated successfully`,

                    {
                        position: "top",
                        dismissible: false

                    }

                )
                $("#taskmodal").modal("hide");

                this.$emitter.emit('changeLoaderStatus', false)
                this.getsuppliers()

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
        removeSupplier() {
            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("https://centralstore.chukahighschool.sc.ke/api/deleteSupplier/" + this.supplier.id).then(response => {

                $("#deleteModal").modal("hide");
                this.suppliers.data = this.suppliers.data.filter((supplier) => supplier.id !== this.supplier.id);

                this.$toast.success(`Supplier Deleted successfully`, {
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

    },

}
</script>

<style></style>
