<template>
<!-- delete modal -->
<div class="modal" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETE CATEGORY</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want delete this category?</h5>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" @click="removeCategory">Delete</button>
            </div>
        </div>
    </div>
</div>

<div style="background-color:white;" class="mt-4 ml-4 mr-4">

    <hr />

    <div class="modal fade" id="taskmodal" tabindex="-1" role="dialogx" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centred modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="taskModalLabel">{{ !editMode ? 'Add Category.' : 'Update Category' }}</h5>

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
                    <form class="row g-3 m-auto" ref="form">
                        <div class="col-md-6">
                            <label class="form-label">NAME</label>
                            <input type="text" class="form-control" v-model="category.name" required pattern="[A-Za-z\s]+">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">DESCRIPTION</label>
                            <input type="text" class="form-control" v-model="category.description" required placeholder="Optional">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" @click="!editMode ? saveCategory() : editCategory()" class="btn btn-primary">
                                {{ !editMode ? 'save Item' : 'Update Item' }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
<hr>
<div class="ml-4">
    <h4>LIST OF CATEGORY</h4>
    <button @click="newcategory" class="text-green float-right mr-5">ADD NEW </button>
    <table class="table table-stripped table-hover ">
        <thead>
            <tr>
                <th scope="col">NAME</th>

                <th scope="col">DESCRIPTION</th>
                <th scope="col">Option</th>

            </tr>
        </thead>
        <tbody>
            <tr v-for="category in categories" v-bind:key="category.id">
                <td> {{ category.name }} </td>
                <td>{{ category.description }}</td>

                <!---<td> <input type="text" v-model="myform.name[task.id]"></td> -->
                <!--<td>

                       <input @onblur="update(task,$event.target.value)" >-
                      <a href="#" @click.prevent="updates(task)"><i class="fa fa-edit"></i></a>
                    </td>-->
                <td> <a href="#" @click.prevent="updateCategory(category)"><i class="fa fa-edit"></i></a>
                    <a href="#" @click.prevent="deleteCategory(category)"><i class="fa fa-trash text-danger ml-4"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
//import axios from 'axios';
//import mynav from '../nav.vue'
export default {
    // components: {
    // mynav,

    // },
    data() {
        return {
            category: {
                name: '',
                description: ''
            },
            showAlert: false,

            editMode: false,
            categories: []

        }

    },

    mounted() {
        this.getCategories()
    },
    methods: {

        deleteCategory(deleteCategory) {
            //this.editMode = false

            this.category.id = deleteCategory.id;
            $("#deleteModal").modal("show");
        },

        newcategory() {

            this.editMode = false
            this.category = {
                name: '',
                description: '',

            };

            $("#taskmodal").modal("show");
            //this.categories.push(this.category);
        },

        updateCategory(mycategory) {
            //console.log(supplier);
            this.category = ''
            this.editMode = true;
            $("#taskmodal").modal("show");
            this.category = mycategory;
        },

        removeCategory() {
            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("http://127.0.0.1:8000/api/deleteCategory/" + this.category.id).then(response => {

                $("#deleteModal").modal("hide");
                //this.category.value=this.category.value.filter(category.id!==this.category.id)
                this.categories = this.categories.filter((category) => category.id !== this.category.id);

                this.$toast.success(`Deleted successfully`, {
                    position: "top",
                    dismissible: false
                })

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

        saveCategory() {

            this.$emitter.emit('changeLoaderStatus', true)

            axios.post("http://127.0.0.1:8000/api/addCategory", this.category).then(response => {
                this.$toast.success(`Item Saved successfully`, {
                    position: "top",
                    dismissible: false
                })
                $("#taskmodal").modal("hide");

                this.$emitter.emit('changeLoaderStatus', false);
                this.categories.push(this.category);
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

        getCategories() {
            this.$emitter.emit('changeLoaderStatus', true)
            axios.get("http://127.0.0.1:8000/api/getCategories").then(response => {
                this.categories = response.data.data;

                this.$emitter.emit('changeLoaderStatus', false)
            })

        },

        editCategory() {

            this.$emitter.emit('changeLoaderStatus', true)
            axios.patch("http://127.0.0.1:8000/api/updateCategory/" + this.category.id, this.category).then(() => {

                this.$toast.success(`Updated successfully`,

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
