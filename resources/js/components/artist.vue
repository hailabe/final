<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Artist Table </h3>

                <div class="card-tools">
                     <button class="btn btn-success" @click="addmodal">Add Artist<i class="fas fa-user-plus fa-fw" ></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ArtistID</th>
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
                    <tr v-for="art in artist" :key="art.id">
                      <td>{{art.id}}</td>
                      <td>{{art.name}}</td>
                      <td>{{art.email}}</td>
                      <td>{{art.password}}</td>
                      <td>{{art.phoneNo}}</td>
                      <td>{{art.created_at | mydate }}</td>
                      <td>{{art.updated_at | mydate }}</td>
                      <td>
                          <a href="#" @click="editmodal(art)">
                                <i class="fa fa-edit blue"></i>
                          </a>
                            /
                          <a href="#" @click="deleteartist(art.id)">
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
        <div class="modal fade" id="Addartistmodal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="AddartistmodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode" id="AddartistmodalLabel"> Add New artist</h5>
                <h5 class="modal-title" v-show="editmode" id="AddartistmodalLabel">Update artist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editmode ? updateartist() : Addartist()">
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
                artist: {} ,
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
            updateartist(){
                this.form.put('api/artist/'+this.form.id)
                .then(()=>{
                    $('#Addartistmodal').modal('hide')
                    Swal.fire(
                        'Updated!',
                        'Artist has been Updated.',
                        'success'
                    )
                    Fire.$emit('Aftercreate');
                }).catch(()=>{
                    Swal.fire("Update Faild!","There was something wrong","warning");
                })
            },
            editmodal(art){
                this.editmode=true;
                this.form.reset();
                this.form.clear();
                $('#Addartistmodal').modal('show');
                this.form.fill(art);
            },
            addmodal(){
                this.editmode=false;
                this.form.reset();
                this.form.clear();
                $('#Addartistmodal').modal('show');    
            },
            deleteartist(id){
                
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
                            this.form.delete('api/artist/'+id).then(()=>{
                                    Swal.fire(
                                            'Deleted!',
                                            'Artist has been deleted.',
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
                axios.get("api/artist").then(({data})=>this.artist=data.data);

            },
            Addartist(){
                this.form.post('api/artist')
                .then(()=>{
                    Swal.fire({
                        title:'Excellent',
                        text:'Artist added Successfully',
                        icon:'success'
                    })

                    Fire.$emit('Aftercreate');
                    $('#Addartistmodal').modal('hide')
                    
                })
                .catch(()=>{

                })
            }
        },
        mounted() {
            console.log('Component mounted.')
            Fire.$on('searching',()=>{
                let query=this.$parent.search;
                axios.get('api/searchartist?q='+ query)
                .then(({data})=>{
                this.artist=data.data
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
