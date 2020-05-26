<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Album Table</h3>

                <div class="card-tools">
                     <button class="btn btn-success" @click="addmodal">Add album <i class="fas fa-user-plus fa-fw" ></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>album ID</th>
                      <th>Album Name</th>
                      <th>Album Artist</th>
                      <th>Producer</th>
                      <th>Realese Date</th>
                      <th>Album Price</th>
                      <th>Album Rating</th>
                      <th>Album Description</th>
                      <th>Album Art</th>
                      <th>Album Path</th>
                      <th>Created At</th>
                      <th>Updated at</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="albums in album " :key="albums.id">
                      <td>{{albums.id}}</td>
                      <td>{{albums.album_name}}</td>
                      <td>{{albums.album_artist}}</td>
                      <td>{{albums.producer}}</td>
                      <td>{{albums.realese_date}}</td>
                      <td>{{albums.price}}</td>
                      <td>{{albums.rating}}</td>
                      <td>{{albums.album_des}}</td>
                      <td>{{albums.album_art}}</td>
                      <td>{{albums.album_path}}</td>
                      <td>{{albums.created_at | mydate }}</td>
                      <td>{{albums.updated_at | mydate }}</td>
                      <td>
                          <a href="#" @click="editmodal(albums)">
                                <i class="fa fa-edit blue"></i>
                          </a>
                            /
                          <a href="#" @click="deletealbums(albums.id)">
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
        <div class="modal fade" id="Addalbummodal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="AddalbummodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode" id="AddalbummodalLabel"> Add New Album</h5>
                <h5 class="modal-title" v-show="editmode" id="AddalbummodalLabel">Update Album</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editmode ? updatealbum() : Addalbum()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Album Name</label>
                        <input v-model="form.name" type="text" name="album_name"
                            placeholder="Album_Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('album_name') }">
                        <has-error :form="form" field="album_name"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Album_Artist</label>
                        <input v-model="form.album_artist" type="text" name="album_artist"
                            placeholder="E-mail"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('album_artist') }">
                        <has-error :form="form" field="album_artist"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Producer</label>
                        <input v-model="form.producer" type="producer" name="producer"
                            placeholder="producer"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('producer') }">
                        <has-error :form="form" field="producer"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Realese Date</label>
                        <input v-model="form.realese_date" type="datetime" name="realese_date"
                            placeholder="Realese Date."
                            class="form-control" :class="{ 'is-invalid': form.errors.has('realese_date') }">
                        <has-error :form="form" field="realese_date"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Album Price</label>
                        <input v-model="form.album_price" type="text" name="album_price"
                            placeholder="Album Price."
                            class="form-control" :class="{ 'is-invalid': form.errors.has('album_price') }">
                        <has-error :form="form" field="album_price"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Album Rating</label>
                        <input v-model="form.album_rating" type="text" name="album_rating"
                            placeholder="Album Rating."
                            class="form-control" :class="{ 'is-invalid': form.errors.has('album_rating') }">
                        <has-error :form="form" field="album_rating"></has-error>
                    </div>

                    <div class="form-group">
                        <label>Album Description</label>
                        <textarea v-model="form.album_description" type="text" name="album_description"
                        class="form-control" rows="3" placeholder="Album Description"
                        :class="{ 'is-invalid': form.errors.has('album_description') }"></textarea>
                        <has-error :form="form" field="album_description"></has-error>
                    </div>

                    <div class="form-group">
                    <label for="exampleInputFile">Album Art</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile"></label>
                      </div>
                    </div>
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
                album : {} ,
                form:new Form({
                    created_at:'',
                    updated_at:'',
                    id:'',
                    album_name: '',
                    album_artist: '',
                    producer: '',
                    realese_date: '',
                    price: '',
                    rating: '',
                    album_des: '',
                    album_art: '',
                    album_path: '',
                })
            }
        },
        methods:{
            updatealbum(){
                this.form.put('api/album/'+this.form.id)
                .then(()=>{
                    $('#Addalbummodal').modal('hide')
                    Swal.fire(
                        'Updated!',
                        'Album has been Updated.',
                        'success'
                    )
                    Fire.$emit('Aftercreate');
                }).catch(()=>{
                    Swal.fire("Update Faild!","There was something wrong","warning");
                })
            },
            editmodal(albums){
                this.editmode=true;
                this.form.reset();
                this.form.clear();
                $('#Addalbummodal').modal('show');
                this.form.fill(albums);
            },
            addmodal(){
                this.editmode=false;
                this.form.reset();
                this.form.clear();
                $('#Addalbummodal').modal('show');    
            },
            deletealbums(id){
                
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
                            this.form.delete('api/album/'+id).then(()=>{
                                    Swal.fire(
                                            'Deleted!',
                                            'Album has been deleted.',
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
                axios.get("api/album").then(({data})=>this.album=data.data);

            },
            Addalbum(){
                this.form.post('api/album')
                .then(()=>{
                    Swal.fire({
                        title:'Excellent',
                        text:'Album added Successfully',
                        icon:'success'
                    })

                    Fire.$emit('Aftercreate');
                    $('#Addalbummodal').modal('hide')
                    
                })
                .catch(()=>{

                })
            }
        },
        mounted() {
            console.log('Component mounted.')
            Fire.$on('searching',()=>{
                let query=this.$parent.search;
                axios.get('api/searchalbum?q='+ query)
                .then(({data})=>{
                this.album=data.data
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
