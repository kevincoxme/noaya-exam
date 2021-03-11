<template>
    <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ name }} employees <a class="btn btn-primary" href="/">Back</a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">First Name</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" required v-model="forms.first_name" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" required v-model="forms.last_name" aria-describedby="emailHelp" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" required v-model="forms.email" aria-describedby="emailHelp" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phone</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" required v-model="forms.phone" aria-describedby="emailHelp" placeholder="">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" @change="forms.active = !forms.active" :checked="forms.active" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div>
                                <button type="button" @click="saveEmployee()" class="btn btn-primary float-right">Submit</button>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <h5>Employee List</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Last Name</td>
                                                <td>Email</td>
                                                <td>Active</td>
                                                <td>Phone</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, i) in employees"
                                                :key="i">
                                                <td>{{ item.first_name }}</td>
                                                <td>{{ item.last_name }}</td>
                                                <td>{{ item.email }}</td>
                                                <td>{{ item.is_active | filterActive }}</td>
                                                <td>{{ item.phone }}</td>
                                                <td>
                                                    <button class="btn btn-xs btn-primary" @click="edit(item, i)">Edit</button>
                                                    <a :href="'/employee/preview/' + item.id" class="btn btn-xs btn-primary">Email Preview</a>
                                                    <button class="btn btn-xs btn-primary" @click="deleteItem(item, i)">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['companyId', 'name'],
        data(){
            return {
                forms:{
                    id: null,
                    first_name: null,
                    last_name: null,
                    email: null,
                    phone: null,
                    active: false,
                    company_id: 0,
                    index: null
                },
                employees: []
            }
        },
        created(){
            this.getEmployee()
        },
        methods:{
            getEmployee(){
                axios.get('/api/v1/company/employee/get/all/' + this.companyId).then(response => {
                    let data = response.data.response
                    this.employees = data
                })
            },
            saveEmployee(){

                if(this.forms.first_name == null)
                {
                    alert('First name is emapty')
                    return false;
                }
                else if(this.forms.last_name == null)
                {
                    alert('First name is emapty')
                    return false;
                }

                this.forms.company_id = this.companyId
                axios.post('/api/v1/company/employee/store', this.forms).then(response => {
                    let data = response.data.response
                    if(this.forms.id == null)
                    {
                        this.employees.unshift(data)
                    }
                    else
                    {
                        this.employees[this.forms.index].first_name = data.first_name
                        this.employees[this.forms.index].last_name = data.last_name
                        this.employees[this.forms.index].email = data.email
                        this.employees[this.forms.index].phone = data.phone
                        this.employees[this.forms.index].is_active = data.is_active
                    }
                });
            },
            edit(item, index)
            {
                this.forms.index = index
                this.forms.id = item.id
                this.forms.first_name = item.first_name
                this.forms.last_name = item.last_name
                this.forms.email = item.email
                this.forms.phone = item.phone
                this.forms.active = item.is_active
            },
            deleteItem(item, index)
            {
                axios.delete('/api/v1/company/employee/delete/' + item.id).then(response => {
                    this.employees.splice(index, 1);
                })
            }
        },
        filters:{
            filterActive(value)
            {
                if(value == 1)
                {
                    return 'Yes'
                }

                return 'No'
            }
        }
    }
</script>
<style scoped>
.mt-2{
    margin-top: 20px;
}
.hide {
    display: none;
}
</style>
