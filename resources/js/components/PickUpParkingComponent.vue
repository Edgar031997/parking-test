<template>
    <div class="pickUp">
        <h3>Pick Up</h3>
        <div class="card">
            <div class="card-header">
                Pick Up new parking place
            </div>
            <div class="card-body">
                <form class="form" @submit.prevent="onSubmit">
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Client</label>
                            <select class="form-control ml-sm-2 mr-sm-4 my-2" v-model="createPickUp.client_id">
                                <option></option>
                                <option v-for="client in clients" :key="`client${client.id}`" :value="client.id">{{client.first_name}} {{client.second_name}}</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Parking</label>
                            <select class="form-control ml-sm-2 mr-sm-4 my-2" v-model="createPickUp.parking_id">
                                <option></option>
                                <option v-for="parking in parking_places" :key="`parking${parking.id}`" :value="parking.id"><span>Number - </span>{{parking.number}} <span>Price - </span>{{parking.price}} $</option>
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Car type</label>
                            <input v-model="createPickUp.car_type" type="text" class="form-control ml-sm-2 mr-sm-4 my-2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label>Start</label>
                            <date-picker v-model="createPickUp.start_parking" valueType="format" type="datetime"></date-picker>
                        </div>
                        <div class="form-group col-3">
                            <label>End</label>
                            <br/>
                            <date-picker v-model="createPickUp.end_parking" valueType="format" type="datetime"></date-picker>
                        </div>
                        <div class="ml-auto text-right m-4">
                            <button type="submit" class="btn btn-primary my-2">Pick Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="errorsGetter" class="card mt-5">
            <p v-for="err in errorsGetter" class="w-auto alert alert-danger">{{err}}</p>
        </div>
        <div v-if="pickUpData.data.length" class="card mt-5">
            <div class="card-header">
                Pick Up list
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
                                Client
                            </th>
                            <th>
                                Parking
                            </th>
                            <th>
                                Car type
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Start
                            </th>
                            <th>
                                End
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pickUp in pickUpData.data" :key="`pickUp${pickUp.id}`">
                                <td>
                                    {{pickUp.id}}
                                </td>
                                <td>
                                    <a :href="`/client/${pickUp.client.slug}`">{{pickUp.client.first_name}} {{pickUp.client.second_name}}</a>
                                </td>
                                <td>
                                    <a :href="`/parking/${pickUp.parking.id}`">{{pickUp.parking.number}}</a>
                                </td>
                                <td>
                                    {{pickUp.car_type}}
                                </td>
                                <td>
                                    {{pickUp.parking.price}} $
                                </td>
                                <td>
                                    {{pickUp.start_parking}}
                                </td>
                                <td>
                                    {{pickUp.end_parking}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="pickUpData" @pagination-change-page="paginate"></pagination>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapActions,mapGetters} from "vuex"
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
    props:['pick_up_parking_places','clients','parking_places'],
    components:{DatePicker},
    data () {
        return {
            pickUpData: this.pick_up_parking_places,
            createPickUp:{
                client_id : '',
                parking_id : '',
                car_type : '',
                start_parking: '',
                end_parking : ''
            }
        }
    },
    computed:{
        ...mapGetters(['errorsGetter']),
    },
    methods:{
        ...mapActions(['getErrors','clearErrors']),
        paginate($page) {
            axios.get(`/pick-up-parking?page=${$page}`).then((response)=>{
                this.pickUpData = response.data
            },(xhr)=>{
                this.getErrors(xhr)
            })
        },
        onSubmit(){
            this.clearErrors()
            axios.post('/pick-up-parking',this.createPickUp).then(()=>{
                this.paginate(1)
                this.createPickUp.client_id = ''
                this.createPickUp.parking_id = ''
                this.createPickUp.car_type = ''
                this.createPickUp.start_parking = ''
                this.createPickUp.end_parking = ''
            },(xhr)=>{
                this.getErrors(xhr)
            })

        },
        onDelete(id){
            this.clearErrors()
            if(confirm("Want to delete?")){
                axios.delete(`/pick-up-parking/${id}`,).then(()=>{
                    this.paginate(this.pickUpData.current_page)
                },(xhr)=>{
                    this.getErrors(xhr)
                })
            }
        },
    },
    mounted() {
        console.log(this.pick_up_parking_places,this.parking_places,this.clients)
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