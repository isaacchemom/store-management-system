<template>
<!-- delete modal -->
<div v-if="showAlert">
    <div v-if="message">
        <h5 class="alert alert-danger  containerx "> {{ message}} </h5>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETE?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="alert alert-warning">Are you sure you want to delete this category with its related items?</h6>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" @click="removeCategory">Delete</button>
            </div>
        </div>
    </div>
</div>

<div style="background-color:white;" class="mt-4 ml-4 mr-4">

    <div class="modal fade" id="taskmodal" tabindex="-1" role="dialogx" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centred modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="taskModalLabel">{{ !editMode ? 'Add Units.' : 'Update Units' }}</h5>

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
                    <form class="row g-3 m-auto" ref="form" @submit.prevent="!editMode ? saveUnits() : editUnits()">
                        <div class="col-md-6">
                            <label class="form-label">NAME</label>
                            <input type="text" class="form-control" v-model="ItemUnits.name" required  placeholder="Enter units">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                {{ !editMode ? 'Save' : 'Update' }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="ml-4x container">

    <div class="text-right" style="margin-top:-1%; margin-right:5%;"><button class="btn btn-primary" @click="newcategory" style="font-size:12px;z-index: 1;
        position: relative"><i class="fa fa-plus">NEW UNIT</i> </button>
    </div>
    <h5 class="text-center text-success">Item Units</h5>
    <table class="table table-striped table-hover table-bordered table-sm"  style="text-transform:uppercase;">
        <thead class="text-success">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Date_created</th>
                <th scope="col">Option</th>

            </tr>
        </thead>
        <tbody>
            <tr v-for="item_unit in myunits" v-bind:key="item_unit.id">
                <td>{{ item_unit.name }}</td>
                <td>{{ formatCategoryDate(item_unit.created_at) }}</td>

                <!---<td> <input type="text" v-model="myform.name[task.id]"></td> -->
                <!--<td>

                           <input @onblur="update(task,$event.target.value)" >-
                          <a href="#" @click.prevent="updates(task)"><i class="fa fa-edit"></i></a>
                        </td>-->
                <td> <a href="#" @click.prevent="updateCategory(item_unit)"><i class="fa fa-edit"></i></a>
                    <a href="#" @click.prevent="deleteCategory(item_unit)"><i class="fa fa-trash text-danger ml-4"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

    
<script>
import { format } from 'date-fns';
//import axios from 'axios';
//import mynav from '../nav.vue'
export default {
    // components: {
    // mynav,

    // },
    data() {
        return {
            ItemUnits: {
                name: '',

            },
            showAlert: false,

            editMode: false,
            myunits: [],
            // message:false

        }

    },

    mounted() {
        this.getUnits()
    },
    methods: {
        formatCategoryDate(dateString) {
      // Parse the date string and format it using date-fns
      return format(new Date(dateString), 'd/M/y H:mm:ss');},

        deleteCategory(deleteCategory) {
            //this.editMode = false

            this.ItemUnits.id = deleteCategory.id;
            $("#deleteModal").modal("show");
        },

        newcategory() {

            this.editMode = false
            this.ItemUnits = {
                name: '',

            };

            $("#taskmodal").modal("show");
            //this.categories.push(this.category);
        },

        updateCategory(mycategory) {
            //console.log(supplier);
            this.ItemUnits = ''
            this.editMode = true;
            $("#taskmodal").modal("show");
            this.ItemUnits = mycategory;
        },

        removeCategory() {
            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("https://centralstore.chukahighschool.sc.ke/api/deleteUnits/" + this.ItemUnits.id).then(response => {

                $("#deleteModal").modal("hide");
                //this.category.value=this.category.value.filter(category.id!==this.category.id)

                this.$toast.success(`Deleted successfully`, {
                    position: "top",
                    dismissible: false
                })
                this.myunits = this.myunits.filter((ItemUnits) => ItemUnits.id !== this.ItemUnits.id);

                this.$emitter.emit('changeLoaderStatus', false)
            }).catch(error => {

                //alert("Error in uploading,check your file type and try gain!");

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

        saveUnits() {

            this.$emitter.emit('changeLoaderStatus', true)

            axios.post("https://centralstore.chukahighschool.sc.ke/api/addUnits", this.ItemUnits).then(response => {

                this.$toast.success(`Unit added successfully`, {
                    position: "top",
                    dismissible: false
                })
                $("#taskmodal").modal("hide");

                // this.categories='';

                this.$emitter.emit('changeLoaderStatus', false);
               // this.categories.push(this.category);
               this.getUnits()

            }).catch(error => {

                if (error.response && error.response.status === 500) {
                    this.importErrors = error.response.data.error;
                    this.showAlert = true;

                    setTimeout(() => {
                        this.showAlert = false;
                    }, 5000);

                } else {

                    this.$toast.error(`serverError! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            });
        },

        getUnits() {
            this.$emitter.emit('mychangeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getUnits").then(response => {
                this.myunits = response.data.data;

                this.$emitter.emit('mychangeLoaderStatus', false)
            })

        },

        editUnits() {

            this.$emitter.emit('changeLoaderStatus', true)
            axios.patch("https://centralstore.chukahighschool.sc.ke/api/updateUnits/" + this.ItemUnits.id, this.ItemUnits).then(() => {

                this.$toast.success(`Unit Updated successfully`,

                    {
                        position: "top",
                        dismissible: false

                    }

                )

                this.$emitter.emit('changeLoaderStatus', false);
                $("#taskmodal").modal("hide");

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

    },

}
</script>

    
<style></style>
