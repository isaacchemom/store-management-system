<template>
<!-- Radio buttons -->
<div style="background-color:white;" class="mt-4 ml-4 mr-4">

    <hr />

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
                    <form class="row g-3 m-auto"  @submit.prevent="!editMode ? savesupplier() : editSupplier()">
                        <div class="col-md-6">
                            <label class="form-label">NAME</label>
                            <input type="text" class="form-control" v-model="supplier.name" required pattern="[A-Za-z\s]+">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PHONE</label>
                            <input type="text" class="form-control" v-model="supplier.contact" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">EMAIL(optional)</label>
                            <input type="email" class="form-control" v-model="supplier.email">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ADRESS|RESIDENCE</label>
                            <input type="text" class="form-control" v-model="supplier.address" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                {{ !editMode ? 'New supplier' : 'Update' }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
<hr>

<h4>LIST OF SUPPLIERS</h4>
<button @click="newsupplier">ADD NEW </button>
<table class="table table-stripped table-hover">
    <thead>
        <tr>
            <th scope="col">NAME</th>

            <th scope="col">CONTACT</th>
            <th scope="col">EMAIL</th>

            <th scope="col">ADDRESS</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="supplier in suppliers" v-bind:key="supplier.id">
            <th scope="row">{{ supplier.name }}</th>
            <td>{{ supplier.contact }}</td>
            <td>{{ supplier.email }}</td>
            <td>{{ supplier.address }}</td>

            <!---<td> <input type="text" v-model="myform.name[task.id]"></td> -->
            <!--<td>

               <input @onblur="update(task,$event.target.value)" >-
              <a href="#" @click.prevent="updates(task)"><i class="fa fa-edit"></i></a>
            </td>-->
            <td> <a href="#" @click.prevent="editSupplier(supplier)"><i class="fa fa-edit"></i>edit</a></td>
        </tr>
    </tbody>
</table>
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
            supplier: {
                name: '',
                contact: '',
                email: '',
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
        newsupplier() {

            this.editMode = false
            this.supplier = {
                name: '',
                contact: '',
                email: '',
                address: ''

            }

            $("#taskmodal").modal("show");
        },

        editSupplier(supplier) {
            //console.log(supplier);

            this.editMode = true;
            $("#taskmodal").modal("show");
            this.supplier = {
                name: supplier.name,
                contact: supplier.contact,
                email: supplier.email,
                address: supplier.address,

            }

            // alert('hi boy')

        },

        savesupplier() {

            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("http://127.0.0.1:8000/api/addsupplier", this.supplier).then(response => {
                this.$toast.success(`Supplier Saved successfully`, {
                    position: "top",
                    dismissible: false
                })

                //alert("EXCEL FILE saved successfully");
                this.$emitter.emit('changeLoaderStatus', false)
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

        getsuppliers() {
            this.$emitter.emit('changeLoaderStatus', true)
            axios.get("http://127.0.0.1:8000/api/getsuppliers").then(response => {
                this.suppliers = response.data.data;

                this.$emitter.emit('changeLoaderStatus', false)
            })

        }

    },

}
</script>

<style></style>
