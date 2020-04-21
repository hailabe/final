<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sales Staff Table</h3>

                <div class="card-tools">
                     <button class="btn btn-success" @click="addmodal">Add Staff <i class="fas fa-user-plus fa-fw" ></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Staff ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Password</th>
                      <th>Phone No</th>
                      <th>Registerd At</th>
                      <th>Updated At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="sales in salesstaff " :key="sales.id">
                      <td>{{sales.id}}</td>
                      <td>{{sales.name}}</td>
                      <td>{{sales.email}}</td>
                      <td>{{sales.password}}</td>
                      <td>{{sales.phoneNo}}</td>
                      <td>{{sales.created_at | mydate }}</td>
                      <td>{{sales.updated_at | mydate }}</td>
                      <td>
                          <a href="#" @click="editmodal(sales)">
                                <i class="fa fa-edit blue"></i>
                          </a>
                            /
                          <a href="#" @click="deletesales(sales.id)">
                                <i class="fa fa-trash blue"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-header">
                  
                <div class="card-tools">
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="Addstaffmodal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="AddstaffmodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode" id="AddstaffmodalLabel"> Add New Sales Staff</h5>
                <h5 class="modal-title" v-show="editmode" id="AddstaffmodalLabel">Update Sales Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editmode ? updatestaff() : Addsalesstaff()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" name="name"
                            placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input v-model="form.email" type="text" name="email"
                            placeholder="E-mail"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input v-model="form.password" type="password" name="password"
                            placeholder="Password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input v-model="form.phoneNo" type="text" name="phoneNo"
                            placeholder="Phone No."
                            class="form-control" :class="{ 'is-invalid': form.errors.has('phoneNo') }">
                        <has-error :form="form" field="phoneNo"></has-error>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" v-show="!editmode" class="btn btn-success">Create</button>
                    <button type="submit" v-show="editmode" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary">Clear</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                editmode:false,
                salesstaff : {} ,
                form:new Form({
                    created_at:'',
                    updated_at:'',
                    id:'',
                    name: '',
                    email: '',
                    password: '',
                    phoneNo: '',
                })
            }
        },
        methods:{
            updatestaff(){
                this.form.put('api/salesstaff/'+this.form.id)
                .then(()=>{
                    $('#Addstaffmodal').modal('hide')
                    Swal.fire(
                        'Updated!',
                        'Sales Staff has been Updated.',
                        'success'
                    )
                    Fire.$emit('Aftercreate');
                }).catch(()=>{
                    Swal.fire("Update Faild!","There was something wrong","warning");
                })
            },
            editmodal(sales){
                this.editmode=true;
                this.form.reset();
                this.form.clear();
                $('#Addstaffmodal').modal('show');
                this.form.fill(sales);
            },
            addmodal(){
                this.editmode=false;
                this.form.reset();
                this.form.clear();
                $('#Addstaffmodal').modal('show');    
            },
            deletesales(id){
                
                Swal.fire({
                    title:'Are you sure Delete ?',
                    text:"You won't be able to revert this",
                    icon:'warning',
                    showCancelButton:true,
                    confirmButtonColor:'#3085d6',
                    cancelButtonColor:'#d33',
                    confirmButtonText:'Yes,delete it!'
                }).then((result)=>{
                    if(result.value){
                            this.form.delete('api/salesstaff/'+id).then(()=>{
                                    Swal.fire(
                                            'Deleted!',
                                            'Sales Staff has been deleted.',
                                            'success'
                                        )
                        Fire.$emit('Aftercreate');
                        }).catch(()=>{
                            Swal.fire("Deletion Faild!","There was something wrong","warning");
                        });
                    }   
                }) 
                
            },
            loadData(){
                axios.get("api/salesstaff").then(({data})=>this.salesstaff=data.data);

            },
            Addsalesstaff(){
                this.form.post('api/salesstaff')
                .then(()=>{
                    Swal.fire({
                        title:'Excellent',
                        text:'Sales Staff added Successfully',
                        icon:'success'
                    })

                    Fire.$emit('Aftercreate');
                    $('#Addstaffmodal').modal('hide')
                    
                })
                .catch(()=>{

                })
            }
        },
        mounted() {
            console.log('Component mounted.')
            Fire.$on('searching',()=>{
                let query=this.$parent.search;
                axios.get('api/searchstaff?q='+ query)
                .then(({data})=>{
                this.salesstaff=data.data
                }).catch(()=>{

                })
            })
            
            this.loadData();
            Fire.$on('Aftercreate',()=>{
                this.loadData();
            });
        }
    }
</script>
