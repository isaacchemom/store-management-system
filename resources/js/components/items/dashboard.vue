<template>
<div id="layoutSidenav_content" style="background-image: url('/images/bgc.jpg');  height: 80vh;">
    <main>
        <div class="container-fluid">
           
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <h5>Items issued today</h5>

                            <h4>TOTAL :{{dailyItemCount}} </h4>
                            <div class='huge h5'> -</div>

                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">

                            <router-link to="/1/todayIssue" class="small text-white stretched-link">
                                <div class='huge'> </div>VIEW
                            </router-link>

                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body">
                            <h3>Stock summary</h3>

                            <h4>Total items : {{ItemCount}} </h4>
                            <div class='huge h5'> Cost : {{ totalAmounts }}</div>

                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">

                            <router-link to="/1/items" class="small text-white stretched-link">
                                <div class='huge'> </div>VIEW
                            </router-link>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            <h3>Suppliers</h3>

                            <h4>Total :{{suppliersCount}}</h4>
                            <div class='huge h5'> -</div>

                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">

                            <router-link to="/1/suppliers" class="small text-white stretched-link">
                                <div class='huge'> </div>VIEW
                            </router-link>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body">
                            <h3>Staff</h3>

                            <h4>Total :{{CategoryCount}}</h4>
                            <div class='huge h5'> - </div>

                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">

                            <router-link to="/1/staff" class="small text-white stretched-link">
                                <div class='huge'> </div>VIEW
                            </router-link>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</div>
</template>

<script>
export default {

    data() {

        return {

            showAlert: false,
            //  form: null,
            // edit: false,
            editMode: false,
            items: [],
            categories: [],
            DailyItems: [],

            suppliers: [],
            departments: [],
            staffs:[]

        }

    },

    computed: {
        totalAmounts() {

            return this.items.reduce((total, daysales) => total + (parseFloat(daysales.price) * parseFloat(daysales.quantity)), 0);
        },

        dailyItemCount() {
            return this.DailyItems.length;
        },
        suppliersCount() {
            return this.suppliers.length;
        },

        salecount() {

            return this.sales.length;
        },

        ItemCount() {

            return this.items.length;
        },

        CategoryCount() {

            return this.staffs.length;
        }

    },

    mounted() {
        this.getDailyItems();
        this.getCategories();
        this.getItems();
        this.getsuppliers();
        this.getStaff()
        //this.getCategories();
        // this.getSales();

    },

    methods: {

        getDailyItems() {
            // this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getDailyItems").then(response => {
                this.DailyItems = response.data.data;
                //  this.totalAmountsDaily();
                // this.$emitter.emit('changeLoaderStatus', false)

            })

        },
        getCategories() {
            // this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getCategories").then(response => {
                this.categories = response.data.data;

                //  this.$emitter.emit('changeLoaderStatus', false)
            })

        },
        getsuppliers() {
            // this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getsuppliers").then(response => {
                this.suppliers = response.data.data;

                // this.$emitter.emit('changeLoaderStatus', false)
            })

        },

        getItems() {
            this.$emitter.emit('changeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getItems").then(response => {
                this.items = response.data.data;

                this.$emitter.emit('changeLoaderStatus', false)
            })

        },
        getStaff() {
            this.$emitter.emit('mychangeLoaderStatus', true)
            axios.get("https://centralstore.chukahighschool.sc.ke/api/getStaff").then(response => {
                this.staffs = response.data.data;

                this.$emitter.emit('mychangeLoaderStatus', false)
            })

        },

    },

}
</script>
