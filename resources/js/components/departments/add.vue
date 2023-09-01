<template>
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
                <button type="button" class="btn btn-danger" @click="removeDepartment">Delete</button>
            </div>
        </div>
    </div>
</div>
<!---end of delete modal-->
<div style="background-color:white;" class="mt-4 ml-4 mr-4">

    <hr />

    <div class="modal fade" id="taskmodal" tabindex="-1" role="dialogx" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centred modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="taskModalLabel">{{ !editMode ? 'Add Department|Office.' : 'Update Department' }}</h5>

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
                    <form class="row g-3 m-auto" ref="form" @submit.prevent="!editMode ? saveDepartment() : editDepartment()">
                        <div class="col-md-6">
                            <label class="form-label">NAME</label>
                            <input type="text" class="form-control" placeholder="Enter name of department" v-model="department.name" required pattern="[A-Za-z\s]+">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">DESCRIPTION</label>
                            <input type="text" class="form-control" v-model="department.description" placeholder="Optional">
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
<hr>
<div class="container">

<button class="btn btn-primary" @click="newItem">ADD NEW </button>
<h5 class="text-center">DEPARTMENTS|OFFICES</h5>
<table class="table table-stripped table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NAME</th>
            <th scope="col">DESCRIPTION</th>
            <th scope="col">Option</th>

        </tr>
    </thead>
    <tbody>
        <tr v-for="(department, index) in departments" v-bind:key="index">
            <td>{{ index+1 }}</td>
            <td>{{ department.name }}</td>
            <td v-if="department.description==null">
                <h5>--</h5>
            </td>
            <td v-else>{{ department.description }}</td>
            <!--<td>  <input @onblur="update(task,$event.target.value)" >-
                      <a href="#" @click.prevent="updates(task)"><i class="fa fa-edit"></i></a>  </td>-->
            <td> <a href="#" @click.prevent="updateDepartment(department)"><i class="fa fa-edit"></i></a>
                <a href="#" @click.prevent="deleteDepartment(department)"><i class="fa fa-trash text-danger  ml-4"></i></a>
            </td>
        </tr>
    </tbody>
</table>
</div>
</template>

<script>
export default {
    // components: {
    // mynav,

    // },
    data() {
        return {
            department: {
                name: '',
                description: '',

            },
            showAlert: false,
            editMode: false,
            departments: [],
            mycategories: [],

        }

    },

    mounted() {

        this.getDepartments();

        //this.getCategories();
    },

    methods: {
        newItem() {

            this.editMode = false
            this.department = {
                name: '',
                description: '',
            
            }

            $("#taskmodal").modal("show");
        },

        updateDepartment(myitem) {
            //console.log(supplier);
            //this.item = ''
            this.editMode = true;
            $("#taskmodal").modal("show");
             this.department = myitem;

            // alert('hi boy')

        },

        deleteDepartment(myitem) {
            //this.editMode = false

             this.department.id = myitem.id;
            $("#deleteModal").modal("show");
        },

        saveDepartment() {

            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("http://127.0.0.1:8000/api/addDepartment", this.department).then(response => {

                this.$toast.success(`Saved successfully`, {
                    position: "top",
                    dismissible: false
                })
                $("#taskmodal").modal("hide");

                this.$emitter.emit('changeLoaderStatus', false);
                this.getDepartments();
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

                    this.$toast.error(`Server Error! try again!`, {
                            position: "top"

                        }

                    )
                }
                this.$emitter.emit('changeLoaderStatus', false)

            });
        },

        getDepartments() {
            this.$emitter.emit('changeLoaderStatus', true)
            axios.get("http://127.0.0.1:8000/api/getDepartments").then(response => {
                this.departments = response.data.data;

                this.$emitter.emit('changeLoaderStatus', false)
            })

        },

        editDepartment() {

            this.$emitter.emit('changeLoaderStatus', true)
            axios.patch("http://127.0.0.1:8000/api/updateDepartment/" + this.department.id, this.department).then(() => {

                this.$toast.success(`Updated successfully`,

                    {
                        position: "top",
                        dismissible: false

                    }

                )
                $("#taskmodal").modal("hide");

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

        removeDepartment() {
            this.$emitter.emit('changeLoaderStatus', true)
            // var data = new FormData(formOnes);
            axios.post("http://127.0.0.1:8000/api/deleteDepartment/" + this.department.id).then(response => {

                $("#deleteModal").modal("hide");
                this.departments = this.departments.filter((department) => department.id !== this.department.id);

                this.$toast.success(`Deleted successfully`, {
                    position: "top",
                    dismissible: false
                })

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

    },

}
</script>

<style></style>
