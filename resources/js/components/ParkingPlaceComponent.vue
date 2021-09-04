<template>
    <div class="clients">
        <h3>Parking Place</h3>
        <div class="card mt-5">
            <div class="card-header">
                Parking Place
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
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                {{parking_place.id}}
                            </td>
                            <td>
                                {{parking_place.number}}
                            </td>
                            <td>
                                {{parking_place.price}} $
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div v-if="parking_place.clients_history.length" class="card mt-5">
            <div class="card-header">
                Pick Up list
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                Client
                            </th>
                            <th>
                                Car type
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
                        <tr v-for="(pickUp,index) in parking_place.clients_history" :key="index">
                            <td>
                                <a :href="`/client/${pickUp.slug}`">{{pickUp.first_name}} {{pickUp.second_name}}</a>
                            </td>
                            <td>
                                {{pickUp.pivot.car_type}}
                            </td>
                            <td>
                                {{pickUp.pivot.start_parking}}
                            </td>
                            <td>
                                {{pickUp.pivot.end_parking}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['parking_place'],
    mounted() {
        console.log(this.parking_place)
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