<template>
    <div class="clients">
        <h3>Parking Places</h3>
        <div class="card">
            <div class="card-header">
                Add a new place
            </div>
            <div class="card-body">
                <form class="form-row" @submit.prevent="onSubmit">
                    <div class="form-group col-3">
                        <label>Number</label>
                        <input v-model="createPlace.number" type="text" class="form-control ml-sm-2 mr-sm-4 my-2">
                    </div>
                    <div class="form-group col-3">
                        <label>Price</label>
                        <input v-model="createPlace.price" type="text" class="form-control ml-sm-2 mr-sm-4 my-2">
                    </div>
                    <div class="ml-auto text-right m-4">
                        <button type="submit" class="btn btn-primary my-2">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="errorsGetter" class="card mt-5">
            <p v-for="err in errorsGetter" class="w-auto alert alert-danger">{{err}}</p>
        </div>
        <div v-if="placeData.data.length" class="card mt-5">
            <div class="card-header">
                Parking places list
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                ID
                            </th>
                            <th>
                                Number
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="place in placeData.data" v-bind:key="place.id">
                            <template v-if="editId == place.id">
                                <td>{{ editId }}</td>
                                <td><input v-model="editPlace.number" type="text"></td>
                                <td><input v-model="editPlace.price" type="text"></td>
                                <td>
                                    <button @click="onEditSubmit(place.id)" class="btn btn-success">
                                        <span class="icon">
                                        <i   class="bi-check"></i>
                                    </span>
                                    </button>
                                    <button @click="onCancel" class="btn btn-dark">
                                        <span class="icon">
                                            <i   class="bi-backspace-reverse"></i>
                                        </span>
                                    </button>
                                </td>
                            </template>
                            <template v-else>
                                <td>
                                    {{place.id}}
                                </td>
                                <td>
                                    {{place.number}}
                                </td>
                                <td>
                                    {{place.price}} $
                                </td>
                                <td>
                                    <button @click="onDelete(place.id)" class="btn btn-danger icon">
                                        <i class="bi-trash"></i>
                                    </button>
                                    <button @click="onEdit(place)" class="btn btn-warning icon">
                                        <i class="bi-pencil"></i>
                                    </button>
                                    <a :href="`/parking/${place.id}`" class="icon">
                                        <button class="btn btn-primary">
                                            <i class="bi-eye"></i>
                                        </button>
                                    </a>
                                </td>
                            </template>
                        </tr>

                        </tbody>
                    </table>
                    <pagination :data="placeData" @pagination-change-page="paginate"></pagination>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapActions,mapGetters} from "vuex"
import VueTheMask from 'vue-the-mask'

export default {
    props:['parking_places'],
    components:{VueTheMask},
    data () {
        return {
            editId: '',
            placeData: this.parking_places,
            createPlace: {
                number: '',
                price: '',
            },
            editPlace: {
                number: '',
                price: '',
            },
        }
    },
    computed:{
        ...mapGetters(['errorsGetter']),
    },
    methods:{
        ...mapActions(['getErrors','clearErrors']),
        paginate($page) {
            axios.get(`/parking?page=${$page}`).then((response)=>{
                this.placeData = response.data
            },(xhr)=>{
                this.getErrors(xhr)
            })
        },
        onSubmit(){
            this.clearErrors()
            axios.post('/parking',this.createPlace).then(()=>{
                this.paginate(1)
                this.createPlace.number = ''
                this.createPlace.price = ''
            },(xhr)=>{
                this.getErrors(xhr)
            })

        },
        onDelete(id){
            this.clearErrors()
            if(confirm("Want to delete?")){
                axios.delete(`/parking/${id}`,).then(()=>{
                    this.paginate(this.placeData.current_page)
                },(xhr)=>{
                    this.getErrors(xhr)
                })
            }
        },
        onEdit(place){
            this.editId = place.id
            this.editPlace.number = place.number
            this.editPlace.price = place.price
        },
        onEditSubmit (id){
            this.clearErrors()
            axios.put(`/parking/${id}`,this.editPlace).then(()=>{
                this.paginate(this.placeData.current_page)
                this.onCancel()
            },(xhr)=>{
                this.getErrors(xhr)
            })
        },
        onCancel(){
            this.editId = ''
            this.editPlace.number = ''
            this.editPlace.price = ''
        },
    }
}
</script>

<style scoped>
h3{
    text-align: center;
    margin-top: 30px;
    margin-bottom: 20px;
}
.icon{
    margin-right: 10px;
}
</style>