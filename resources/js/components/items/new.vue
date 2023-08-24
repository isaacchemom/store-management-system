<template>
<!-- Radio buttons -->
<div style="background-color:white;" class="mt-4 ml-4 mr-4">

    <hr />

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
                    <form class="row g-3 m-auto" ref="form">
                        <div class="col-md-6">
                            <label class="form-label">NAME</label>
                            <input type="text" class="form-control" v-model="item.name" required pattern="[A-Za-z\s]+">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ITEM CODE</label>
                            <input type="text" class="form-control" v-model="item.item_no" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">CATEGORY</label>
                            <select v-model="item.categoryId" class="form-control">
                                <option value="" disabled>Select a Category</option>
                                <option v-for="category in mycategories" :value="category.id" :key="category.id">{{ category.name }}</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Quantity</label>
                            <input type="text" class="form-control" v-model="item.quantity" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">PRICE</label>
                            <input type="text" class="form-control" v-model="item.price" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">DESCRIPTION</label>
                            <input type="text" class="form-control" v-model="item.description" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" @click="!editMode ? saveItem() : editItems()" class="btn btn-primary">
                                {{ !editMode ? 'save Item' : 'Update Item' }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
<hr>

<h4>LIST OF ITEMS</h4>
<button @click="newItem">ADD NEW </button>
<table class="table table-stripped table-hover">
    <thead>
        <tr>
            <th scope="col">NAME</th>

            <th scope="col">ITEM NUMBER</th>
            <th scope="col">CATEGORY</th>
            <th scope="col">QUANTITY</th>
            <th scope="col">PRICE</th>

        </tr>
    </thead>
    <tbody>
        <tr v-for="item in items" v-bind:key="item.id">
            <th scope="row">{{ item.name }}</th>
            <td>{{ item.item_no }}</td>
            <th>{{ item.categories}}</th>
            <td>{{ item.quantity }}</td>
            <td>{{ item.price }}</td>

            <!---<td> <input type="text" v-model="myform.name[task.id]"></td> -->
            <!--<td>

                   <input @onblur="update(task,$event.target.value)" >-
                  <a href="#" @click.prevent="updates(task)"><i class="fa fa-edit"></i></a>
                </td>-->
            <td> <a href="#" @click.prevent="updateItem(item)"><i class="fa fa-edit"></i>edit</a></td>
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
            item: {
                name: '',
                item_no: '',
                quantity: '',
                price: '',
                description: '',
                categoryId: ''
            },
            showAlert: false,
            //  form: null,
            // edit: false,
            editMode: false,
            items: [],
            mycategories: [],

        }

    },

    mounted() {
        this.getItems();
        this.getCategories()
            
    },

    created(){


    },
    methods: {
        newItem() {

            this.editMode = false
            this.item = {
                name: '',
                item_no: '',
                quantity: '',
                price: '',
                description: '',

            }

            $("#taskmodal").modal("show");
        },

        updateItem(myitem) {
            //console.log(supplier);
            this.item = ''
            this.editMode = true;
            $("#taskmodal").modal("show");
            this.item = myitem;

            // alert('hi boy')

        },

        saveItem() {

            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("http://127.0.0.1:8000/api/addItem", this.item).then(response => {
                this.$toast.success(`Item Saved successfully`, {
                    position: "top",
                    dismissible: false
                })

                //alert("EXCEL FILE saved successfully");
                this.$emitter.emit('changeLoaderStatus', false);
                this.items.push(this.item);
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

        getItems() {
            this.$emitter.emit('changeLoaderStatus', true)
            axios.get("http://127.0.0.1:8000/api/getItems").then(response => {
                this.items = response.data.data;

                this.$emitter.emit('changeLoaderStatus', false)
            })

        },

        editItems() {

            this.$emitter.emit('changeLoaderStatus', true)
            axios.patch("http://127.0.0.1:8000/api/updateItems/" + this.item.id, this.item).then(() => {

                this.$toast.success(`Saved successfully`,

                    {
                        position: "top",
                        dismissible: false

                    }

                )

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
            this.$emitter.emit('changeLoaderStatus', true)
            axios.get("http://127.0.0.1:8000/api/getCategories").then(response => {
                this.mycategories = response.data.data;

                this.$emitter.emit('changeLoaderStatus', false)
            })

        },

    },

}
</script>

<style></style>
