<template>
    <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Companies
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Name</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" required v-model="forms.name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" required v-model="forms.email" aria-describedby="emailHelp" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Upload logo</label>
                                    <button @click="$refs.logo.click()" class="btn btn-sm btn-warning">Upload</button>
                                    <input type="file" class="hide" ref="logo">
                                </div>
                                <button type="button" @click="saveCompany()" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <h5>Company List</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Email</td>
                                                <td>Logo</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, i) in companies"
                                                :key="i">
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.email }}</td>
                                                <td><img :src="'/storage/' + item.logo " alt="" height="50"></td>
                                                <td>
                                                    <a :href="'/employee/' + item.id" class="btn btn-xs btn-primary">Employee</a>
                                                    <button class="btn btn-xs btn-primary" @click="edit(item, i)">Edit</button>
                                                    <button class="btn btn-xs btn-primary" @click="deleteCompany(item, i)">Delete</button>
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
        data(){
            return {
                forms:{
                    id: 0,
                    index: null,
                    name: null,
                    email: null,
                    logo: null
                },
                companies: []
            }
        },
        created(){
            this.getCompany()
        },
        methods:{
            getCompany(){
                axios.get('/api/v1/company/get/all').then(response => {
                    let data = response.data.response
                    this.companies = data
                })
            },
            saveCompany(){
                if(this.forms.name == null)
                {
                    alert('Name is empty')
                    return false
                }

                let formData = new FormData();
                formData.append('id', this.forms.id);
                formData.append('name', this.forms.name);
                formData.append('email', this.forms.email);
                formData.append('logo', this.$refs.logo.files[0]);

                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }

                axios.post('/api/v1/company/store', formData, config).then(response => {
                    let data = response.data.response
                    console.log(data)
                    if(this.forms.id == 0)
                    {
                        this.companies.unshift(data)
                    }
                    else
                    {
                        this.companies[this.forms.index].name = data.name
                        this.companies[this.forms.index].email = data.email
                        this.companies[this.forms.index].logo = data.logo
                    }
                });
            },
            edit(item, index){
                this.forms.index = index
                this.forms.id = item.id
                this.forms.name = item.name
                this.forms.email = item.email
                this.forms.logo = item.logo
            },
            deleteCompany(item, index)
            {
                axios.delete('/api/v1/company/delete/' + item.id).then(response => {
                    this.companies.splice(index, 1);
                })
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
